<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
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

@Component
export default class MembersListPage extends Vue {
  totalDesserts = 0;
  desserts = [];
  loading = true;
  options = {
    // sortBy: null,
    // sortDesc: null,
    page: 1,
    itemsPerPage: 20,
  };

  dialog = false;
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

  editedIndex = -1;
  editedItem = {
    name: '',
    calories: 0,
    fat: 0,
    carbs: 0,
    protein: 0,
  };

  defaultItem = {
    name: '',
    calories: 0,
    fat: 0,
    carbs: 0,
    protein: 0,
  };

  @Watch('dialog')
  onDialogChange(val) {
    val || this.close();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.getDataFromApi().then((data) => {
      this.desserts = data.items;
      this.totalDesserts = data.total;
    });
  }

  created() {
    this.getDataFromApi().then((data) => {
      this.desserts = data.items;
      this.totalDesserts = data.total;
    });
  }

  async getDataFromApi() {
    this.loading = true;
    const { /* sortBy, sortDesc, */ page, itemsPerPage } = this.options;

    let items = await this.getMembers();
    const total = items.length;

    // if (sortBy.length === 1 && sortDesc.length === 1) {
    //   items = items.sort((a, b) => {
    //     const sortA = a[sortBy[0]];
    //     const sortB = b[sortBy[0]];

    //     if (sortDesc[0]) {
    //       if (sortA < sortB) return 1;
    //       if (sortA > sortB) return -1;
    //       return 0;
    //     } else {
    //       if (sortA < sortB) return -1;
    //       if (sortA > sortB) return 1;
    //       return 0;
    //     }
    //   });
    // }

    if (itemsPerPage > 0) {
      items = items.slice((page - 1) * itemsPerPage, page * itemsPerPage);
    }

    this.loading = false;

    return {
      items,
      total,
    };
  }

  async getMembers() {
    return await this.$api.$get('/members');
  }
}
</script>
