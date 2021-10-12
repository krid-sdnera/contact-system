<template>
  <v-data-table
    :headers="showHeaders"
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
          label="Filter"
          single-line
          hide-details
        ></v-text-field>
        <template v-slot:extension>
          <!-- Member create modal -->
          <member-create
            v-if="allowCreation"
            :open.sync="dialogCreate"
            @submit="handleCreateSubmit"
          ></member-create>
          <v-spacer></v-spacer>
          <!-- Export modal -->
          <member-export
            :open.sync="dialogExport"
            :api-options="apiOptions"
            :preset-member-fields="selectedHeaders"
            :preset-contact-fields="[]"
            :preset-role="role"
            :preset-section="section"
          ></member-export>
          <!-- Options modal -->
          <table-options
            :open.sync="dialogFields"
            :selected-fields.sync="selectedHeaders"
            :available-fields="headers"
          ></table-options>
        </template>
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
    <template v-slot:[`item.id`]="{ item }">
      <nuxt-link :to="`/members/${item.id}`">{{ item.id }}</nuxt-link>
    </template>
    <template v-slot:[`item.address`]="{ item }">
      {{ item.address | address }}
    </template>
    <template v-slot:[`item.dateOfBirth`]="{ item }">
      {{ item.dateOfBirth | date }}
    </template>
    <template v-slot:[`item.age`]="{ item }">
      {{ item.dateOfBirth | duration(false) }}
    </template>
    <template v-slot:[`item.autoUpgradeEnabled`]="{ item }">
      {{ item.autoUpgradeEnabled ? 'Yes' : 'No' }}
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn :to="`/members/${item.id}`" color="primary" icon nuxt>
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
import {
  MemberData,
  Members,
  ModelApiResponse,
  RoleData,
  SectionData,
} from '@api/models';
import { Component, Prop } from 'vue-property-decorator';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';
import MemberCreateDialog from '~/components/dialogs/member-create.vue';
import MemberExportDialog from '~/components/export/member-export.vue';
import TableOptionsComponent from '~/components/tables/table-options.vue';
import BaseTable from '~/components/tables/base-table';
import * as member from '~/store/member';

@Component({
  components: {
    MemberCreateDialog,
    MemberExportDialog,
    DangerConfirmation,
    TableOptionsComponent,
  },
})
export default class MemberTableComponent extends BaseTable<
  MemberData,
  number
> {
  @Prop(Object) readonly role: RoleData | undefined;
  @Prop(Object) readonly section: SectionData | undefined;

  name = 'members-table';
  title = 'Members';

  get items(): MemberData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    return this.$store.getters[`${member.namespace}/getMembers`]
      .filter((x: MemberData) => itemIdsToDisplay.includes(x.id))
      .sort((a: MemberData, b: MemberData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'ID', value: 'id', disabled: true },
    { text: 'Firstname', value: 'firstname' },
    { text: 'Nickname', value: 'nickname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Address', value: 'address' },
    { text: 'Date of Birth', value: 'dateOfBirth' },
    { text: 'Age', value: 'age' },
    { text: 'Email', value: 'email' },
    { text: 'Home Phone', value: 'phoneHome' },
    { text: 'Mobile Phone', value: 'phoneMobile' },
    { text: 'Work Phone', value: 'phoneWork' },
    { text: 'Gender', value: 'gender' },
    { text: 'School Name', value: 'schoolName' },
    { text: 'School Year Level', value: 'schoolYearLevel' },
    { text: 'Auto Upgrade Enabled', value: 'autoUpgradeEnabled' },
    { text: 'Actions', value: 'actions', sortable: false, disabled: true },
  ];
  initialHeaders = [
    'id',
    'firstname',
    'lastname',
    'email',
    'gender',
    'membershipNumber',
    'actions',
  ];

  async fetchItems() {
    this.loading = true;

    try {
      let payload: Members | null = null;

      if (this.role) {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchMembersByRoleId`,
          { roleId: this.role.id, ...this.apiOptions }
        );
      } else if (this.section) {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchMembersBySectionId`,
          { sectionId: this.section.id, ...this.apiOptions }
        );
      } else {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchMembers`,
          this.apiOptions
        );
      }

      if (payload === null) {
        this.serverItemIdsToDisplay = [];
        this.totalItems = 0;
        return;
      }
      this.serverItemIdsToDisplay = Array.from(payload.members).map(
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

  dialogExport: boolean = false;
}
</script>
