<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListMemberData } from '~/server/types/listMember';

const props = withDefaults(
  defineProps<{
    searchable?: boolean;
    trackParams?: boolean;

    list: ListData;
    // role?: RoleData;
    // section?: SectionData;
  }>(),
  {
    searchable: false,
    trackParams: false,
  }
);

const { useListListMembers } = useListMember();
const {
  displayListMembers,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListListMembers(
  props.list,
  {
    // role: props.role,
    // section: props.section,
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

const itemToUpdate = ref<ListMemberData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(listListMember: ListMemberData) {
  itemToUpdate.value = listListMember;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<ListMemberData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(listListMember: ListMemberData) {
  itemToDelete.value = listListMember;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  {
    title: 'Type',
    key: 'type',
    value(item: ListMemberData) {
      if (item.type === 'member') {
        return 'Member';
      } else if (item.type === 'contact') {
        return 'Contact';
      }
    },
    filterable: true,
  },
  { title: 'Name', key: 'name', filterable: true },
  { title: 'Address', key: 'address', filterable: true },
  { title: 'List', key: 'list', filterable: true },
  { title: 'Rules', key: 'contributingRuleIds' },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'listListMemberListColumns',
  headers,
  [
    'type', //wrap
    'name',
    'address',
    'list',
    'contributingRuleIds',
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

const { getListRule } = useListRule();
</script>

<template>
  <div>
    <v-data-table-server
      :headers="shownHeaders"
      :items="displayListMembers"
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
          <v-toolbar-title>List Recipients</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="uiPageControls.search.value"
            label="Find Recipient"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

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

      <template v-slot:item.list="{ item }">
        <span>{{ item.listName }}</span>
        <br />
        <NuxtLink :to="`/lists/${item.listAddress}`">
          {{ item.listAddress }}
        </NuxtLink>
      </template>
      <template v-slot:item.contributingRuleIds="{ item }">
        <span v-for="ruleId in item.contributingRuleIds" :key="ruleId">
          <span v-if="getListRule(ruleId).value !== null">
            {{ getListRule(ruleId).value?.label }}
          </span>
          <br />
        </span>
      </template>

      <template v-slot:no-data>
        <v-btn color="primary" @click="refresh">No Data: Refresh</v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
