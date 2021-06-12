<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :options.sync="options"
    :server-items-length="totalItems"
    :loading="loading"
    class="elevation-1"
    :footer-props="{
      showFirstLastPage: true,
      'items-per-page-options': [10, 15, 25],
    }"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-if="searchable"
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <contact-create
          v-if="allowCreation"
          :member="member"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></contact-create>
      </v-toolbar>
    </template>
    <template v-slot:[`item.state`]="{ item }">
      <v-chip :color="getStateColor(item.state)">
        {{ item.state }}
      </v-chip>
    </template>
    <template v-slot:[`item.managementState`]="{ item }">
      <v-chip :color="getMStateColor(item.managementState)">
        {{ item.managementState }}
      </v-chip>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn :to="{ path: `/contacts/${item.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting Contact"
        :message="`delete the contact, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  ContactData,
  ContactDataManagementStateEnum,
  ContactDataStateEnum,
  Contacts,
  MemberData,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
import ContactCreateDialog from '~/components/dialogs/contact-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as member from '~/store/member';
import * as contact from '~/store/contact';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    ContactCreateDialog,
    DangerConfirmation,
  },
})
export default class ContactTableComponent extends BaseTable<
  ContactData,
  number
> {
  name = 'contacts-table';
  title = 'Contacts';
  @Prop(Object) readonly member: MemberData | undefined;

  get items(): ContactData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    return this.$store.getters[`${contact.namespace}/getContacts`]
      .filter((x: ContactData) => itemIdsToDisplay.includes(x.id))
      .sort((a: ContactData, b: ContactData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    {
      text: 'Firstname',
      align: 'start',
      sortable: false,
      value: 'firstname',
    },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Relationship', value: 'relationship' },
    { text: 'State', value: 'state' },
    { text: 'MState', value: 'managementState' },
    { text: 'Actions', value: 'actions' },
  ];

  async fetchItems() {
    this.loading = true;

    try {
      let payload: Contacts;
      if (this.member) {
        payload = await this.$store.dispatch(
          `${contact.namespace}/fetchContactsByMemberId`,
          { ...this.apiOptions, memberId: this.member.id }
        );
      } else {
        payload = await this.$store.dispatch(
          `${contact.namespace}/fetchContacts`,
          this.apiOptions
        );
      }

      this.serverItemIdsToDisplay = payload.contacts.map(
        (contact: ContactData) => contact.id
      );
      this.totalItems = payload.totalItems;
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

  handleCreateSubmit(response: ContactData) {
    if (response?.id) {
      this.$router.push(`/contats/${response.id}`);
    }
  }

  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return await this.$store.dispatch(
      `${contact.namespace}/deleteContactById`,
      {
        contactId: id,
      }
    );
  }
}
</script>
