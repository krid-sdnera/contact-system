<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-2">
        <v-icon>mdi-pencil</v-icon> Edit
      </v-btn>
    </template>
    <v-card v-if="newMember !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ member.firstname }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Membership Number -->
            <small>Membership Number</small>:
            {{ newMember.membershipNumber }}
          </v-row>
          <v-row>
            <!-- Firstname -->
            <base-input
              :original="member.firstname"
              :field.sync="newMember.firstname"
              :override.sync="newMember.overrides.firstname"
              label="Firstname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>
          <v-row>
            <!-- Nickname -->
            <base-input
              :original="member.nickname"
              :field.sync="newMember.nickname"
              :override.sync="newMember.overrides.nickname"
              label="Nickname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>
          <v-row>
            <!-- Lastname -->
            <base-input
              :original="member.lastname"
              :field.sync="newMember.lastname"
              :override.sync="newMember.overrides.lastname"
              label="Lastname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Date of birth -->
            <base-input
              :original="member.dateOfBirth"
              :field.sync="newMember.dateOfBirth"
              :override.sync="newMember.overrides.dateOfBirth"
              label="Date of birth"
              field-type="date"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Homephone -->
              <base-input
                :original="member.phoneHome"
                :field.sync="newMember.phoneHome"
                :override.sync="newMember.overrides.phoneHome"
                label="Homephone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Mobilephone -->
              <base-input
                :original="member.phoneMobile"
                :field.sync="newMember.phoneMobile"
                :override.sync="newMember.overrides.phoneMobile"
                label="Mobilephone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Workphone -->
              <base-input
                :original="member.phoneWork"
                :field.sync="newMember.phoneWork"
                :override.sync="newMember.overrides.phoneWork"
                label="Workphone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
          </v-row>

          <v-row>
            <!-- School Name -->
            <base-input
              :original="member.schoolName"
              :field.sync="newMember.schoolName"
              :override.sync="newMember.overrides.schoolName"
              label="School Name"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- School Year Level -->
            <base-input
              :original="member.schoolYearLevel"
              :field.sync="newMember.schoolYearLevel"
              :override.sync="newMember.overrides.schoolYearLevel"
              label="School Year Level"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Email -->
            <base-input
              :original="member.email"
              :field.sync="newMember.email"
              :override.sync="newMember.overrides.email"
              label="Email"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="6" class="pl-0 pb-0">
              <!-- Address Line 1 -->
              <base-input
                :original="member.address.street1"
                :field.sync="newMember.address.street1"
                :override.sync="newMember.overrides.address"
                label="Street Line 1"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
            <v-col cols="6" class="pr-0 pb-0">
              <!-- Address Line 2 -->
              <base-input
                :original="member.address.street2"
                :field.sync="newMember.address.street2"
                :override.sync="newMember.overrides.address"
                label="Street Line 2"
                field-type="text"
                overridable
                hide-override-checkbox
              ></base-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Address City -->
              <base-input
                :original="member.address.city"
                :field.sync="newMember.address.city"
                :override.sync="newMember.overrides.address"
                label="City"
                field-type="text"
                overridable
                hide-override-checkbox
                reserve-override-checkbox-space
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Address State -->
              <base-input
                :original="member.address.state"
                :field.sync="newMember.address.state"
                :override.sync="newMember.overrides.address"
                label="State"
                field-type="text"
                overridable
                hide-override-checkbox
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Address Postcode -->
              <base-input
                :original="member.address.postcode"
                :field.sync="newMember.address.postcode"
                :override.sync="newMember.overrides.address"
                label="Postcode"
                field-type="text"
                overridable
                hide-override-checkbox
              ></base-input>
            </v-col>
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
          @click="closeEditMemberModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditMemberModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditMemberModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { MemberData, MemberInput } from '@api/models';

import * as member from '~/store/member';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';

@Component
export default class DialogMemberEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly member!: MemberData;

  newMember: MemberInput | null = null;
  originalChanged: boolean = false;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewMemberData();
    }
  }

  @Watch('member', { immediate: true, deep: true })
  handleMemberDataChanged(member: MemberData) {
    if (!member) {
      // show snack error bar
      return;
    }
    if (this.newMember !== null) {
      // show warning that the underlying member data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.buildNewMemberData();
  }

  buildNewMemberData() {
    this.originalChanged = false;
    this.newMember = Object.assign({}, {
      state: this.member.state,
      // expiry:
      //   this.member.expiry === null
      //     ? null
      //     : this.member.expiry?.toISOString().substr(0, 10),
      firstname: this.member.firstname,
      nickname: this.member.nickname,
      lastname: this.member.lastname,
      address: {
        street1: this.member.address?.street1,
        street2: this.member.address?.street2,
        city: this.member.address?.city,
        state: this.member.address?.state,
        postcode: this.member.address?.postcode,
      },
      dateOfBirth: this.member.dateOfBirth?.toISOString().substr(0, 10),
      membershipNumber: this.member.membershipNumber,
      phoneHome: this.member.phoneHome,
      phoneMobile: this.member.phoneMobile,
      phoneWork: this.member.phoneWork,
      email: this.member.email,
      gender: this.member.gender,
      overrides: Object.assign({}, this.member.overrides || {}),
    } as MemberInput);
  }

  closeEditMemberModal() {
    this.dialog = false;
  }

  async saveEditMemberModal() {
    try {
      await this.$store.dispatch(`${member.namespace}/patchMemberById`, {
        memberId: this.member.id,
        memberInput: this.newMember,
      });

      this.dialog = false;
      this.newMember = null;
      this.originalChanged = false;

      createAlert(this.$store, {
        message: 'Member updated.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to update Member.',
        type: 'error',
      });
    }
  }
}
</script>
