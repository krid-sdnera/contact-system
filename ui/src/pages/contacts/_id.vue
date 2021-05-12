<template>
  <div v-if="contact">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- Contact Details -->
          <v-card class="mb-6">
            <v-card-title class="d-flex justify-space-between">
              {{ contact.firstname }} {{ contact.lastname }}
              <v-icon
                v-if="
                  isOverridden('firstname') ||
                  isOverridden('nickname') ||
                  isOverridden('lastname')
                "
              >
                mdi-backup-restore
              </v-icon>
            </v-card-title>

            <v-card-subtitle v-if="contact.parentId">
              <div class="text--secondary">Extranet Parent Id:</div>
              <div class="text--primary">{{ contact.parentId }}</div>
            </v-card-subtitle>

            <v-card-text>
              <div class="text--secondary">Primary Contact:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ contact.primaryContact ? 'Yes' : 'No' }}
                <v-icon v-if="isOverridden('primaryContact')">
                  mdi-backup-restore
                </v-icon>
              </div>
            </v-card-text>

            <v-card-text>
              <div class="text--secondary">Relationship:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ contact.relationship }}
                <v-icon v-if="isOverridden('relationship')">
                  mdi-backup-restore
                </v-icon>
              </div>

              <div class="text--secondary">Occupation:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ contact.occupation }}
                <v-icon v-if="isOverridden('occupation')">
                  mdi-backup-restore
                </v-icon>
              </div>
            </v-card-text>
          </v-card>

          <!-- Contact Management -->
          <v-card>
            <v-card-title>Administration</v-card-title>
            <v-card-text>
              <v-chip
                :class="{ red: contact.state === 'disabled' }"
                class="mb-1"
              >
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
            <v-card-text>
              <v-btn color="primary" @click.stop="dialogContactEdit = true">
                <v-icon small>mdi-pencil</v-icon> Edit
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Contact Contacts -->
          <v-card>
            <v-card-title>Details</v-card-title>

            <v-card-text>
              <div class="text--secondary">Address:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ contact.address | address }}
                <v-icon v-if="isOverridden('address')">
                  mdi-backup-restore
                </v-icon>
              </div>
            </v-card-text>

            <v-card-text>
              <template v-if="contact.email">
                <div class="text--secondary">Email:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ contact.email }}
                  <v-icon v-if="isOverridden('email')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>
            </v-card-text>

            <v-card-text>
              <template v-if="contact.phoneHome">
                <div class="text--secondary">Homephone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ contact.phoneHome | phone }}
                  <v-icon v-if="isOverridden('phoneHome')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>

              <template v-if="contact.phoneWork">
                <div class="text--secondary">Workphone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ contact.phoneWork | phone }}
                  <v-icon v-if="isOverridden('phoneWork')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>

              <template v-if="contact.phoneMobile">
                <div class="text--secondary">Mobile:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ contact.phoneMobile | phone }}
                  <v-icon v-if="isOverridden('phoneMobile')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Contact member details -->
          <v-card v-if="member">
            <v-card-title> Child / Spouse </v-card-title>

            <nuxt-link :to="`/members/${member.id}`">
              <v-card-text>
                {{ member.firstname }} {{ member.lastname }}
              </v-card-text>
            </nuxt-link>

            <v-card-text>
              <div class="text--secondary">Address:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ member.address | address }}
              </div>
            </v-card-text>

            <v-card-text>
              <template v-if="member.email">
                <div class="text--secondary">Email:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.email }}
                </div>
              </template>
            </v-card-text>

            <v-card-text>
              <template v-if="member.phoneHome">
                <div class="text--secondary">Homephone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneHome | phone }}
                </div>
              </template>

              <template v-if="member.phoneWork">
                <div class="text--secondary">Workphone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneWork | phone }}
                </div>
              </template>

              <template v-if="member.phoneMobile">
                <div class="text--secondary">Mobile:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneMobile | phone }}
                </div>
              </template>
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
    </v-container>
    <!-- Dialogs -->
    <contact-edit
      :contact="contact"
      :open.sync="dialogContactEdit"
    ></contact-edit>
  </div>
  <v-container v-else-if="loading">
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
  </v-container>
  <div v-else-if="error">Error loading contact details</div>
  <div v-else>Contact not found!</div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import {
  ContactData,
  ContactDataStateEnum,
  MemberData,
  ContactOverrideData,
} from '@api/models';
import BaseInputComponent from '~/components/form/base-input.vue';
import ContactEditDialog from '~/components/dialogs/contact-edit.vue';

import * as member from '~/store/member';
import * as contact from '~/store/contact';
import * as ui from '~/store/ui';

@Component({
  components: {
    BaseInputComponent,
    ContactEditDialog,
  },
})
export default class ContactDetailPage extends Vue {
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

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  isOverridden(fieldname: keyof ContactOverrideData): boolean {
    if (!this.contact?.overrides) {
      return false;
    }
    return this.contact.overrides[fieldname] || false;
  }

  error = false;
  loading = true;

  async mounted() {
    try {
      await this.$store.dispatch(
        `${contact.namespace}/fetchContactById`,
        this.id
      );
      if (!this.contact) {
        console.log(
          'unable to load the member data for this contact. id not avaliable'
        );
        this.loading = false;
        return;
      }
      await this.$store.dispatch(
        `${member.namespace}/fetchMemberById`,
        this.contact.memberId
      );
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
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
}
</script>
