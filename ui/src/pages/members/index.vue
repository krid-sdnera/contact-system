<template>
  <v-data-table
    :headers="headers"
    :items="members"
    :options.sync="options"
    :server-items-length="totalDesserts"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
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
import { Members } from '@api/models';

@Component
export default class MembersListPage extends Vue {
  totalDesserts = 0;
  members: Members | null = null;
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
    { text: 'DOB', value: 'dateOfBirth' },
    { text: 'Actions', value: 'actions' },
  ];

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.getDataFromApi().then((data) => {
      this.members = data.items;
      this.totalDesserts = data.total;
    });
  }

  created() {
    this.getDataFromApi().then((data) => {
      this.members = data.items;
      this.totalDesserts = data.total;
    });
  }

  async getDataFromApi(): Promise<{ items: Members; total: number }> {
    this.loading = true;
    // const { /* sortBy, sortDesc, */ page, itemsPerPage } = this.options;

    const items: Members = await this.$api.members.getMembers({
      // sort?: string,
      // pageSize?: number,
      // page?: number,
    });
    // const total = items.length;
    const total = 111;

    this.loading = false;

    return {
      items,
      total,
    };
  }
}
</script>
