<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="builtDataInput !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">{{ messages.title }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row v-for="(fields, index) in parsedFormFields" :key="index">
            <v-col
              v-for="(field, jndex) in fields"
              :key="field.name"
              :cols="12 / fields.length"
              :class="{
                'pl-0': jndex === 0,
                'pr-0': jndex === fields.length - 1,
                'pb-0': true,
              }"
            >
              <span v-if="field.disabled">
                <small>{{ field.label }}:</small>
                {{ data[field.name] }}
              </span>
              <base-input
                v-else
                :original="data[field.name]"
                :field.sync="builtDataInput[field.name]"
                :override.sync="builtDataInput.overrides[field.name]"
                :label="field.label"
                :field-type="field.type"
                :overridable="
                  checkMode('update') && data.managementState === 'managed'
                "
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
          @click="closeDialog"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="submitDialog"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="submitDialog"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { MemberData, MemberInput, MemberInputStateEnum } from '@api/models';
import BaseDialog, { DialogFields } from '~/components/dialogs/base-dialog';
import * as member from '~/store/member';

@Component
export default class DialogMemberEditComponent extends BaseDialog<
  MemberData,
  MemberInput
> {
  entityName = 'Member';
  get customMessages() {
    return {
      update: {
        title: `Update Member: ${this.data?.firstname}`,
      },
    };
  }

  get fields() {
    const fields: DialogFields<MemberInput> = [
      {
        name: 'membershipNumber',
        label: 'Membership Number',
        type: 'text',
        disabled: this.data?.managementState === 'managed',
      },
      { name: 'firstname', label: 'Firstname', type: 'text' },
      { name: 'nickname', label: 'Nickname', type: 'text' },
      { name: 'lastname', label: 'Lastname', type: 'text' },
      { name: 'dateOfBirth', label: 'Date of birth', type: 'date' },
      [
        { name: 'phoneHome', label: 'Homephone', type: 'text' },
        { name: 'phoneMobile', label: 'Mobilephone', type: 'text' },
        { name: 'phoneWork', label: 'Workphone', type: 'text' },
      ],
      { name: 'schoolName', label: 'School Name', type: 'text' },
      { name: 'schoolYearLevel', label: 'School Year Level', type: 'text' },
      { name: 'email', label: 'Email', type: 'text' },
      { name: 'address', label: 'Address', type: 'address' },
    ];

    return fields;
  }

  async buildInputForCreate() {
    const inputData: MemberInput = {
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
    };

    return inputData;
  }

  async buildInputForUpdate(data: MemberData) {
    const inputData: MemberInput = {
      state: (data.state as unknown) as MemberInputStateEnum,
      // expiry:
      //   data.expiry === null
      //     ? null
      //     : data.expiry?.toISOString().substr(0, 10),
      firstname: data.firstname,
      nickname: data.nickname,
      lastname: data.lastname,
      address: {
        street1: data.address?.street1 ?? '',
        street2: data.address?.street2 ?? '',
        city: data.address?.city ?? '',
        state: data.address?.state ?? '',
        postcode: data.address?.postcode ?? '',
      },
      dateOfBirth: data.dateOfBirth?.toISOString().substr(0, 10),
      membershipNumber: data.membershipNumber,
      phoneHome: data.phoneHome,
      phoneMobile: data.phoneMobile,
      phoneWork: data.phoneWork,
      email: data.email,
      gender: data.gender,
      overrides: Object.assign({}, data.overrides || {}),
    };

    return inputData;
  }

  async persistCreate(input: MemberInput) {
    await this.$store.dispatch(`${member.namespace}/createMember`, {
      memberInput: input,
    });
  }

  async persistUpdate(data: MemberData, input: MemberInput) {
    await this.$store.dispatch(`${member.namespace}/patchMemberById`, {
      memberId: data.id,
      memberInput: input,
    });
  }
}
</script>
