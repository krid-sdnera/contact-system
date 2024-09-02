<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;
    trackParams?: boolean;

    role?: RoleData;
    section?: SectionData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
    trackParams: false,
  }
);

const { useListLists } = useList();
const { displayLists, uiPageControls, refresh, loading, error, errorMessage } =
  useListLists(props.trackParams);

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<ListData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(list: ListData) {
  itemToUpdate.value = list;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<ListData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(list: ListData) {
  itemToDelete.value = list;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  { title: 'Address', key: 'address', filterable: true },
  { title: 'Name', key: 'name', filterable: true },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'listListColumns',
  headers,
  [
    'address', //wrap
    'name',
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
    <ListsDialogCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></ListsDialogCreate>

    <ListsDialogUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :list="itemToUpdate"
    ></ListsDialogUpdate>

    <ListsDialogDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :list="itemToDelete"
    ></ListsDialogDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayLists"
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
          <v-toolbar-title>Lists</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="uiPageControls.search.value"
            label="Find List"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

          <v-btn
            v-if="props.allowCreation"
            color="success"
            icon="mdi-email-plus"
            v-tooltip="'Create local list'"
            @click="itemCreate"
          ></v-btn>

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:headers="{ columns, isSorted, getSortIcon, toggleSort }">
        <TableHeaderRow
          :header="{ columns, toggleSort, getSortIcon, isSorted }"
          :filters="uiPageControls.filters"
        ></TableHeaderRow>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/lists/${item.id}`">{{ item.id }}</NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <TableActionButtons
          :view="relationUrl('EmailList', item.id)"
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
