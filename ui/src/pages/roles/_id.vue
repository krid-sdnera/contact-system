<template>
  <div v-if="role">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- Role Details -->
          <v-card class="mb-6">
            <v-card-title class="justify-space-between flex-nowrap">
              <div class="d-flex flex-column align-start">
                <div class="text--secondary subtitle-1">Group</div>
                <div class="text--primary">{{ scoutGroup.name }}</div>
              </div>
            </v-card-title>

            <v-card-subtitle v-if="role.externalId">
              <div class="text--secondary">Extranet Role Id:</div>
              <div class="text--primary">{{ role.externalId }}</div>
            </v-card-subtitle>

            <v-card-subtitle v-if="role.classId">
              <div class="text--secondary">Extranet Class Id:</div>
              <div class="text--primary">{{ role.classId }}</div>
            </v-card-subtitle>

            <v-card-subtitle v-if="role.normalisedClassId">
              <div class="text--secondary">Extranet Normalised Class Id:</div>
              <div class="text--primary">{{ role.normalisedClassId }}</div>
            </v-card-subtitle>

            <v-card-text>
              <v-btn color="primary" @click.stop="openEditRoleModal">
                <v-icon small>mdi-pencil</v-icon> Edit
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Section Details -->
          <v-card class="mb-6">
            <nuxt-link
              :to="`/sections/${section.id}`"
              class="text-decoration-none"
            >
              <v-card-title class="justify-space-between flex-nowrap">
                <div class="d-flex flex-column align-start">
                  <div class="text--secondary subtitle-1">Section</div>
                  <div class="text--primary">{{ section.name }}</div>
                </div>
                <v-icon>mdi-eye</v-icon>
              </v-card-title>
            </nuxt-link>

            <v-card-subtitle v-if="section.externalId">
              <div class="text--secondary">Extranet Section Id:</div>
              <div class="text--primary">{{ section.externalId }}</div>
            </v-card-subtitle>
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
    </v-container>
    <!-- Dialogs -->
    <role-edit :role="role" :open.sync="dialogRoleEdit"></role-edit>
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
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
  </v-container>
  <div v-else-if="error">Error loading role details</div>
  <div v-else>Role not found!</div>
</template>

<script lang="ts">
import { RoleData, ScoutGroupData, SectionData } from '@api/models';
import { Component, Vue, Watch } from 'vue-property-decorator';
import { AppBreadcrumbOptions, setBreadcrumbs } from '~/common/breadcrumb';
import RoleEditDialog from '~/components/dialogs/role-edit.vue';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';
import * as member from '~/store/member';
import * as role from '~/store/role';
import * as ui from '~/store/ui';

@Component({
  components: {
    RoleEditDialog,
    MemberTableComponent,
  },
})
export default class RoleDetailPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: '/roles', label: 'Roles' },
      {
        to: null,
        label: this.role ? `${this.role.name}` : 'Loading',
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

  get role(): RoleData | null {
    return this.$store.getters[`${role.namespace}/getRoleById`](this.id);
  }

  get section(): SectionData | null {
    return this.role ? this.role.section : null;
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
      await this.$store.dispatch(`${role.namespace}/fetchRoleById`, this.id);
      if (!this.role) {
        this.loading = false;
        return;
      }

      await this.$store.dispatch(`${member.namespace}/fetchMembersByRoleId`, {
        roleId: this.id,
      });
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogRoleEdit: boolean = false;

  openEditRoleModal() {
    this.dialogRoleEdit = true;
  }

  closeEditRoleModal() {
    this.dialogRoleEdit = false;
  }
}
</script>
