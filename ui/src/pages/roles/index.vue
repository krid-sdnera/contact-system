<template>
  <v-data-table
    :headers="headers"
    :items="roles"
    :options.sync="options"
    :server-items-length="totalRoles"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Roles</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-btn color="primary" class="mb-2" @click="openCreateRoleModal">
          New Local Role
        </v-btn>
        <!-- <role-create
          :open.sync="dialogRoleCreate"
          @submit="handleRoleCreateSubmit"
        ></role-create> -->
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn icon nuxt :to="{ path: `/roles/${item.id}` }">
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
import { RoleData, Roles } from '@api/models';
import * as role from '~/store/role';

@Component
export default class RolesListPage extends Vue {
  totalRoles = 5;
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
  roleIdsToDisplay: number[] = [];
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
    this.fetchRolesWithNewOptions();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.fetchRolesWithNewOptions();
  }

  get roles(): RoleData[] {
    return this.$store.getters[`${role.namespace}/getRoles`]
      .filter((role: RoleData) => this.roleIdsToDisplay.includes(role.id))
      .sort((a: RoleData, b: RoleData) => {
        return (
          this.roleIdsToDisplay.indexOf(a.id) -
          this.roleIdsToDisplay.indexOf(b.id)
        );
      });
  }

  async mounted() {}

  async fetchRolesWithNewOptions(): Promise<void> {
    this.loading = true;
    try {
      const payload: Roles = await this.$store.dispatch(
        `${role.namespace}/fetchRoles`,
        this.apiOptions
      );

      this.roleIdsToDisplay = payload.roles.map((role: RoleData) => role.id);

      this.totalRoles = payload.totalItems;
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

  dialogRoleCreate: boolean = false;

  openCreateRoleModal() {
    this.dialogRoleCreate = true;
  }

  closeCreateRoleModal() {
    this.dialogRoleCreate = false;
  }

  handleRoleCreateSubmit(response: RoleData) {
    if (response?.id) {
      this.$router.push(`/roles/${response.id}`);
    }
  }
}
</script>
