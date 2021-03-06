<template>
  <div v-if="section">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- Section Details -->
          <v-card class="mb-6">
            <v-card-title class="flex-column align-start">
              <div class="text--secondary subtitle-1">Section</div>
              <div class="text--primary">{{ section.name }}</div>
            </v-card-title>

            <v-card-subtitle v-if="section.externalId">
              <div class="text--secondary">Extranet Section Id:</div>
              <div class="text--primary">{{ section.externalId }}</div>
            </v-card-subtitle>

            <v-card-text>
              <v-btn color="primary" @click.stop="openEditSectionModal">
                <v-icon small>mdi-pencil</v-icon> Edit
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Scout Group Details -->
          <v-card class="mb-6">
            <nuxt-link
              :to="`/groups/${scoutGroup.id}`"
              class="text-decoration-none"
            >
              <v-card-title class="justify-space-between flex-nowrap">
                <div class="d-flex flex-column align-start">
                  <div class="text--secondary subtitle-1">Group</div>
                  <div class="text--primary">{{ scoutGroup.name }}</div>
                </div>
                <v-icon>mdi-eye</v-icon>
              </v-card-title>
            </nuxt-link>

            <v-card-subtitle v-if="scoutGroup.externalId">
              <div class="text--secondary">Extranet Group Id:</div>
              <div class="text--primary">{{ scoutGroup.externalId }}</div>
            </v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <!-- Roles Table -->
          <roles-table :roles="roles" allow-creation></roles-table>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <members-table :section="section" searchable></members-table>
        </v-col>
      </v-row>
    </v-container>
    <!-- Dialogs -->
    <section-edit
      :section="section"
      :open.sync="dialogSectionEdit"
    ></section-edit>
  </div>
  <v-container v-else-if="loading">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
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
  </v-container>
  <div v-else-if="error">Error loading section details</div>
  <div v-else>Section not found!</div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { SectionData, ScoutGroupData, RoleData } from '@api/models';
import SectionEditDialog from '~/components/dialogs/section-edit.vue';
import RoleTableComponent from '~/components/tables/roles-table.vue';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';

import * as section from '~/store/section';
import * as role from '~/store/role';
import * as ui from '~/store/ui';

@Component({
  components: {
    SectionEditDialog,
    RoleTableComponent,
    MemberTableComponent,
  },
})
export default class SectionDetailPage extends Vue {
  get id(): number {
    return Number(this.$route.params.id);
  }

  get section(): SectionData | null {
    return this.$store.getters[`${section.namespace}/getSectionById`](this.id);
  }

  get scoutGroup(): ScoutGroupData | null {
    return this.section ? this.section.scoutGroup : null;
  }

  get roles(): RoleData[] {
    return this.$store.getters[`${role.namespace}/getRolesBySectionId`](
      this.id
    );
  }

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  error = false;
  loading = true;

  async mounted() {
    try {
      await this.$store.dispatch(
        `${section.namespace}/fetchSectionById`,
        this.id
      );
      await this.$store.dispatch(
        `${role.namespace}/fetchRolesBySectionId`,
        this.id
      );

      if (!this.section) {
        this.loading = false;
        return;
      }
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogSectionEdit: boolean = false;

  openEditSectionModal() {
    this.dialogSectionEdit = true;
  }

  closeEditSectionModal() {
    this.dialogSectionEdit = false;
  }
}
</script>
