<template>
  <div v-if="role">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- Role Details -->
          <v-card class="mb-6">
            <v-card-title>
              {{ role.name }}
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
            <v-card-title
              class="d-flex flex-nowrap justify-space-between align-start"
            >
              {{ section.name }}
              <nuxt-link :to="`/sections/${section.id}`" class="ml-2">
                <v-icon>mdi-eye</v-icon>
              </nuxt-link>
            </v-card-title>

            <v-card-subtitle v-if="section.externalId">
              <div class="text--secondary">Extranet Section Id:</div>
              <div class="text--primary">{{ section.externalId }}</div>
            </v-card-subtitle>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Scout Group Details -->
          <v-card class="mb-6">
            <v-card-title>
              {{ scoutGroup.name }}
            </v-card-title>

            <v-card-subtitle v-if="scoutGroup.externalId">
              <div class="text--secondary">Extranet Group Id:</div>
              <div class="text--primary">{{ scoutGroup.externalId }}</div>
            </v-card-subtitle>
          </v-card>
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
import { Vue, Component } from 'vue-property-decorator';
import { RoleData, SectionData, ScoutGroupData } from '@api/models';
import RoleEditDialog from '~/components/dialogs/role-edit.vue';

import * as role from '~/store/role';
import * as ui from '~/store/ui';

@Component({
  components: {
    RoleEditDialog,
  },
})
export default class RoleDetailPage extends Vue {
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
