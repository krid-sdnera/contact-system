<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="newRole !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ role.name }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Role Name -->
            <base-input
              :original="role.name"
              :field.sync="newRole.name"
              label="Role Name"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- External ID -->
            <base-input
              :original="role.externalId"
              :field.sync="newRole.externalId"
              label="External ID"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Class ID -->
            <base-input
              :original="role.classId"
              :field.sync="newRole.classId"
              label="Class ID"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Normalised Class ID -->
            <base-input
              :original="role.normalisedClassId"
              :field.sync="newRole.normalisedClassId"
              label="Normalised Class ID"
              field-type="text"
            ></base-input>
          </v-row>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="closeEditRoleModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditRoleModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditRoleModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { RoleData, RoleInput } from '@api/models';

import * as role from '~/store/role';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/helper-factories';
@Component
export default class DialogRoleEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly role!: RoleData;

  newRole: RoleInput | null = null;
  originalChanged: boolean = false;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewRoleData();
    }
  }

  @Watch('role', { immediate: true, deep: true })
  handleRoleDataChanged(role: RoleData) {
    if (!role) {
      // show snack error bar
      return;
    }
    if (this.newRole !== null) {
      // show warning that the underlying role data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.buildNewRoleData();
  }

  buildNewRoleData() {
    this.originalChanged = false;
    this.newRole = Object.assign({}, {
      name: this.role.name,
      externalId: this.role.externalId,
      classId: this.role.classId,
      normalisedClassId: this.role.normalisedClassId,
      sectionId: this.role.section.id,
    } as RoleInput);
  }

  closeEditRoleModal() {
    this.dialog = false;
  }

  async saveEditRoleModal() {
    try {
      await this.$store.dispatch(`${role.namespace}/updateRoleById`, {
        roleId: this.role.id,
        roleInput: this.newRole,
      });

      this.dialog = false;
      this.newRole = null;
      this.originalChanged = false;
      createAlert(this.$store, {
        message: 'Role updated.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to update Role.',
        type: 'error',
      });
    }
  }
}
</script>
