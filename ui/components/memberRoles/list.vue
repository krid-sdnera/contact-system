<script setup lang="ts">
import type { MemberData } from '~/server/types/member';
import type { MemberRoleData } from '~/server/types/memberRole';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    trackParams?: boolean;

    member: MemberData;
  }>(),
  {
    allowCreation: false,
    trackParams: false,
  }
);

const { useListMemberRoles } = useMemberRole();
const {
  displayMemberRoles,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListMemberRoles({ member: props.member }, props.trackParams);

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: string) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<MemberRoleData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(memberRole: MemberRoleData) {
  itemToUpdate.value = memberRole;
  dialogUpdate.value = true;
}
function itemUpdated(id: string) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<MemberRoleData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(memberRole: MemberRoleData) {
  itemToDelete.value = memberRole;
  dialogDelete.value = true;
}
function itemDeleted(id: string) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  {
    title: 'State',
    key: 'state',
    filterable: true,
    typeConfig: {
      type: 'enum',
      choices: [
        { title: 'Enabled', value: 'enabled' },
        { title: 'Disabled', value: 'disabled' },
      ],
    },
  },
  {
    title: 'Managment State',
    key: 'managementState',
    filterable: true,
    typeConfig: {
      type: 'enum',
      choices: [
        { title: 'Unmanaged', value: 'unmanaged' },
        { title: 'Managed', value: 'managed' },
      ],
    },
  },
  {
    title: 'Expiry',
    key: 'expiry',
    value: (item: MemberRoleData) => $filters.date(item.expiry),
  },
  { title: 'Member', key: 'memberId', filterable: true },
  { title: 'Role', key: 'role' },
  { title: 'Section', key: 'section' },
  { title: 'Group', key: 'scoutGroup' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'memberRoleListColumns',
  headers,
  [
    'state', //wrap
    'managementState',
    'expiry',
    'memberId',
    'role',
    'section',
    'scoutGroup',
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
    <MemberRolesDialogCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
      :member="props.member"
    ></MemberRolesDialogCreate>

    <MemberRolesDialogUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :memberRole="itemToUpdate"
    ></MemberRolesDialogUpdate>

    <MemberRolesDialogDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :memberRole="itemToDelete"
    ></MemberRolesDialogDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayMemberRoles"
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
          <v-toolbar-title>Assigned Roles</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            v-if="props.allowCreation"
            color="success"
            icon="mdi-hamburger-plus"
            v-tooltip="'Create local member role'"
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

      <template v-slot:item.state="{ item }">
        <v-chip :color="getStateColor(item.state)">
          {{ item.state }}
        </v-chip>
      </template>
      <template v-slot:item.managementState="{ item }">
        <v-chip :color="getMStateColor(item.managementState)">
          {{ item.managementState }}
        </v-chip>
      </template>

      <template v-slot:item.memberId="{ item }">
        <NuxtLink :to="`/members/${item.memberId}`">{{
          item.memberId
        }}</NuxtLink>
      </template>
      <template v-slot:item.role="{ item }">
        <NuxtLink :to="`/roles/${item.role.id}`">{{ item.role.name }}</NuxtLink>
      </template>
      <template v-slot:item.section="{ item }">
        <NuxtLink :to="`/sections/${item.role.section.id}`">{{
          item.role.section.name
        }}</NuxtLink>
      </template>
      <template v-slot:item.scoutGroup="{ item }">
        <NuxtLink :to="`/groups/${item.role.section.scoutGroup.id}`">{{
          item.role.section.scoutGroup.name
        }}</NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <TableActionButtons
          clone
          @clone="itemUpdate(item)"
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
