<script setup lang="ts">
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;

    section?: SectionData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const search = ref<string>('');

const { useListRoles } = useRole();
const { displayRoles, uiPageControls, refresh, loading, error, errorMessage } =
  useListRoles(search, {
    section: props.section,
  });

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<RoleData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(role: RoleData) {
  itemToUpdate.value = role;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<RoleData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(role: RoleData) {
  itemToDelete.value = role;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'Name', key: 'name' },
  { title: 'Section', key: 'section.name' },
  { title: 'Group', key: 'section.scoutGroup.name' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'roleListColumns',
  headers,
  [
    'name', //wrap
    'section.name',
    'section.scoutGroup.name',
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
    <RolesCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></RolesCreate>

    <RolesUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :role="itemToUpdate"
    ></RolesUpdate>

    <RolesDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :role="itemToDelete"
    ></RolesDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayRoles"
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
          <v-toolbar-title>Roles</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find Role"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

          <v-btn
            v-if="props.allowCreation"
            color="success"
            icon="mdi-hamburger-plus"
            v-tooltip="'Create local role'"
            @click="itemCreate"
          ></v-btn>

          <!-- <role-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-role-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></role-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/roles/${item.id}`">{{ item.id }}</NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <TableActionButtons
          :view="relationUrl('Role', item.id)"
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
