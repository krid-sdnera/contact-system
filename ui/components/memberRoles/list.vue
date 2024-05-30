<script setup lang="ts">
import type { MemberData } from '~/server/types/member';
import type { MemberRoleData } from '~/server/types/memberRole';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;

    member: MemberData;
  }>(),
  {
    allowCreation: false,
  }
);

const search = ref<string>('');

const { useListMemberRoles } = useMemberRole();
const {
  displayMemberRoles,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListMemberRoles(search, {
  member: props.member,
});

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
function itemUpdated(id: number) {
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

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'State', key: 'state' },
  { title: 'MState', key: 'managementState' },
  { title: 'Expiry', key: 'expiry' },
  { title: 'Member', key: 'memberId' },
  { title: 'Role', key: 'role' },
  { title: 'Section', key: 'section' },
  { title: 'Group', key: 'scoutGroup' },
  { title: 'Actions', key: 'actions', sortable: false, fixed: true },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'memberRoleListColumns',
  headers,
  [
    'id',
    'state',
    'managementState',
    'expiry',
    'memberId',
    'role',
    'section',
    'scoutGroup',
    'actions',
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
    <MemberRolesCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
      :member="props.member"
    ></MemberRolesCreate>

    <MemberRolesDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :memberRole="itemToDelete"
    ></MemberRolesDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayMemberRoles"
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
          <v-toolbar-title>MemberRoles</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            v-if="props.allowCreation"
            color="success"
            icon="mdi-account-plus"
            v-tooltip="'Create local memberRole'"
            @click="itemCreate"
          ></v-btn>

          <!-- <memberRole-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-memberRole-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></memberRole-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
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

      <template v-slot:item.actions="{ item }">
        <v-btn variant="text" icon="mdi-pencil" @click="itemUpdate(item)" />
        <v-btn variant="text" icon="mdi-delete" @click="itemDelete(item)" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
