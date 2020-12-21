<template>
  <v-data-table
    :headers="headers"
    :items="groups"
    :options.sync="options"
    :server-items-length="totalGroups"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Groups</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-btn color="primary" class="mb-2" @click="openCreateGroupModal">
          New Local Group
        </v-btn>
        <!-- <group-create
          :open.sync="dialogGroupCreate"
          @submit="handleGroupCreateSubmit"
        ></group-create> -->
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn icon nuxt :to="{ path: `/groups/${item.id}` }">
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
import { ScoutGroupData, ScoutGroups } from '@api/models';
import * as group from '~/store/scoutGroup';

@Component
export default class GroupsListPage extends Vue {
  totalGroups = 5;
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
  groupIdsToDisplay: number[] = [];
  search: string = '';

  headers = [
    { text: 'Name', value: 'name' },
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
    this.fetchGroupsWithNewOptions();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.fetchGroupsWithNewOptions();
  }

  get groups(): ScoutGroupData[] {
    return this.$store.getters[`${group.namespace}/getScoutGroups`]
      .filter((group: ScoutGroupData) =>
        this.groupIdsToDisplay.includes(group.id)
      )
      .sort((a: ScoutGroupData, b: ScoutGroupData) => {
        return (
          this.groupIdsToDisplay.indexOf(a.id) -
          this.groupIdsToDisplay.indexOf(b.id)
        );
      });
  }

  async mounted() {}

  async fetchGroupsWithNewOptions(): Promise<void> {
    this.loading = true;
    try {
      const payload: ScoutGroups = await this.$store.dispatch(
        `${group.namespace}/fetchScoutGroups`,
        this.apiOptions
      );
      console.log(payload);
      this.groupIdsToDisplay = payload.scoutGroups.map(
        (group: ScoutGroupData) => group.id
      );

      this.totalGroups = payload.totalItems;
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

  dialogGroupCreate: boolean = false;

  openCreateGroupModal() {
    this.dialogGroupCreate = true;
  }

  closeCreateGroupModal() {
    this.dialogGroupCreate = false;
  }

  handleGroupCreateSubmit(response: ScoutGroupData) {
    if (response?.id) {
      this.$router.push(`/groups/${response.id}`);
    }
  }
}
</script>
