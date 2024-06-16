<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const search = ref<string>('');

const { useListScoutGroups } = useScoutGroup();
const {
  displayScoutGroups,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListScoutGroups(search);

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<ScoutGroupData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(scoutGroup: ScoutGroupData) {
  itemToUpdate.value = scoutGroup;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<ScoutGroupData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(scoutGroup: ScoutGroupData) {
  itemToDelete.value = scoutGroup;
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
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'scoutGroupListColumns',
  headers,
  [
    'name', //wrap
    'actionButtons',
  ]
);
const uiTableControls = useUiTableControls();
const tableControlDialog = ref<boolean>(false);

function getStateColor(state: 'enabled' | 'disabled'): string {
  return state === 'enabled' ? 'green' : 'orange';
}
function getMStateColor(state: 'managed' | 'unmanaged'): string {
  return state === 'managed' ? 'green' : 'orange';
}

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
    <ScoutGroupsCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></ScoutGroupsCreate>

    <ScoutGroupsUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :scoutGroup="itemToUpdate"
    ></ScoutGroupsUpdate>

    <ScoutGroupsDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :scoutGroup="itemToDelete"
    ></ScoutGroupsDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayScoutGroups"
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
          <v-toolbar-title>ScoutGroups</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find ScoutGroup"
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
            v-tooltip="'Create local scoutGroup'"
            @click="itemCreate"
          ></v-btn>

          <!-- <scoutGroup-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-scoutGroup-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></scoutGroup-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/groups/${item.id}`">{{ item.id }}</NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <v-btn variant="text" icon="mdi-eye" :to="`/groups/${item.id}`" />
        <v-btn variant="text" icon="mdi-pencil" @click="itemUpdate(item)" />
        <v-btn variant="text" icon="mdi-delete" @click="itemDelete(item)" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
