<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { SectionData } from '~/server/types/section';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;

    scoutGroup?: ScoutGroupData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const search = ref<string>('');

const { useListSections } = useSection();
const {
  displaySections,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListSections(search, {
  scoutGroup: props.scoutGroup,
});

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<SectionData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(section: SectionData) {
  itemToUpdate.value = section;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<SectionData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(section: SectionData) {
  itemToDelete.value = section;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'Name', key: 'name' },
  { title: 'Group', key: 'scoutGroup.name' },
  { title: 'Actions', key: 'actions', sortable: false, fixed: true },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'sectionListColumns',
  headers,
  ['id', 'name', 'scoutGroup.name', 'actions']
);
const uiTableControls = useUiTableControls();
const tableControlDialog = ref<boolean>(false);

const itemsPerPageOptions = [
  { value: 5, title: '5' },
  { value: 10, title: '10' },
  { value: 25, title: '25' },
  { value: 50, title: '50' },
  { value: 100, title: '100' },
];
</script>

<template>
  <div>
    <SectionsCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></SectionsCreate>

    <SectionsUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :section="itemToUpdate"
    ></SectionsUpdate>

    <SectionsDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :section="itemToDelete"
    ></SectionsDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displaySections"
      :loading="loading"
      v-model:items-per-page="uiPageControls.pageSize.value"
      :items-length="uiPageControls.totalItems.value"
      :search="search"
      @update:options="uiPageControls.updateOptions"
      :items-per-page-options="itemsPerPageOptions"
    >
      <template v-slot:loading>
        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Sections</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find Section"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

          <v-btn
            v-if="props.allowCreation"
            color="success"
            icon="mdi-account-plus"
            v-tooltip="'Create local section'"
            @click="itemCreate"
          ></v-btn>

          <!-- <section-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-section-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></section-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/sections/${item.id}`">{{ item.id }}</NuxtLink>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-btn variant="text" icon="mdi-eye" :to="`/sections/${item.id}`" />
        <v-btn variant="text" icon="mdi-pencil" @click="itemUpdate(item)" />
        <v-btn variant="text" icon="mdi-delete" @click="itemDelete(item)" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
