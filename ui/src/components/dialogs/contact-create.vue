<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-2">
        New Local Contact
      </v-btn>
    </template>
    <v-card v-if="newContact !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">
          Create new Contact for {{ member.firstname }}
        </span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Parent Id -->
            <base-input
              :field.sync="newContact.parentId"
              label="Parent ID"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Firstname -->
            <base-input
              :field.sync="newContact.firstname"
              label="Firstname"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Nickname -->
            <base-input
              :field.sync="newContact.nickname"
              label="Nickname"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Lastname -->
            <base-input
              :field.sync="newContact.lastname"
              label="Lastname"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- Primary Contact -->
            <base-input
              :field.sync="newContact.primaryContact"
              label="Primary Contact"
              field-type="checkbox"
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Homephone -->
              <base-input
                :field.sync="newContact.phoneHome"
                label="Homephone"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Mobilephone -->
              <base-input
                :field.sync="newContact.phoneMobile"
                label="Mobilephone"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Workphone -->
              <base-input
                :field.sync="newContact.phoneWork"
                label="Workphone"
                field-type="text"
              ></base-input>
            </v-col>
          </v-row>

          <v-row>
            <!-- Occupation -->
            <base-input
              :field.sync="newContact.occupation"
              label="Occupation"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- Relationship -->
            <base-input
              :field.sync="newContact.relationship"
              label="Relationship"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <!-- Email -->
            <base-input
              :field.sync="newContact.email"
              label="Email"
              field-type="text"
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="6" class="pl-0 pb-0">
              <!-- Address Line 1 -->
              <base-input
                :field.sync="newContact.address.street1"
                label="Street Line 1"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="6" class="pr-0 pb-0">
              <!-- Address Line 2 -->
              <base-input
                :field.sync="newContact.address.street2"
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
                :field.sync="newContact.address.city"
                label="City"
                field-type="text"
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Address State -->
              <base-input
                :field.sync="newContact.address.state"
                label="State"
                field-type="text"
                hide-override-checkbox
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Address Postcode -->
              <base-input
                :field.sync="newContact.address.postcode"
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
          @click="closeCreateContactModal"
        >
          Cancel
        </v-btn>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveCreateContactModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { ContactInput, ContactInputStateEnum, MemberData } from '@api/models';
import { Component, Prop, PropSync, Vue, Watch } from 'vue-property-decorator';
import { createAlert } from '~/common/helper-factories';
import * as contact from '~/store/contact';
import * as ui from '~/store/ui';

@Component
export default class DialogContactCreateComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly member!: MemberData;

  newContact: ContactInput | null = null;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewContactData();
    }
  }

  buildNewContactData() {
    this.newContact = Object.assign({}, {
      state: ContactInputStateEnum.Enabled,
      memberId: this.member.id,
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
    } as ContactInput);
  }

  closeCreateContactModal() {
    this.dialog = false;
  }

  async saveCreateContactModal() {
    try {
      await this.$store.dispatch(`${contact.namespace}/createContact`, {
        contactInput: this.newContact,
      });

      this.dialog = false;
      this.newContact = null;
      createAlert(this.$store, {
        message: 'Contact created.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to create Contact.',
        type: 'error',
      });
    }
  }
}
</script>
