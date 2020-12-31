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
        <member-role-create
          v-if="allowCreation"
          :member="member"
          :open.sync="dialogCreate"
        ></member-role-create>
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
      <v-btn :to="{ path: `/roles/${item.role.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Removing Role"
        :message="`Remove the role, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  MemberRoleData,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  MemberRoles,
  MemberData,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
import MemberRoleCreateDialog from '~/components/dialogs/member-role-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as member from '~/store/member';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    MemberRoleCreateDialog,
    DangerConfirmation,
  },
})
export default class MemberRoleTableComponent extends BaseTable<
  MemberRoleData
> {
  name = 'member-roles-table';
  title = 'Roles';
  @Prop(Object) readonly member!: MemberData | undefined;
  @Prop(Array) readonly memberRoles!: MemberRoleData[] | undefined;

  get items(): MemberRoleData[] {
    this.totalItems = this.memberRoles?.length || 0;

    return this.memberRoles || [];
  }

  headers = [
    { text: 'Role', value: 'role.name' },
    { text: 'Section', value: 'role.section.name' },
    { text: 'Scout Group', value: 'role.section.scoutGroup.name' },
    { text: 'State', value: 'state' },
    { text: 'MState', value: 'managementState' },
    { text: 'Actions', value: 'actions' },
  ];

  async fetchItems() {}

  async rowActionDelete(
    compositeId: number | string
  ): Promise<ModelApiResponse | void> {
    const [memberId, roleId] = String(compositeId).split('-', 2);
    return await this.$store.dispatch(`${member.namespace}/removeRoleById`, {
      memberId,
      roleId,
    });
  }
}
</script>
