<template>
  <div v-if="contact && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact Details -->
        <v-card class="mb-6">
          <base-heading
            label="Emergency Contact"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ contact.firstname }} {{ contact.lastname }}
          </base-heading>

          <v-card-text>
            <base-info
              label="Extranet Parent Id"
              :overridden="isOverridden('parentId')"
            >
              {{ contact.parentId }}
            </base-info>
            <base-info
              label="Primary Contact"
              :overridden="isOverridden('primaryContact')"
            >
              {{ contact.primaryContact ? 'Yes' : 'No' }}
            </base-info>
            <base-info
              label="Relationship Contact"
              :overridden="isOverridden('relationship')"
            >
              {{ contact.relationship }}
            </base-info>
            <base-info
              label="Occupation"
              :overridden="isOverridden('occupation')"
            >
              {{ contact.occupation }}
            </base-info>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click.stop="dialogContactEdit">
              <v-icon small>mdi-pencil</v-icon> Edit
            </v-btn>
          </v-card-actions>
        </v-card>

        <!-- Contact Management -->
        <v-card>
          <v-card-title>Advanced</v-card-title>
          <v-card-text>
            <v-chip :class="{ red: contact.state === 'disabled' }" class="mb-1">
              {{ contact.state | capitalize }}
            </v-chip>
            <v-chip class="mb-1">{{
              contact.managementState | capitalize
            }}</v-chip>
            <v-chip v-if="contact.expiry" class="mb-1">{{
              contact.expiry
            }}</v-chip>
          </v-card-text>
          <v-card-text>
            <v-dialog v-model="dialogStateConfirm" persistent width="500">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" v-bind="attrs" v-on="on">
                  {{ contact.state === 'enabled' ? 'Disable' : 'Enable' }}
                  contact
                </v-btn>
              </template>
              <v-card>
                <v-card-title class="headline" primary-title>
                  Change state to
                  {{ contact.state === 'enabled' ? 'disabled' : 'enabled' }}?
                </v-card-title>
                <v-card-text>
                  You are about to
                  {{ contact.state === 'enabled' ? 'disable' : 'enable' }}
                  {{ contact.firstname }} <br />
                  Are you sure you wish to continue?
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
                    text
                    :disabled="isAppUpdating || !dialogStateConfirm"
                    @click="dialogStateConfirm = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    v-if="contact.state === 'enabled'"
                    color="warning"
                    text
                    :disabled="isAppUpdating || !dialogStateConfirm"
                    @click.stop="handleContactState('disabled')"
                    >Disable contact</v-btn
                  >
                  <v-btn
                    v-if="contact.state === 'disabled'"
                    color="warning"
                    text
                    :disabled="isAppUpdating || !dialogStateConfirm"
                    @click.stop="handleContactState('enabled')"
                    >Enable contact</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact Contacts -->
        <v-card>
          <base-heading
            :label="`${contact.firstname} ${contact.lastname}'${
              contact.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </base-heading>

          <v-card-text>
            <base-info
              label="Address"
              :overridden="isOverridden('address')"
              :to="googleMapsLink(contact.address)"
            >
              {{ contact.address | address }}
            </base-info>
            <base-info label="Email" :overridden="isOverridden('email')">
              {{ contact.email }}
            </base-info>
            <base-info
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ contact.phoneHome | phone }}
            </base-info>
            <base-info
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ contact.phoneWork | phone }}
            </base-info>
            <base-info label="Mobile" :overridden="isOverridden('phoneMobile')">
              {{ contact.phoneMobile | phone }}
            </base-info>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact member details -->
        <v-card v-if="member">
          <base-heading label="Child / Spouse" :to="`/members/${member.id}`">
            {{ member.firstname }} {{ member.lastname }}
          </base-heading>

          <v-card-text>
            <base-info label="Address" :to="googleMapsLink(member.address)">
              {{ member.address | address }}
            </base-info>
            <base-info label="Email">
              {{ member.email }}
            </base-info>
            <base-info label="Homephone">
              {{ member.phoneHome | phone }}
            </base-info>
            <base-info label="Workphone">
              {{ member.phoneWork | phone }}
            </base-info>
            <base-info label="Mobile">
              {{ member.phoneMobile | phone }}
            </base-info>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <list-rules-table
          :preset-relation="contact"
          preset-relation-type="Contact"
          allow-creation
        ></list-rules-table>
      </v-col>
    </v-row>

    <!-- Dialogs -->
    <contact-edit
      :contact="contact"
      :open.sync="dialogContactEdit"
    ></contact-edit>
  </div>
  <div v-else-if="fetchState === appFetchState.Loading">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <!-- <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col> -->
    </v-row>
    <!-- <v-row>
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row> -->
  </div>
  <error-display v-else :error="error"></error-display>
</template>

<script lang="ts">
import {
  AddressData,
  ContactData,
  ContactDataStateEnum,
  ContactOverrideData,
  MemberData,
} from '@api/models';
import { Component } from 'vue-property-decorator';
import { AppBreadcrumbOptions } from '~/common/breadcrumb';
import ContactEditDialog from '~/components/dialogs/contact-edit.vue';
import BaseInputComponent from '~/components/form/base-input.vue';
import BaseDisplayPage from '~/pages/base-detail-page';
import * as contact from '~/store/contact';
import * as member from '~/store/member';
import * as ui from '~/store/ui';

@Component({
  components: {
    BaseInputComponent,
    ContactEditDialog,
  },
})
export default class ContactDetailPage extends BaseDisplayPage {
  // Getters
  get id(): number {
    return Number(this.$route.params.id);
  }

  get contact(): ContactData | null {
    return this.$store.getters[`${contact.namespace}/getContactById`](this.id);
  }

  get member(): MemberData | null {
    if (!this.contact) {
      return null;
    }
    return this.$store.getters[`${member.namespace}/getMemberById`](
      this.contact.memberId
    );
  }

  // Configurables
  breadcrumbParents = [
    {
      to: '/contacts',
      label: 'Contacts',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.contact
      ? `${this.contact.firstname} ${this.contact.lastname}`
      : null;
  }

  fetchApiStatusMsg = 'Fetching Contact Data';
  async _fetchApiData() {
    await this.$store.dispatch(
      `${contact.namespace}/fetchContactById`,
      this.id
    );
    if (!this.contact?.memberId) {
      return;
    }
    await this.$store.dispatch(
      `${member.namespace}/fetchMemberById`,
      this.contact?.memberId
    );
  }
  async _fetchDataEntityNotFound() {
    this.$store.commit(`${contact.namespace}/removeContactById`, this.id);
  }

  // Additional logic
  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  isOverridden(
    fieldname: keyof ContactOverrideData | (keyof ContactOverrideData)[]
  ): boolean {
    if (!this.contact?.overrides) {
      return false;
    }
    if (Array.isArray(fieldname)) {
      return fieldname.some(
        (field) => this.contact?.overrides?.[field] ?? false
      );
    }

    return this.contact.overrides[fieldname] || false;
  }

  dialogStateConfirm = false;

  async handleContactState(newState: ContactDataStateEnum): Promise<void> {
    try {
      await this.$store.dispatch(`${contact.namespace}/patchContactById`, {
        contactId: this.id,
        contactInput: {
          state: newState,
        },
      });

      this.dialogStateConfirm = false;
    } catch (e) {
      console.error(e);
      alert('update failed');
    }
  }

  dialogContactEdit: boolean = false;

  googleMapsLink(address: AddressData) {
    const place = this.$root.$options.filters!.address(address);

    return `https://google.com.au/maps?q=${place.replaceAll(' ', '+')}`;
  }
}
</script>
