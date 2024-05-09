<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-2">
        New Local Role
      </v-btn>
    </template>
    <v-card v-if="roleOptions !== []" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">
          Assign a new Local Role for {{ member.firstname }}
        </span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Role Selector -->
            <base-input
              :field.sync="selectedRoleId"
              label="Role"
              field-type="autocomplete"
              :select-options="roleOptions"
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
          @click="closeCreateMemberRoleModal"
        >
          Cancel
        </v-btn>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveCreateMemberRoleModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  MemberData,
  MemberRoleData,
  MemberRoleInput,
  MemberRoleInputStateEnum,
  RoleData,
} from '@api/models';

import * as member from '~/store/member';
import * as role from '~/store/role';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/helper-factories';
@Component
export default class DialogMemberRoleCreateComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly member!: MemberData;

  selectedRoleId: string | null = null;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  get roleOptions(): { label: string; value: string }[] {
    const rolesAlreadyAssigned: number[] = this.$store.getters[
      `${member.namespace}/getRolesByMemberId`
    ](this.member.id).map((role: MemberRoleData): number => role.role.id);

    return Object.values(this.$store.state.role.roles as RoleData)
      .filter(
        (role: RoleData): boolean => !rolesAlreadyAssigned.includes(role.id)
      )
      .map((role: RoleData): {
        label: string;
        value: string;
      } => ({
        label: `${role.name} - ${role.section.name}`,
        value: String(role.id),
      }));
  }

  @Watch('dialog')
  async handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, fetch list of roles

      try {
        await this.$store.dispatch(`${role.namespace}/fetchRoles`, {
          pageSize: 200,
        });
      } catch (e) {
        console.error(e);
        alert('Failed to get list of roles');
      }
    }
  }

  closeCreateMemberRoleModal() {
    this.dialog = false;
  }

  async saveCreateMemberRoleModal() {
    try {
      await this.$store.dispatch(`${member.namespace}/addMemberRole`, {
        memberId: this.member.id,
        roleId: this.selectedRoleId,
        memberRoleInput: {
          state: MemberRoleInputStateEnum.Enabled,
          expiry: undefined,
        },
      });

      this.dialog = false;
      this.selectedRoleId = null;

      createAlert(this.$store, {
        message: 'Role created.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);
      createAlert(this.$store, {
        message: 'Failed to create Role.',
        type: 'error',
      });
    }
  }
}
</script>
