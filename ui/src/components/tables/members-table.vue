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
        <member-create
          v-if="allowCreation"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></member-create>
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
      <v-btn :to="{ path: `/members/${item.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting Member"
        :message="`delete the member, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  MemberData,
  MemberDataManagementStateEnum,
  MemberDataStateEnum,
  Members,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
import MemberCreateDialog from '~/components/dialogs/member-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as member from '~/store/member';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    MemberCreateDialog,
    DangerConfirmation,
  },
})
export default class MemberTableComponent extends BaseTable<MemberData> {
  name = 'members-table';
  title = 'Members';
  @Prop(Array) readonly members!: MemberData[] | undefined;

  get items(): MemberData[] {
    if (this.members) {
      this.totalItems = this.members?.length || 0;

      // @TODO: potentially apply in browser filter if members are supplied.
      return this.members || [];
    }
    const itemIdsToDisplay: number[] = this.serverItemIdsToDisplay as number[];
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${member.namespace}/getMembers`]
      .filter((x: MemberData) => itemIdsToDisplay.includes(x.id))
      .sort((a: MemberData, b: MemberData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'Firstname', value: 'firstname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  async fetchItems() {
    if (this.members) {
      this.totalItems = this.members.length;
      return;
    }
    this.loading = true;

    try {
      const payload: Members = await this.$store.dispatch(
        `${member.namespace}/fetchMembers`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.members.map(
        (member: MemberData) => member.id
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

  handleCreateSubmit(response: MemberData) {
    if (response?.id) {
      this.$router.push(`/members/${response.id}`);
    }
  }

  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return await this.$store.dispatch(`${member.namespace}/deleteMemberById`, {
      memberId: id,
    });
  }
}
</script>
