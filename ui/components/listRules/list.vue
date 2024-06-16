<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListRuleData } from '~/server/types/listRule';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;

    list?: ListData;

    relation?: RuleRelationProp;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const search = ref<string>('');

const { useListListRules } = useListRule();
const {
  displayListRules,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListListRules(
  search,
  props.list
    ? {
        list: props.list,
      }
    : { relation: props.relation ?? {} }
);

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<ListRuleData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(listRule: ListRuleData) {
  itemToUpdate.value = listRule;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<ListRuleData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(listRule: ListRuleData) {
  itemToDelete.value = listRule;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'Label', key: 'label' },
  { title: 'Comment', key: 'comment' },
  { title: 'List', key: 'list' },
  { title: 'Linked to', key: 'relation' },
  { title: 'Use Member', key: 'useMember' },
  { title: 'Use Contact', key: 'useContact' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'listRuleListColumns',
  headers,
  [
    'label', //wrap
    'comment',
    'list',
    'relation',
    'useMember',
    'useContact',
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
    <ListRulesCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
      :relation="props.relation"
    ></ListRulesCreate>

    <ListRulesUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :listRule="itemToUpdate"
    ></ListRulesUpdate>

    <ListRulesDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :listRule="itemToDelete"
    ></ListRulesDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayListRules"
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
          <v-toolbar-title>ListRules</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find ListRule"
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
            v-tooltip="'Create local listRule'"
            @click="itemCreate"
          ></v-btn>

          <!-- <listRule-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-listRule-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></listRule-export> -->

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
        <NuxtLink :to="`/lists/${item.listId}`">
          {{ item.listAddress }}
        </NuxtLink>
      </template>

      <template v-slot:item.relation="{ item }">
        <span v-if="item.relationType === 'None'">No relation</span>
        <template v-else>
          <span>{{ item.relationType }}</span>
          <br />
          <NuxtLink
            :to="`/${relationPath(item.relationType)}/${item.relationId}`"
          >
            {{ item.relationName }}
          </NuxtLink>
        </template>
      </template>

      <template v-slot:item.useMember="{ item }">
        <v-icon v-if="item.useMember" colour="green" icon="mdi-check" />
        <v-icon v-else colour="red" icon="mdi-close" />
      </template>
      <template v-slot:item.useContact="{ item }">
        <v-icon v-if="item.useContact" colour="green" icon="mdi-check" />
        <v-icon v-else colour="red" icon="mdi-close" />
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <v-btn variant="text" icon="mdi-pencil" @click="itemUpdate(item)" />
        <v-btn variant="text" icon="mdi-delete" @click="itemDelete(item)" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
