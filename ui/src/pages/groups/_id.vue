<template>
  <div v-if="scoutGroup && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <!-- ScoutGroup Details -->
        <v-card class="mb-6">
          <base-heading label="Group">
            {{ scoutGroup.name }}
          </base-heading>

          <v-card-text></v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click.stop="openEditScoutGroupModal">
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
            <base-info :to="{ hash: '#sections' }">
              Sections
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
            <base-info label="Group Id">
              {{ scoutGroup.externalId }}
            </base-info>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row id="sections">
      <v-col>
        <!-- Sections Table -->
        <sections-table
          :scout-group="scoutGroup"
          allow-creation
        ></sections-table>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col>
        <!-- Email Rules Table -->
        <list-rules-table
          :preset-relation="scoutGroup"
          preset-relation-type="ScoutGroup"
          allow-creation
        ></list-rules-table>
      </v-col>
    </v-row>

    <!-- Dialogs -->
    <scout-group-edit
      :scout-group="scoutGroup"
      :open.sync="dialogScoutGroupEdit"
    ></scout-group-edit>
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
import { Component, Vue } from 'vue-property-decorator';
import { AppBreadcrumbOptions } from '~/common/breadcrumb';
import ScoutGroupEditDialog from '~/components/dialogs/scout-group-edit.vue';
import SectionTableComponent from '~/components/tables/sections-table.vue';
import * as scoutGroup from '~/store/scoutGroup';
import * as section from '~/store/section';
import BaseDisplayPage from '../base-detail-page';

@Component({
  components: {
    ScoutGroupEditDialog,
    SectionTableComponent,
  },
})
export default class ScoutGroupDetailPage extends BaseDisplayPage {
  // Getters
  get id(): number {
    return Number(this.$route.params.id);
  }

  get scoutGroup(): ScoutGroupData | null {
    return this.$store.getters[`${scoutGroup.namespace}/getScoutGroupById`](
      this.id
    );
  }

  get sections(): SectionData[] {
    return this.$store.getters[
      `${section.namespace}/getSectionsByScoutGroupId`
    ](this.id);
  }

  headers = {
    sections: [
      { text: 'Name', value: 'name' },
      { text: 'External Id', value: 'externalId' },
      { text: 'Actions', value: 'actions' },
    ],
  };

  // Configurables
  breadcrumbParents = [
    {
      to: '/groups',
      label: 'Groups',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.scoutGroup ? `${this.scoutGroup.name}` : null;
  }

  fetchApiStatusMsg = 'Fetching Group Data';
  async _fetchApiData() {
    await this.$store.dispatch(
      `${scoutGroup.namespace}/fetchScoutGroupById`,
      this.id
    );
  }
  async _fetchDataEntityNotFound() {
    this.$store.commit(`${scoutGroup.namespace}/removeScoutGroupById`, this.id);
  }

  // Additional logic
  dialogScoutGroupEdit: boolean = false;

  openEditScoutGroupModal() {
    this.dialogScoutGroupEdit = true;
  }

  closeEditScoutGroupModal() {
    this.dialogScoutGroupEdit = false;
  }
}
</script>
