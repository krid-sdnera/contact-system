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
                {{ member.dateOfBirth | date }}
                ({{ member.dateOfBirth | duration }})
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
              <v-chip class="mb-1">
                {{ member.managementState | capitalize }}
              </v-chip>
              <v-chip v-if="member.expiry" class="mb-1">{{
                member.expiry
              }}</v-chip>
            </v-card-text>
            <v-card-text>
              <member-edit
                :member="member"
                :open.sync="dialogMemberEdit"
              ></member-edit>
            </v-card-text>
            <template v-if="member.metaInvite">
              <template v-if="member.metaInvite.type === 'inviteActive'">
                <v-card-text>
                  <div class="text--secondary">Invitation process active:</div>
                  <div class="text--primary">
                    <v-icon class="red--text">mdi-close</v-icon>
                    <span>Awaiting member completion </span>
                  </div>
                </v-card-text>
                <v-card-text>
                  <div class="text--secondary">This invite will expire on:</div>
                  <div class="text--primary">
                    {{ member.metaInvite.expiryDate | date }}
                    ({{ member.metaInvite.expiryDate | duration }})
                  </div>
                </v-card-text>
                <v-card-text>
                  <div class="text--secondary">Status:</div>
                  <div class="text--primary">
                    {{ member.metaInvite.status }}
                  </div>
                </v-card-text>
              </template>
              <template
                v-if="member.metaInvite.type === 'inviteAwaitingApproval'"
              >
                <v-card-text>
                  <div class="text--secondary">Invitation process active:</div>
                  <div class="text--primary">
                    <v-icon class="green--text">mdi-check</v-icon>
                    Member has completed invite<br />
                    <v-icon class="red--text">mdi-close</v-icon>
                    Awaiting Group Leader approval
                  </div>
                </v-card-text>
                <v-card-text>
                  <div class="text--secondary">
                    This invite was submitted on:
                  </div>
                  <div class="text--primary">
                    {{ member.metaInvite.submittedDate | date }}
                    ({{ member.metaInvite.submittedDate | duration }})
                  </div>
                </v-card-text>
                <v-card-text>
                  <div class="text--secondary">Level Description:</div>
                  <div class="text--primary">
                    {{ member.metaInvite.levelDescription }}
                  </div>
                </v-card-text>
              </template>
            </template>
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
                    <v-list-item-subtitle>
                      {{ item.relationship }}
                    </v-list-item-subtitle>
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
          <contacts-table
            :member="member"
            :contacts="contacts"
            allow-creation
          ></contacts-table>
        </v-col>
        <v-col cols="12">
          <!-- Member Role Table -->
          <member-roles-table
            :member="member"
            :member-roles="roles"
            allow-creation
          ></member-roles-table>
        </v-col>
      </v-row>
    </v-container>
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
  ContactDataStateEnum,
  MemberRoleDataStateEnum,
  MemberRoleDataManagementStateEnum,
  ContactDataManagementStateEnum,
} from '@api/models';
import BaseInputComponent from '~/components/form/base-input.vue';
import MemberEditDialog from '~/components/dialogs/member-edit.vue';
import ContactCreateDialog from '~/components/dialogs/contact-create.vue';
import MemberRoleCreateDialog from '~/components/dialogs/member-role-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';
import ContactTableComponent from '~/components/tables/contacts-table.vue';
import MemberRoleTableComponent from '~/components/tables/member-roles-table.vue';

import * as member from '~/store/member';
import * as contact from '~/store/contact';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';

@Component({
  components: {
    BaseInputComponent,
    MemberEditDialog,
    ContactCreateDialog,
    MemberRoleCreateDialog,
    DangerConfirmation,
    ContactTableComponent,
    MemberRoleTableComponent,
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

  isOverridden(fieldname: keyof MemberOverrideData): boolean {
    if (!this.member?.overrides) {
      return false;
    }
    return this.member?.overrides[fieldname] || false;
  }

  getStateColor(state: ContactDataStateEnum | MemberRoleDataStateEnum): string {
    return state === ContactDataStateEnum.Enabled ? 'green' : 'orange';
  }
  getMStateColor(
    state: ContactDataManagementStateEnum | MemberRoleDataManagementStateEnum
  ): string {
    return state === ContactDataManagementStateEnum.Managed
      ? 'green'
      : 'orange';
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

  dialogMemberEdit: boolean = false;
}
</script>
