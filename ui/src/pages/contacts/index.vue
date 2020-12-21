<template>
  <v-data-table
    :headers="headers"
    :items="contacts"
    :options.sync="options"
    :server-items-length="totalContacts"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Contacts</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-btn color="primary" class="mb-2" @click="openCreateContactModal">
          New Local Contact
        </v-btn>
        <contact-create
          :open.sync="dialogContactCreate"
          @submit="handleContactCreateSubmit"
        ></contact-create>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn icon nuxt :to="{ path: `/contacts/${item.id}` }">
        <v-icon small>mdi-eye</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon small color="red">mdi-delete</v-icon>
      </v-btn>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import { ContactData, Contacts } from '@api/models';
import * as contact from '~/store/contact';

@Component
export default class ContactsListPage extends Vue {
  totalContacts = 5;
  error = false;
  loading = true;
  options: {
    sortBy: string[];
    sortDesc: string[];
    page: number;
    itemsPerPage: number;
  } = {
    sortBy: [],
    sortDesc: [],
    page: 1,
    itemsPerPage: 10,
  };
  contactIdsToDisplay: number[] = [];
  search: string = '';

  headers = [
    { text: 'Firstname', value: 'firstname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  get apiOptions() {
    let sort = '';
    if (this.options.sortBy.length && this.options.sortDesc.length) {
      const sortDir = this.options.sortDesc[0] ? 'DESC' : 'ASC';
      sort = this.options.sortBy[0] + ':' + sortDir;
    }
    return {
      query: this.search,
      sort: sort,
      page: this.options.page || 1,
      pageSize: this.options.itemsPerPage || 25,
    };
  }

  @Watch('search')
  onSearchChange() {
    this.options.page = 1;
    this.fetchContactsWithNewOptions();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.fetchContactsWithNewOptions();
  }

  get contacts(): ContactData[] {
    return this.$store.getters[`${contact.namespace}/getContacts`]
      .filter((contact: ContactData) =>
        this.contactIdsToDisplay.includes(contact.id)
      )
      .sort((a: ContactData, b: ContactData) => {
        return (
          this.contactIdsToDisplay.indexOf(a.id) -
          this.contactIdsToDisplay.indexOf(b.id)
        );
      });
  }

  async mounted() {}

  async fetchContactsWithNewOptions(): Promise<void> {
    this.loading = true;
    try {
      const payload: Contacts = await this.$store.dispatch(
        `${contact.namespace}/fetchContacts`,
        this.apiOptions
      );

      this.contactIdsToDisplay = payload.contacts.map(
        (contact: ContactData) => contact.id
      );

      this.totalContacts = payload.totalItems;
      if (this.apiOptions.page > payload.totalPages) {
        this.options.page = payload.totalPages;
      }
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogContactCreate: boolean = false;

  openCreateContactModal() {
    this.dialogContactCreate = true;
  }

  closeCreateContactModal() {
    this.dialogContactCreate = false;
  }

  handleContactCreateSubmit(response: ContactData) {
    if (response?.id) {
      this.$router.push(`/contacts/${response.id}`);
    }
  }
}
</script>
