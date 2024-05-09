<template>
  <div v-if="section && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <!-- Section Details -->
        <v-card class="mb-6">
          <base-heading label="Section">
            {{ section.name }}
          </base-heading>

          <v-card-text>
            <base-info label="Group" :to="`/groups/${scoutGroup.id}`">
              {{ scoutGroup.name }}
            </base-info>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click.stop="openEditSectionModal">
              <v-icon small>mdi-pencil</v-icon> Edit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Jumps -->
        <v-card class="mb-6">
          <base-heading label="Jump to"></base-heading>

          <v-card-text>
            <base-info :to="{ hash: '#roles' }">
              Roles
            </base-info>
            <base-info :to="{ hash: '#members' }">
              Members
            </base-info>
            <base-info :to="{ hash: '#list-rules' }">
              List Rules
            </base-info>
          </v-card-text>
        </v-card>

        <!-- Advanced Details -->
        <v-card class="mb-6">
          <base-heading label="Extranet">Advanced</base-heading>

          <v-card-text>
            <base-info label="Section Id">
              {{ section.externalId }}
            </base-info>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row id="roles">
      <v-col>
        <!-- Roles Table -->
        <roles-table :section="section" allow-creation></roles-table>
      </v-col>
    </v-row>

    <v-row id="members">
      <v-col>
        <!-- Members Table -->
        <members-table :section="section" searchable></members-table>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col>
        <!-- Email Rules Table -->
        <list-rules-table
          :preset-relation="section"
          preset-relation-type="Section"
          allow-creation
        ></list-rules-table>
      </v-col>
    </v-row>

    <!-- Dialogs -->
    <section-edit
      :section="section"
      :open.sync="dialogSectionEdit"
    ></section-edit>
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
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <error-display v-else :error="error"></error-display>
</template>

<script lang="ts">
import { ScoutGroupData, SectionData } from '@api/models';
import { Component } from 'vue-property-decorator';
import SectionEditDialog from '~/components/dialogs/section-edit.vue';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';
import RoleTableComponent from '~/components/tables/roles-table.vue';
import * as section from '~/store/section';
import BaseDisplayPage from '../base-detail-page';

@Component({
  components: {
    SectionEditDialog,
    RoleTableComponent,
    MemberTableComponent,
  },
})
export default class SectionDetailPage extends BaseDisplayPage {
  // Getters
  get id(): number {
    return Number(this.$route.params.id);
  }

  get section(): SectionData | null {
    return this.$store.getters[`${section.namespace}/getSectionById`](this.id);
  }

  get scoutGroup(): ScoutGroupData | null {
    return this.section ? this.section.scoutGroup : null;
  }

  // Configurables
  breadcrumbParents = [
    {
      to: '/sections',
      label: 'Sections',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.section ? `${this.section.name}` : null;
  }

  fetchApiStatusMsg = 'Fetching Section Data';
  async _fetchApiData() {
    await this.$store.dispatch(
      `${section.namespace}/fetchSectionById`,
      this.id
    );
  }
  async _fetchDataEntityNotFound() {
    this.$store.commit(`${section.namespace}/removeSectionById`, this.id);
  }

  // Additional logic
  dialogSectionEdit: boolean = false;

  openEditSectionModal() {
    this.dialogSectionEdit = true;
  }

  closeEditSectionModal() {
    this.dialogSectionEdit = false;
  }
}
</script>
