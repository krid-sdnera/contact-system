<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" small>
        New Local Member
      </v-btn>
    </template>
    <v-card v-if="newMember !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Creating a new member</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Membership Number -->
            <base-input
              :field.sync="newMember.membershipNumber"
              label="Membership Number"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Firstname -->
            <base-input
              :field.sync="newMember.firstname"
              label="Firstname"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Nickname -->
            <base-input
              :field.sync="newMember.nickname"
              label="Nickname"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Lastname -->
            <base-input
              :field.sync="newMember.lastname"
              label="Lastname"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- Date of birth -->
            <base-input
              :field.sync="newMember.dateOfBirth"
              label="Date of birth"
              field-type="date"
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Homephone -->
              <base-input
                :field.sync="newMember.phoneHome"
                label="Homephone"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Mobilephone -->
              <base-input
                :field.sync="newMember.phoneMobile"
                label="Mobilephone"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Workphone -->
              <base-input
                :field.sync="newMember.phoneWork"
                label="Workphone"
                field-type="text"
              ></base-input>
            </v-col>
          </v-row>

          <v-row>
            <!-- School Name -->
            <base-input
              :field.sync="newMember.schoolName"
              label="School Name"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- School Year Level -->
            <base-input
              :field.sync="newMember.schoolYearLevel"
              label="School Year Level"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- Email -->
            <base-input
              :field.sync="newMember.email"
              label="Email"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="6" class="pl-0 pb-0">
              <!-- Address Line 1 -->
              <base-input
                :field.sync="newMember.address.street1"
                label="Street Line 1"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="6" class="pr-0 pb-0">
              <!-- Address Line 2 -->
              <base-input
                :field.sync="newMember.address.street2"
                label="Street Line 2"
                field-type="text"
                hide-override-checkbox
              ></base-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Address City -->
              <base-input
                :field.sync="newMember.address.city"
                label="City"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Address State -->
              <base-input
                :field.sync="newMember.address.state"
                label="State"
                field-type="text"
                hide-override-checkbox
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Address Postcode -->
              <base-input
                :field.sync="newMember.address.postcode"
                label="Postcode"
                field-type="text"
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
          @click="closeCreateMemberModal"
        >
          Cancel
        </v-btn>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveCreateMemberModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Emit, PropSync } from 'vue-property-decorator';
import { MemberInput, MemberInputStateEnum, MemberData } from '@api/models';

import * as member from '~/store/member';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';

@Component
export default class DialogMemberCreateComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  newMember: MemberInput | null = null;

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

  buildNewMemberData() {
    this.newMember = Object.assign({}, {
      state: MemberInputStateEnum.Enabled,
      expiry: undefined,
      firstname: '',
      nickname: '',
      lastname: '',
      address: {
        street1: '',
        street2: '',
        city: '',
        state: '',
        postcode: '',
      },
      dateOfBirth: '',
      membershipNumber: '',
      phoneHome: '',
      phoneMobile: '',
      phoneWork: '',
      email: '',
      gender: '',
      overrides: {},
    } as MemberInput);
  }

  closeCreateMemberModal() {
    this.dialog = false;
  }

  @Emit('submit')
  async saveCreateMemberModal() {
    try {
      const memberResponse = await this.$store.dispatch(
        `${member.namespace}/createMember`,
        {
          memberInput: this.newMember,
        }
      );

      this.dialog = false;
      this.newMember = null;

      createAlert(this.$store, {
        message: 'Member created.',
        type: 'success',
      });

      return memberResponse;
    } catch (e) {
      console.error(e);
      createAlert(this.$store, {
        message: 'Failed to create Member.',
        type: 'error',
      });
    }
  }
}
</script>
