<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListMemberData } from '~/server/types/listMember';

const props = withDefaults(
  defineProps<{
    searchable?: boolean;

    list: ListData;
    // role?: RoleData;
    // section?: SectionData;
  }>(),
  {
    searchable: false,
  }
);

const search = ref<string>('');

const { useListListMembers } = useListMember();
const {
  displayListMembers,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListListMembers(props.list, search, {
  // role: props.role,
  // section: props.section,
});

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
  { title: 'ID', key: 'id', fixed: true },
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
  },
  { title: 'Name', key: 'name' },
  { title: 'Address', key: 'address' },
  { title: 'List', key: 'list' },
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
      :search="search"
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
            v-model="search"
            label="Find Recipient"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

          <!-- <listListMember-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-listListMember-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></listListMember-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
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
