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
        <!-- <role-create
          v-if="allowCreation"
          :role="role"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></role-create> -->
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
      <v-btn :to="{ path: `/roles/${item.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting Role"
        :message="`delete the role, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  RoleData,
  Roles,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
// import RoleCreateDialog from '~/components/dialogs/role-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as role from '~/store/role';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    // RoleCreateDialog,
    DangerConfirmation,
  },
})
export default class RoleTableComponent extends BaseTable<RoleData> {
  name = 'roles-table';
  title = 'Roles';
  @Prop(Array) readonly roles!: RoleData[] | undefined;

  get items(): RoleData[] {
    if (this.roles) {
      this.totalItems = this.roles?.length || 0;

      // @TODO: potentially apply in browser filter if roles are supplied.
      return this.roles || [];
    }
    const itemIdsToDisplay: number[] = this.serverItemIdsToDisplay as number[];
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${role.namespace}/getRoles`]
      .filter((x: RoleData) => itemIdsToDisplay.includes(x.id))
      .sort((a: RoleData, b: RoleData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'Name', value: 'name' },
    { text: 'Section', value: 'section.name' },
    { text: 'Group', value: 'section.scoutGroup.name' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  async fetchItems() {
    if (this.roles) {
      this.totalItems = this.roles.length;
      return;
    }
    this.loading = true;

    try {
      const payload: Roles = await this.$store.dispatch(
        `${role.namespace}/fetchRoles`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.roles.map(
        (role: RoleData) => role.id
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

  handleCreateSubmit(response: RoleData) {
    if (response?.id) {
      this.$router.push(`/roles/${response.id}`);
    }
  }

  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return await this.$store.dispatch(`${role.namespace}/deleteRoleById`, {
      roleId: id,
    });
  }
}
</script>
