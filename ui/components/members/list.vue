<script setup lang="ts">
import type { MemberData } from '~/server/types/member';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;

    role?: RoleData;
    section?: SectionData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const { useListMembers } = useMember();
const {
  displayMembers,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListMembers({
  role: props.role,
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

const itemToUpdate = ref<MemberData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(member: MemberData) {
  itemToUpdate.value = member;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<MemberData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(member: MemberData) {
  itemToDelete.value = member;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const exportDialog = ref<boolean>(false);

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  { title: 'State', key: 'state', filterable: true },
  { title: 'MState', key: 'managementState', filterable: true },
  { title: 'Firstname', key: 'firstname', filterable: true },
  { title: 'Nickname', key: 'nickname', filterable: true },
  { title: 'Lastname', key: 'lastname', filterable: true },
  { title: 'Membership Number', key: 'membershipNumber', filterable: true },
  {
    title: 'Address',
    key: 'address',
    value: (item: MemberData) => $filters.address(item.address),
    filterable: true,
  },
  {
    title: 'Date of Birth',
    key: 'dateOfBirth',
    value: (item: MemberData) => $filters.date(item.dateOfBirth),
  },
  {
    title: 'Age',
    key: 'age',
    value: (item: MemberData) => $filters.duration(item.dateOfBirth),
  },
  { title: 'Email', key: 'email', filterable: true },
  { title: 'Home Phone', key: 'phoneHome', filterable: true },
  { title: 'Mobile Phone', key: 'phoneMobile', filterable: true },
  { title: 'Work Phone', key: 'phoneWork', filterable: true },
  { title: 'Gender', key: 'gender', filterable: true },
  { title: 'School Name', key: 'schoolName', filterable: true },
  { title: 'School Year Level', key: 'schoolYearLevel', filterable: true },
  {
    title: 'Auto Upgrade Enabled',
    key: 'autoUpgradeEnabled',
    value: (item: MemberData) => (item.autoUpgradeEnabled ? 'Yes' : 'No'),
    filterable: true,
  },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'memberListColumns',
  headers,
  [
    'firstname', //wrap
    'lastname',
    'email',
    'gender',
    'membershipNumber',
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
    <MembersDialogCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></MembersDialogCreate>

    <MembersDialogUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :member="itemToUpdate"
    ></MembersDialogUpdate>

    <MembersDialogDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :member="itemToDelete"
    ></MembersDialogDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayMembers"
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
          <v-toolbar-title>Members</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="uiPageControls.search.value"
            label="Find Member"
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
            v-tooltip="'Create local member'"
            @click="itemCreate"
          ></v-btn>

          <ExportMember
            v-model="exportDialog"
            :controls="uiTableControls"
            :filters="{
              role: props.role,
              section: props.section,
            }"
          ></ExportMember>

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
        <NuxtLink :to="`/members/${item.id}`">{{ item.id }}</NuxtLink>
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

      <template v-slot:item.actionButtons="{ item }">
        <TableActionButtons
          :view="relationUrl('Member', item.id)"
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
