<template>
  <div v-if="role && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <!-- Role Details -->
        <v-card class="mb-6">
          <base-heading label="Role">
            {{ role.name }}
          </base-heading>

          <v-card-text>
            <base-info label="Section" :to="`/sections/${section.id}`">
              {{ section.name }}
            </base-info>
            <base-info label="Group" :to="`/groups/${scoutGroup.id}`">
              {{ scoutGroup.name }}
            </base-info>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click.stop="openEditRoleModal">
              <v-icon small>mdi-pencil</v-icon> Edit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="4">
        <!-- Scout Group Details -->
        <v-card class="mb-6">
          <base-heading label="Extranet">
            Advanced
          </base-heading>
          <v-card-text>
            <base-info label="Role Id">
              {{ role.externalId }}
            </base-info>
            <base-info label="Class Id">
              {{ role.classId }}
            </base-info>
            <base-info label="Normalised Class Id">
              {{ role.normalisedClassId }}
            </base-info>
            <base-info label="Section Id">
              {{ section.externalId }}
            </base-info>
            <base-info label="Group Id">
              {{ scoutGroup.externalId }}
            </base-info>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <members-table :role="role" searchable></members-table>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <list-rules-table
          :preset-relation="role"
          preset-relation-type="Role"
          allow-creation
        ></list-rules-table>
      </v-col>
    </v-row>

    <!-- Dialogs -->
    <role-edit :role="role" :open.sync="dialogRoleEdit"></role-edit>
  </div>
  <div v-else-if="fetchState === appFetchState.Loading">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <error-display v-else :error="error"></error-display>
</template>

<script lang="ts">
import { RoleData, ScoutGroupData, SectionData } from '@api/models';
import { Component } from 'vue-property-decorator';
import RoleEditDialog from '~/components/dialogs/role-edit.vue';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';
import * as role from '~/store/role';
import BaseDisplayPage from '../base-detail-page';

@Component({
  components: {
    RoleEditDialog,
    MemberTableComponent,
  },
})
export default class RoleDetailPage extends BaseDisplayPage {
  // Getters
  get id(): number {
    return Number(this.$route.params.id);
  }

  get role(): RoleData | null {
    return this.$store.getters[`${role.namespace}/getRoleById`](this.id);
  }

  get section(): SectionData | null {
    return this.role ? this.role.section : null;
  }

  get scoutGroup(): ScoutGroupData | null {
    return this.section ? this.section.scoutGroup : null;
  }

  // Configurables
  breadcrumbParents = [
    {
      to: '/roles',
      label: 'Roles',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.role ? `${this.role.name}` : null;
  }

  fetchApiStatusMsg = 'Fetching Role Data';
  async _fetchApiData() {
    await this.$store.dispatch(`${role.namespace}/fetchRoleById`, this.id);
  }
  async _fetchDataEntityNotFound() {
    this.$store.commit(`${role.namespace}/removeRoleById`, this.id);
  }

  // Additional logic
  dialogRoleEdit: boolean = false;

  openEditRoleModal() {
    this.dialogRoleEdit = true;
  }

  closeEditRoleModal() {
    this.dialogRoleEdit = false;
  }
}
</script>
