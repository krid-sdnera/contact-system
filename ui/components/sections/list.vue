<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { SectionData } from '~/server/types/section';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;
    trackParams?: boolean;

    scoutGroup?: ScoutGroupData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
    trackParams: false,
  }
);

const { useListSections } = useSection();
const {
  displaySections,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListSections(
  {
    scoutGroup: props.scoutGroup,
  },
  props.trackParams
);

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
  { title: 'ID', key: 'id' },
  { title: 'Name', key: 'name', filterable: true },
  { title: 'Group', key: 'scoutGroup.name' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'sectionListColumns',
  headers,
  [
    'name', //wrap
    'scoutGroup.name',
    'actionButtons',
  ]
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
    <SectionsDialogCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></SectionsDialogCreate>

    <SectionsDialogUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :section="itemToUpdate"
    ></SectionsDialogUpdate>

    <SectionsDialogDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :section="itemToDelete"
    ></SectionsDialogDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displaySections"
      :loading="loading"
      v-model:items-per-page="uiPageControls.pageSize.value"
      :items-length="uiPageControls.totalItems.value"
      :search="uiPageControls.search.value"
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
            v-model="uiPageControls.search.value"
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
            icon="mdi-account-multiple-plus"
            v-tooltip="'Create local section'"
            @click="itemCreate"
          ></v-btn>

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template
        v-for="(header, i) in headers"
        v-slot:[`header.${header.key}`]="{
          column,
          toggleSort,
          getSortIcon,
          isSorted,
        }"
      >
        <TableHeaderCell
          :header="{ column, toggleSort, getSortIcon, isSorted }"
          :filters="uiPageControls.filters"
        ></TableHeaderCell>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/sections/${item.id}`">{{ item.id }}</NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <TableActionButtons
          :view="relationUrl('Section', item.id)"
          update
          @update="itemUpdate(item)"
          delete
          @delete="itemDelete(item)"
        ></TableActionButtons>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="refresh">No Data: Refresh</v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
