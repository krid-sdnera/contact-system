<template>
  <div v-if="scoutGroup">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- ScoutGroup Details -->
          <v-card class="mb-6">
            <v-card-title class="justify-space-between flex-nowrap">
              <div class="d-flex flex-column align-start">
                <div class="text--secondary subtitle-1">Group</div>
                <div class="text--primary">{{ scoutGroup.name }}</div>
              </div>
            </v-card-title>

            <v-card-subtitle v-if="scoutGroup.externalId">
              <div class="text--secondary">Extranet ScoutGroup Id:</div>
              <div class="text--primary">{{ scoutGroup.externalId }}</div>
            </v-card-subtitle>

            <v-card-text>
              <v-btn color="primary" @click.stop="openEditScoutGroupModal">
                <v-icon small>mdi-pencil</v-icon> Edit
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <!-- Sections Table -->

          <sections-table :sections="sections" allow-creation></sections-table>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <!-- Email Rules Table -->
          <list-rules-table
            :preset-relation="scoutGroup"
            preset-relation-type="ScoutGroup"
            allow-creation
          ></list-rules-table>
        </v-col>
      </v-row>
    </v-container>
    <!-- Dialogs -->
    <scout-group-edit
      :scout-group="scoutGroup"
      :open.sync="dialogScoutGroupEdit"
    ></scout-group-edit>
  </div>
  <v-container v-else-if="loading">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </v-container>
  <div v-else-if="error">Error loading scoutGroup details</div>
  <div v-else>ScoutGroup not found!</div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { ListRuleData, ScoutGroupData, SectionData } from '@api/models';
import ScoutGroupEditDialog from '~/components/dialogs/scout-group-edit.vue';
import SectionTableComponent from '~/components/tables/sections-table.vue';

import * as scoutGroup from '~/store/scoutGroup';
import * as section from '~/store/section';
import * as list from '~/store/emailList';
import * as ui from '~/store/ui';

@Component({
  components: {
    ScoutGroupEditDialog,
    SectionTableComponent,
  },
})
export default class ScoutGroupDetailPage extends Vue {
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

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  error = false;
  loading = true;

  headers = {
    sections: [
      { text: 'Name', value: 'name' },
      { text: 'External Id', value: 'externalId' },
      { text: 'Actions', value: 'actions' },
    ],
  };

  async mounted() {
    try {
      await this.$store.dispatch(
        `${scoutGroup.namespace}/fetchScoutGroupById`,
        this.id
      );
      await this.$store.dispatch(
        `${section.namespace}/fetchSectionsByScoutGroupId`,
        this.id
      );

      if (!this.scoutGroup) {
        this.loading = false;
        return;
      }
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogScoutGroupEdit: boolean = false;

  openEditScoutGroupModal() {
    this.dialogScoutGroupEdit = true;
  }

  closeEditScoutGroupModal() {
    this.dialogScoutGroupEdit = false;
  }
}
</script>
