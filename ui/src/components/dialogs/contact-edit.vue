<template>
  <v-dialog
    v-if="newContact !== null"
    v-model="dialog"
    persistent
    scrollable
    max-width="600px"
  >
    <v-card style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ contact.firstname }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Parent Id -->
            <small>Parent ID</small>:
            {{ newContact.parentId }}
          </v-row>
          <v-row>
            <!-- Firstname -->
            <base-input
              :original="contact.firstname"
              :field.sync="newContact.firstname"
              :override.sync="newContact.overrides.firstname"
              label="Firstname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>
          <v-row>
            <!-- Nickname -->
            <base-input
              :original="contact.nickname"
              :field.sync="newContact.nickname"
              :override.sync="newContact.overrides.nickname"
              label="Nickname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>
          <v-row>
            <!-- Lastname -->
            <base-input
              :original="contact.lastname"
              :field.sync="newContact.lastname"
              :override.sync="newContact.overrides.lastname"
              label="Lastname"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Primary Contact -->
            <base-input
              :original="contact.primaryContact"
              :field.sync="newContact.primaryContact"
              :override.sync="newContact.overrides.primaryContact"
              label="Primary Contact"
              field-type="checkbox"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <v-col cols="4" class="pl-0 pb-0">
              <!-- Homephone -->
              <base-input
                :original="contact.phoneHome"
                :field.sync="newContact.phoneHome"
                :override.sync="newContact.overrides.phoneHome"
                label="Homephone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
            <v-col cols="4" class="pb-0">
              <!-- Mobilephone -->
              <base-input
                :original="contact.phoneMobile"
                :field.sync="newContact.phoneMobile"
                :override.sync="newContact.overrides.phoneMobile"
                label="Mobilephone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
            <v-col cols="4" class="pr-0 pb-0">
              <!-- Workphone -->
              <base-input
                :original="contact.phoneWork"
                :field.sync="newContact.phoneWork"
                :override.sync="newContact.overrides.phoneWork"
                label="Workphone"
                field-type="text"
                overridable
              ></base-input>
            </v-col>
          </v-row>

          <v-row>
            <!-- Occupation -->
            <base-input
              :original="contact.occupation"
              :field.sync="newContact.occupation"
              :override.sync="newContact.overrides.occupation"
              label="Occupation"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Relationship -->
            <base-input
              :original="contact.relationship"
              :field.sync="newContact.relationship"
              :override.sync="newContact.overrides.relationship"
              label="Relationship"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Email -->
            <base-input
              :original="contact.email"
              :field.sync="newContact.email"
              :override.sync="newContact.overrides.email"
              label="Email"
              field-type="text"
              overridable
            ></base-input>
          </v-row>

          <v-row>
            <!-- Address Line 1 -->
            <base-input
              :original="contact.address.street1"
              :field.sync="newContact.address.street1"
              :override.sync="newContact.overrides.address"
              label="Street Line 1"
              field-type="text"
              overridable
            >
              <v-container>
                <v-row>
                  <!-- Address Line 2 -->
                  <base-input
                    :original="contact.address.street2"
                    :field.sync="newContact.address.street2"
                    :override.sync="newContact.overrides.address"
                    label="Street Line 2"
                    field-type="text"
                  ></base-input>
                </v-row>
                <v-row>
                  <v-col cols="4" class="pl-0 pb-0">
                    <!-- Address City -->
                    <base-input
                      :original="contact.address.city"
                      :field.sync="newContact.address.city"
                      :override.sync="newContact.overrides.address"
                      label="City"
                      field-type="text"
                    ></base-input>
                  </v-col>
                  <v-col cols="4" class="pb-0">
                    <!-- Address State -->
                    <base-input
                      :original="contact.address.state"
                      :field.sync="newContact.address.state"
                      :override.sync="newContact.overrides.address"
                      label="State"
                      field-type="text"
                    ></base-input>
                  </v-col>
                  <v-col cols="4" class="pr-0 pb-0">
                    <!-- Address Postcode -->
                    <base-input
                      :original="contact.address.postcode"
                      :field.sync="newContact.address.postcode"
                      :override.sync="newContact.overrides.address"
                      label="Postcode"
                      field-type="text"
                    ></base-input>
                  </v-col>
                </v-row>
              </v-container>
            </base-input>
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
          @click="closeEditContactModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditContactModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditContactModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <span v-else>Some text</span>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { ContactData, ContactInput, ContactInputStateEnum } from '@api/models';

import * as contact from '~/store/contact';
import * as ui from '~/store/ui';

@Component
export default class DialogContactEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly contact!: ContactData;

  newContact: ContactInput | null = null;
  originalChanged: boolean = false;

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

  @Watch('contact', { immediate: true, deep: true })
  handleContactDataUpdate(contact: ContactData) {
    if (!contact) {
      // show snack error bar
      return;
    }
    if (this.newContact !== null) {
      // show warning that the underlying contact data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.buildNewContactData();
  }

  buildNewContactData() {
    this.originalChanged = false;
    this.newContact = Object.assign({}, {
      state: (this.contact.state as unknown) as ContactInputStateEnum,
      // expiry:
      //   this.contact.expiry === null
      //     ? null
      //     : this.contact.expiry?.toISOString().substr(0, 10),
      firstname: this.contact.firstname,
      nickname: this.contact.nickname,
      lastname: this.contact.lastname,
      primaryContact: this.contact.primaryContact,
      address: {
        street1: this.contact.address?.street1,
        street2: this.contact.address?.street2,
        city: this.contact.address?.city,
        state: this.contact.address?.state,
        postcode: this.contact.address?.postcode,
      },
      parentId: this.contact.parentId,
      phoneHome: this.contact.phoneHome,
      phoneMobile: this.contact.phoneMobile,
      phoneWork: this.contact.phoneWork,
      email: this.contact.email,
      occupation: this.contact.occupation,
      relationship: this.contact.relationship,
      overrides: Object.assign({}, this.contact.overrides || {}),
    } as ContactInput);
  }

  closeEditContactModal() {
    this.dialog = false;
  }

  async saveEditContactModal() {
    try {
      await this.$store.dispatch(`${contact.namespace}/patchContactById`, {
        contactId: this.contact.id,
        contactInput: this.newContact,
      });

      this.dialog = false;
      this.newContact = null;
      this.originalChanged = false;
    } catch (e) {
      console.error(e);
      alert('update failed');
    }
  }
}
</script>
