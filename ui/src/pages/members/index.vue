<template>
  <v-data-table
    :headers="headers"
    :items="members"
    :options.sync="options"
    :server-items-length="totalMembers"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Members</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <nuxt-link :to="{ path: '/members/create' }">
          <v-btn color="primary" dark class="mb-2">New Local Member</v-btn>
        </nuxt-link>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <nuxt-link :to="{ path: `/members/${item.id}` }">
        <v-icon small class="mr-2">mdi-eye</v-icon>
      </nuxt-link>
      <nuxt-link :to="{ path: `/members/${item.id}/edit` }">
        <v-icon small class="mr-2">mdi-pencil</v-icon>
      </nuxt-link>
      <nuxt-link :to="{ path: `/members/${item.id}/edit` }">
        <v-icon small>mdi-delete</v-icon>
      </nuxt-link>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import { MemberData } from '@api/models';
import * as member from '~/store/member';

@Component
export default class MembersListPage extends Vue {
  totalMembers = 5;
  error = false;
  loading = true;
  options = {
    // sortBy: null,
    // sortDesc: null,
    page: 1,
    itemsPerPage: 20,
  };

  formTitle = 'title of the form';

  headers = [
    {
      text: 'Firstname',
      align: 'start',
      sortable: false,
      value: 'firstname',
    },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Actions', value: 'actions' },
  ];

  @Watch('options', { deep: true })
  onOptionsChange() {
    // this.getDataFromApi().then((data) => {
    //   this.members = data.items;
    //   this.totalDesserts = data.total;
    // });
  }

  get members(): MemberData[] {
    return this.$store.getters[`${member.namespace}/getMembers`];
  }

  async mounted() {
    try {
      await this.$store.dispatch(`${member.namespace}/fetchMembers`, {});
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  async getDataFromApi(): Promise<void> {
    // const { /* sortBy, sortDesc, */ page, itemsPerPage } = this.options;
  }
}
</script>
