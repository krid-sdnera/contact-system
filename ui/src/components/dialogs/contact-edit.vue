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
import {
  ContactData,
  ContactInput,
  ContactInputStateEnum,
  MemberData,
} from '@api/models';
import { Component, Prop } from 'vue-property-decorator';
import BaseDialog, { DialogFields } from '~/components/dialogs/base-dialog';
import * as contact from '~/store/contact';

@Component
export default class DialogContactEditComponent extends BaseDialog<
  ContactData,
  ContactInput
> {
  @Prop(Object) readonly member: MemberData | undefined;

  entityName = 'Contact';
  get customMessages() {
    return {
      update: {
        title: `Update Contact: ${this.data?.firstname}`,
      },
    };
  }

  get fields() {
    const fields: DialogFields<ContactInput> = [
      {
        name: 'parentId',
        label: 'Parent ID',
        type: 'text',
        disabled: this.data?.managementState === 'managed',
      },
      { name: 'firstname', label: 'Firstname', type: 'text' },
      { name: 'nickname', label: 'Nickname', type: 'text' },
      { name: 'lastname', label: 'Lastname', type: 'text' },
      { name: 'primaryContact', label: 'Primary Contact', type: 'checkbox' },
      [
        { name: 'phoneHome', label: 'Homephone', type: 'text' },
        { name: 'phoneMobile', label: 'Mobilephone', type: 'text' },
        { name: 'phoneWork', label: 'Workphone', type: 'text' },
      ],
      { name: 'occupation', label: 'Occupation', type: 'text' },
      { name: 'relationship', label: 'Relationship', type: 'text' },
      { name: 'email', label: 'Email', type: 'text' },
      { name: 'address', label: 'Address', type: 'address' },
    ];

    return fields;
  }

  async buildInputForCreate() {
    const inputData: ContactInput = {
      state: ContactInputStateEnum.Enabled,
      memberId: this.member?.id || 0,
      parentId: undefined,
      expiry: undefined,
      firstname: '',
      nickname: '',
      lastname: '',
      primaryContact: false,
      address: {
        street1: '',
        street2: '',
        city: '',
        state: '',
        postcode: '',
      },
      phoneHome: '',
      phoneMobile: '',
      phoneWork: '',
      email: '',
      occupation: '',
      relationship: '',
      overrides: {},
    };

    return inputData;
  }

  async buildInputForUpdate(data: ContactData) {
    const inputData: ContactInput = {
      state: (data.state as unknown) as ContactInputStateEnum,
      // expiry:
      //   data.expiry === null
      //     ? null
      //     : data.expiry?.toISOString().substr(0, 10),
      firstname: data.firstname,
      nickname: data.nickname,
      lastname: data.lastname,
      primaryContact: data.primaryContact,
      address: {
        street1: data.address?.street1 ?? '',
        street2: data.address?.street2 ?? '',
        city: data.address?.city ?? '',
        state: data.address?.state ?? '',
        postcode: data.address?.postcode ?? '',
      },
      parentId: data.parentId,
      phoneHome: data.phoneHome,
      phoneMobile: data.phoneMobile,
      phoneWork: data.phoneWork,
      email: data.email,
      occupation: data.occupation,
      relationship: data.relationship,
      overrides: Object.assign({}, data.overrides || {}),
    };

    return inputData;
  }

  async persistCreate(input: ContactInput) {
    await this.$store.dispatch(`${contact.namespace}/createContact`, {
      contactInput: input,
    });
  }

  async persistUpdate(data: ContactData, input: ContactInput) {
    await this.$store.dispatch(`${contact.namespace}/patchContactById`, {
      contactId: data.id,
      contactInput: input,
    });
  }
}
</script>
