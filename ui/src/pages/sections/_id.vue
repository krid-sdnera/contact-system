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
          <roles-table :section="section" allow-creation></roles-table>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <members-table :section="section" searchable></members-table>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <!-- Email Rules Table -->
          <list-rules-table
            :preset-relation="section"
            preset-relation-type="Section"
            allow-creation
          ></list-rules-table>
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
import { ScoutGroupData, SectionData } from '@api/models';
import { Component, Vue, Watch } from 'vue-property-decorator';
import { AppBreadcrumbOptions, setBreadcrumbs } from '~/common/breadcrumb';
import SectionEditDialog from '~/components/dialogs/section-edit.vue';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';
import RoleTableComponent from '~/components/tables/roles-table.vue';
import * as role from '~/store/role';
import * as section from '~/store/section';
import * as ui from '~/store/ui';

@Component({
  components: {
    SectionEditDialog,
    RoleTableComponent,
    MemberTableComponent,
  },
})
export default class SectionDetailPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: '/sections', label: 'Sections' },
      {
        to: null,
        label: this.section ? `${this.section.name}` : 'Loading',
      },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }

  get id(): number {
    return Number(this.$route.params.id);
  }

  get section(): SectionData | null {
    return this.$store.getters[`${section.namespace}/getSectionById`](this.id);
  }

  get scoutGroup(): ScoutGroupData | null {
    return this.section ? this.section.scoutGroup : null;
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
      this.$store.dispatch(`${role.namespace}/fetchRolesBySectionId`, this.id);

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
