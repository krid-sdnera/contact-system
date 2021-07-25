<template>
  <v-data-table
    :headers="showHeaders"
    :items="items"
    :options.sync="options"
    :loading="loading"
    class="elevation-1"
    :footer-props="{
      'items-per-page-options': [],
    }"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
    <template v-slot:[`item.id`]="{ item }">
      <template v-if="String(item.id).startsWith('1')">
        <nuxt-link
          :to="`/members/${item.id - 10000}`"
          @click.native="clearSearchQuery"
        >
          Member
        </nuxt-link>
      </template>
      <template v-if="String(item.id).startsWith('2')">
        <nuxt-link
          :to="`/contacts/${item.id - 20000}`"
          @click.native="clearSearchQuery"
        >
          Contact
        </nuxt-link>
      </template>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { ContactData, Contacts, MemberData, Members } from '@api/models';
import { Component, Emit, Prop, Watch } from 'vue-property-decorator';
import BaseTable from '~/components/tables/base-table';
import * as member from '~/store/member';
import * as contact from '~/store/contact';

type CommonData = MemberData | ContactData;

@Component
export default class SearchTableComponent extends BaseTable<
  CommonData,
  string
> {
  @Prop(String) readonly searchQuery!: string;

  @Watch('searchQuery')
  onSearchQueryChange(searchQuery: string) {
    this.search = searchQuery;
  }

  @Emit('clear-search-query')
  clearSearchQuery() {
    console.log('hi');
    return true;
  }

  name = 'search-table';
  title = 'Search';

  get items(): CommonData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    const memberItemIdsToDisplay = itemIdsToDisplay
      .filter((x) => x.startsWith('member:'))
      .map((x) => Number(x.replace('member:', '')));
    const contactItemIdsToDisplay = itemIdsToDisplay
      .filter((x) => x.startsWith('contact:'))
      .map((x) => Number(x.replace('contact:', '')));

    const members = this.$store.getters[`${member.namespace}/getMembers`]
      .filter((x: MemberData) => memberItemIdsToDisplay.includes(x.id))
      .sort((a: MemberData, b: MemberData) => {
        return (
          memberItemIdsToDisplay.indexOf(a.id) -
          memberItemIdsToDisplay.indexOf(b.id)
        );
      })
      .map((x: MemberData) => ({ ...x, id: x.id + 10000 }));
    const contacts = this.$store.getters[`${contact.namespace}/getContacts`]
      .filter((x: ContactData) => contactItemIdsToDisplay.includes(x.id))
      .sort((a: ContactData, b: ContactData) => {
        return (
          contactItemIdsToDisplay.indexOf(a.id) -
          contactItemIdsToDisplay.indexOf(b.id)
        );
      })
      .map((x: ContactData) => ({ ...x, id: x.id + 20000 }));

    return members.concat(contacts);
  }

  headers = [
    { text: 'ID', value: 'id', disabled: true },
    { text: 'Firstname', value: 'firstname' },
    { text: 'Nickname', value: 'nickname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Address', value: 'address' },
    { text: 'Email', value: 'email' },
    { text: 'Home Phone', value: 'phoneHome' },
    { text: 'Mobile Phone', value: 'phoneMobile' },
    { text: 'Work Phone', value: 'phoneWork' },
  ];
  initialHeaders = [
    'id',
    'firstname',
    'lastname',
    'email',
    'gender',
    'membershipNumber',
  ];

  async fetchItems() {
    if (!this.apiOptions.query || this.apiOptions.query === null) {
      this.serverItemIdsToDisplay = [];
      this.totalItems = 0;
      return;
    }

    this.loading = true;

    try {
      const promiseMember: Promise<Members> = this.$store.dispatch(
        `${member.namespace}/fetchMembers`,
        this.apiOptions
      );
      const promiseContact: Promise<Contacts> = this.$store.dispatch(
        `${contact.namespace}/fetchContacts`,
        this.apiOptions
      );

      const [members, contacts] = await Promise.all([
        promiseMember,
        promiseContact,
      ]);

      const memberIds =
        members?.members?.map((member: MemberData) => `member:${member.id}`) ??
        [];
      const contactIds =
        contacts?.contacts?.map(
          (contact: ContactData) => `contact:${contact.id}`
        ) ?? [];

      this.serverItemIdsToDisplay = memberIds.concat(contactIds);

      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }
}
</script>
