<template>
  <div v-if="member">
    <v-container>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <!-- Member Details -->
          <v-card class="mb-6">
            <v-card-title class="d-flex justify-space-between">
              {{ member.firstname }} {{ member.lastname }}
              <v-icon
                v-if="
                  member.overrides.firstname ||
                  member.overrides.nickname ||
                  member.overrides.lastname
                "
              >
                mdi-backup-restore
              </v-icon>
            </v-card-title>

            <v-card-subtitle v-if="member.membershipNumber">
              <div class="text--secondary">Rego:</div>
              <div class="text--primary">{{ member.membershipNumber }}</div>
            </v-card-subtitle>

            <v-card-text>
              <div class="text--secondary">Date of Birth:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ member.dateOfBirth | dateOfBirth }}
                <v-icon v-if="isOverridden('dateOfBirth')">
                  mdi-backup-restore
                </v-icon>
              </div>

              <div class="text--secondary">Gender:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ member.gender }}
                <v-icon v-if="isOverridden('dateOfBirth')">
                  mdi-backup-restore
                </v-icon>
              </div>
            </v-card-text>
          </v-card>

          <!-- Member Management -->
          <v-card>
            <v-card-title>Administration</v-card-title>
            <v-card-text>
              <v-chip
                :class="{ red: member.state === 'disabled' }"
                class="mb-1"
              >
                {{ member.state | capitalize }}
              </v-chip>
              <v-chip class="mb-1">
                {{ member.managementState | capitalize }}
              </v-chip>
              <v-chip v-if="member.expiry" class="mb-1">{{
                member.expiry
              }}</v-chip>
            </v-card-text>
            <v-card-text>
              <v-dialog v-model="dialogStateConfirm" persistent width="500">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" v-bind="attrs" v-on="on">
                    {{ member.state === 'enabled' ? 'Disable' : 'Enable' }}
                    member
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline" primary-title>
                    Change state to
                    {{ member.state === 'enabled' ? 'disabled' : 'enabled' }}?
                  </v-card-title>
                  <v-card-text>
                    You are about to
                    {{ member.state === 'enabled' ? 'disable' : 'enable' }}
                    {{ member.firstname }} <br />
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
                      v-if="member.state === 'enabled'"
                      color="warning"
                      text
                      :disabled="isAppUpdating || !dialogStateConfirm"
                      @click.stop="handleMemberState('disabled')"
                      >Disable member</v-btn
                    >
                    <v-btn
                      v-if="member.state === 'disabled'"
                      color="warning"
                      text
                      :disabled="isAppUpdating || !dialogStateConfirm"
                      @click.stop="handleMemberState('enabled')"
                      >Enable member</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-card-text>
            <v-card-text>
              <v-btn color="primary" @click.stop="openEditMemberModal">
                <v-icon small>mdi-pencil</v-icon> Edit
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Member Contacts -->
          <v-card>
            <v-card-title>Details</v-card-title>

            <v-card-text>
              <div class="text--secondary">Address:</div>
              <div class="text--primary d-flex justify-space-between">
                {{ member.address | address }}
                <v-icon v-if="isOverridden('address')">
                  mdi-backup-restore
                </v-icon>
              </div>
            </v-card-text>

            <v-card-text>
              <template v-if="member.email">
                <div class="text--secondary">Email:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.email }}
                  <v-icon v-if="isOverridden('email')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>
            </v-card-text>

            <v-card-text>
              <template v-if="member.phoneHome">
                <div class="text--secondary">Homephone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneHome }}
                  <v-icon v-if="isOverridden('phoneHome')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>

              <template v-if="member.phoneWork">
                <div class="text--secondary">Workphone:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneWork }}
                  <v-icon v-if="isOverridden('phoneWork')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>

              <template v-if="member.phoneMobile">
                <div class="text--secondary">Mobile:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.phoneMobile }}
                  <v-icon v-if="isOverridden('phoneMobile')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>
            </v-card-text>

            <!-- Member School Details -->
            <v-card-text v-if="member.schoolName || member.schoolYearLevel">
              <template v-if="member.schoolName">
                <div class="text--secondary">School Name:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.schoolName }}
                  <v-icon v-if="isOverridden('schoolName')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>

              <template v-if="member.schoolYearLevel">
                <div class="text--secondary">School Year Level:</div>
                <div class="text--primary d-flex justify-space-between">
                  {{ member.schoolYearLevel }}
                  <v-icon v-if="isOverridden('schoolYearLevel')">
                    mdi-backup-restore
                  </v-icon>
                </div>
              </template>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <!-- Member Role Summary -->
          <v-card class="mb-6">
            <v-card-title>Roles</v-card-title>

            <v-list>
              <template v-for="item in roles">
                <v-list-item :key="item.role.id">
                  <v-list-item-content>
                    <v-list-item-title>{{ item.role.name }}</v-list-item-title>
                    <v-list-item-subtitle>
                      {{ item.role.section.name }} -
                      {{ item.role.section.scoutGroup.name }}
                    </v-list-item-subtitle>
                  </v-list-item-content>
                  <v-list-item-icon>
                    <nuxt-link :to="`/roles/${item.role.id}`">
                      <v-icon>mdi-eye</v-icon>
                    </nuxt-link>
                  </v-list-item-icon>
                </v-list-item>
              </template>
            </v-list>
          </v-card>
          <!-- Member Contacts Summary -->
          <v-card>
            <v-card-title>Emergency Contacts</v-card-title>

            <v-list>
              <template v-for="item in contacts">
                <v-list-item :key="item.id">
                  <v-list-item-content>
                    <v-list-item-title>
                      {{ item.firstname }}
                      {{ item.lastname }}
                    </v-list-item-title>
                    <v-list-item-subtitle>{{
                      item.relationship
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                  <v-list-item-icon>
                    <nuxt-link :to="`/contacts/${item.id}`">
                      <v-icon>mdi-eye</v-icon>
                    </nuxt-link>
                  </v-list-item-icon>
                </v-list-item>
              </template>
            </v-list>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <!-- Member Contact Table -->
          <v-data-table
            :headers="headers.contacts"
            :items="contacts"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Contacts</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-btn
                  color="primary"
                  class="mb-2"
                  @click="openCreateContactModal()"
                >
                  New Local Contact
                </v-btn>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <nuxt-link :to="{ path: `/contacts/${item.id}` }">
                <v-icon small class="mr-2">mdi-eye</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/contacts/${item.id}/delete` }">
                <v-icon small>mdi-delete</v-icon>
              </nuxt-link>
            </template>
          </v-data-table>
        </v-col>
        <v-col cols="12">
          <!-- Member Role Table -->
          <v-data-table
            :headers="headers.roles"
            :items="roles"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Roles</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-btn
                  color="primary"
                  class="mb-2"
                  @click="openCreateMemberRoleModal()"
                >
                  Assign Local Role
                </v-btn>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <nuxt-link :to="{ path: `/roles/${item.role.id}` }">
                <v-icon small class="mr-2">mdi-eye</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/roles/${item.role.id}/delete` }">
                <v-icon small>mdi-delete</v-icon>
              </nuxt-link>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
    <!-- Dialogs -->
    <member-edit :member="member" :open.sync="dialogMemberEdit"></member-edit>
    <contact-create
      :member="member"
      :open.sync="dialogContactCreate"
    ></contact-create>
    <member-role-create
      :member="member"
      :open.sync="dialogMemberRoleCreate"
    ></member-role-create>
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
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </v-container>
  <div v-else-if="error">Error loading member details</div>
  <div v-else>Member not found!</div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import {
  MemberData,
  MemberDataStateEnum,
  ContactData,
  MemberRoleData,
  MemberOverrideData,
} from '@api/models';
import BaseInputComponent from '~/components/form/base-input.vue';
import MemberEditDialog from '~/components/dialogs/member-edit.vue';
import ContactCreateDialog from '~/components/dialogs/contact-create.vue';
import MemberRoleCreateDialog from '~/components/dialogs/member-role-create.vue';

import * as member from '~/store/member';
import * as contact from '~/store/contact';
import * as ui from '~/store/ui';

@Component({
  components: {
    BaseInputComponent,
    MemberEditDialog,
    ContactCreateDialog,
    MemberRoleCreateDialog,
  },
})
export default class MemberDetailPage extends Vue {
  get id(): number {
    return Number(this.$route.params.id);
  }

  get member(): MemberData | null {
    return this.$store.getters[`${member.namespace}/getMemberById`](this.id);
  }

  get contacts(): ContactData[] {
    return this.$store.getters[`${contact.namespace}/getContactsByMemberId`](
      this.id
    );
  }

  get roles(): MemberRoleData[] {
    return this.$store.getters[`${member.namespace}/getRolesByMemberId`](
      this.id
    );
  }

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  error = false;
  loading = true;

  headers = {
    contacts: [
      {
        text: 'Firstname',
        align: 'start',
        sortable: false,
        value: 'firstname',
      },
      { text: 'Lastname', value: 'lastname' },
      { text: 'Relationship', value: 'relationship' },
      { text: 'Actions', value: 'actions' },
    ],
    roles: [
      { text: 'Role', value: 'role.name' },
      { text: 'Section', value: 'role.section.name' },
      { text: 'Scout Group', value: 'role.section.scoutGroup.name' },
      { text: 'Actions', value: 'actions' },
    ],
  };

  isOverridden(fieldname: keyof MemberOverrideData): boolean {
    if (!this.member?.overrides) {
      return false;
    }
    return this.member.overrides[fieldname] || false;
  }

  async mounted() {
    try {
      const memberPromise = this.$store.dispatch(
        `${member.namespace}/fetchMemberById`,
        this.id
      );
      const contactsPromise = this.$store.dispatch(
        `${contact.namespace}/fetchContactsByMemberId`,
        this.id
      );
      const memberRolesPromise = this.$store.dispatch(
        `${member.namespace}/fetchRolesByMemberId`,
        this.id
      );
      await Promise.all([memberPromise, contactsPromise, memberRolesPromise]);
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogStateConfirm = false;

  async handleMemberState(newState: MemberDataStateEnum): Promise<void> {
    try {
      await this.$store.dispatch(`${member.namespace}/patchMemberById`, {
        memberId: this.id,
        memberInput: {
          state: newState,
        },
      });

      this.dialogStateConfirm = false;
    } catch (e) {
      console.error(e);
      alert('update failed');
    }
  }

  dialogMemberEdit: boolean = false;

  openEditMemberModal() {
    this.dialogMemberEdit = true;
  }

  closeEditMemberModal() {
    this.dialogMemberEdit = false;
  }

  dialogContactCreate: boolean = false;

  openCreateContactModal() {
    this.dialogContactCreate = true;
  }

  closeCreateContactModal() {
    this.dialogContactCreate = false;
  }

  dialogMemberRoleCreate: boolean = false;

  openCreateMemberRoleModal() {
    this.dialogMemberRoleCreate = true;
  }

  closeCreateMemberRoleModal() {
    this.dialogMemberRoleCreate = false;
  }
}
</script>
