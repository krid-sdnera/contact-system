<template>
  <div v-if="scoutGroup">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- ScoutGroup Details -->
          <v-card class="mb-6">
            <v-card-title>
              {{ scoutGroup.name }}
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
          <v-data-table
            :headers="headers.sections"
            :items="sections"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Sections</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <nuxt-link :to="{ path: `/sections/create/for-group/${id}/` }">
                  <v-btn color="primary" class="mb-2">New Section</v-btn>
                </nuxt-link>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <nuxt-link :to="{ path: `/sections/${item.id}` }">
                <v-icon small class="mr-2">mdi-eye</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/sections/${item.id}/edit` }">
                <v-icon small class="mr-2">mdi-pencil</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/sections/${item.id}/edit` }">
                <v-icon small>mdi-delete</v-icon>
              </nuxt-link>
            </template>
          </v-data-table>
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
import { ScoutGroupData, SectionData } from '@api/models';
import ScoutGroupEditDialog from '~/components/dialogs/scout-group-edit.vue';

import * as scoutGroup from '~/store/scoutGroup';
import * as section from '~/store/section';
import * as ui from '~/store/ui';

@Component({
  components: {
    ScoutGroupEditDialog,
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