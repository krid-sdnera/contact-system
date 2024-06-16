<script setup lang="ts">
import type { ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';

const props = withDefaults(
  defineProps<{
    allowCreation?: boolean;
    searchable?: boolean;

    member?: MemberData;
  }>(),
  {
    allowCreation: false,
    searchable: false,
  }
);

const search = ref<string>('');

const { useListContacts } = useContact();
const {
  displayContacts,
  uiPageControls,
  refresh,
  loading,
  error,
  errorMessage,
} = useListContacts(search, {
  member: props.member,
});

const dialogCreate = ref(false);
function itemCreate() {
  dialogCreate.value = true;
}
function itemCreated(newId: number) {
  dialogCreate.value = false;
  refresh();
}

const itemToUpdate = ref<ContactData | null>(null);
const dialogUpdate = ref<boolean>(false);
function itemUpdate(contact: ContactData) {
  itemToUpdate.value = contact;
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
  refresh();
}

const itemToDelete = ref<ContactData | null>(null);
const dialogDelete = ref<boolean>(false);
function itemDelete(contact: ContactData) {
  itemToDelete.value = contact;
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
  refresh();
}

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'State', key: 'state' },
  { title: 'MState', key: 'managementState' },
  { title: 'Firstname', key: 'firstname' },
  { title: 'Nickname', key: 'nickname' },
  { title: 'Lastname', key: 'lastname' },
  { title: 'Parent ID', key: 'parentId' },
  {
    title: 'Address',
    key: 'address',
    value: (item: ContactData) => $filters.address(item.address),
  },

  { title: 'Email', key: 'email' },
  { title: 'Home Phone', key: 'phoneHome' },
  { title: 'Mobile Phone', key: 'phoneMobile' },
  { title: 'Work Phone', key: 'phoneWork' },
  { title: 'Relationship', key: 'relationship' },
  { title: 'Occupation', key: 'occupation' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'contactListColumns',
  headers,
  [
    'firstname', //wrap
    'lastname',
    'relatioship',
    'state',
    'managementState',
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
    <ContactsCreate
      v-if="props.allowCreation"
      v-model="dialogCreate"
      @created="itemCreated"
    ></ContactsCreate>

    <ContactsUpdate
      v-if="itemToUpdate !== null"
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :contact="itemToUpdate"
    ></ContactsUpdate>

    <ContactsDelete
      v-if="itemToDelete !== null"
      v-model="dialogDelete"
      @deleted="itemDeleted"
      :contact="itemToDelete"
    ></ContactsDelete>

    <v-data-table-server
      :headers="shownHeaders"
      :items="displayContacts"
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
          <v-toolbar-title>Contacts</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find Contact"
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
            v-tooltip="'Create local contact'"
            @click="itemCreate"
          ></v-btn>

          <!-- <contact-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-contact-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></contact-export> -->

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink :to="`/contacts/${item.id}`">{{ item.id }}</NuxtLink>
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
        <v-btn variant="text" icon="mdi-eye" :to="`/contacts/${item.id}`" />
        <v-btn variant="text" icon="mdi-pencil" @click="itemUpdate(item)" />
        <v-btn variant="text" icon="mdi-delete" @click="itemDelete(item)" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>
