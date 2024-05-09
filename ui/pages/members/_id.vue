<template>
  <div v-if="member && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Details -->
        <v-card class="mb-6">
          <base-heading
            label="Member"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ member.firstname }} {{ member.lastname }}
          </base-heading>

          <v-card-text>
            <base-info label="Rego" :overridden="isOverridden('gender')">
              {{ member.membershipNumber }}
            </base-info>

            <base-info
              label="Date of Birth"
              :overridden="isOverridden('dateOfBirth')"
            >
              {{ member.dateOfBirth | date }}
              ({{ member.dateOfBirth | duration(false) }})
            </base-info>

            <base-info label="Gender" :overridden="isOverridden('gender')">
              {{ member.gender }}
            </base-info>
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
            <v-chip v-if="member.autoUpgradeEnabled === true" class="mb-1"
              >Auto upgrade enabled</v-chip
            >
            <v-chip
              v-else
              class="mb-1 grey--text text--darken-3"
              color="warning"
            >
              Auto upgrade disabled
            </v-chip>
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
                <base-info label="Invitation process active">
                  <v-icon class="red--text">mdi-close</v-icon>
                  <span>Awaiting member completion</span>
                </base-info>

                <base-info label="This invite will expire on">
                  {{ member.metaInvite.expiryDate | date }}
                  ({{ member.metaInvite.expiryDate | duration }})
                </base-info>

                <base-info label="Status">
                  {{ member.metaInvite.status }}
                </base-info>
              </v-card-text>
            </template>
            <template
              v-if="member.metaInvite.type === 'inviteAwaitingApproval'"
            >
              <v-card-text>
                <base-info label="Invitation process active">
                  <v-icon class="green--text">mdi-check</v-icon>
                  Member has completed invite<br />
                  <v-icon class="red--text">mdi-close</v-icon>
                  Awaiting Group Leader approval
                </base-info>

                <base-info label="This invite was submitted on">
                  {{ member.metaInvite.submittedDate | date }}
                  ({{ member.metaInvite.submittedDate | duration }})
                </base-info>

                <base-info label="Level Description">
                  {{ member.metaInvite.levelDescription }}
                </base-info>
              </v-card-text>
            </template>
          </template>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Details -->
        <v-card>
          <base-heading
            :label="`${member.firstname} ${member.lastname}'${
              member.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </base-heading>

          <v-card-text>
            <base-info
              label="Address"
              :overridden="isOverridden('address')"
              :to="googleMapsLink(member.address)"
            >
              {{ member.address | address }}
            </base-info>

            <base-info label="Email" :overridden="isOverridden('email')">
              {{ member.email }}
            </base-info>

            <base-info
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ member.phoneHome | phone }}
            </base-info>
            <base-info
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ member.phoneWork | phone }}
            </base-info>
            <base-info label="Mobile" :overridden="isOverridden('phoneMobile')">
              {{ member.phoneMobile | phone }}
            </base-info>

            <!-- Member School Details -->
            <template v-if="member.schoolName || member.schoolYearLevel">
              <base-info
                label="School Name"
                :overridden="isOverridden('schoolName')"
              >
                {{ member.schoolName }}
              </base-info>

              <base-info
                label="School Year Level"
                :overridden="isOverridden('schoolYearLevel')"
              >
                {{ member.schoolYearLevel }}
              </base-info>
            </template>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Role Summary -->
        <v-card class="mb-6">
          <base-heading label="Member">
            Roles
          </base-heading>

          <v-card-text>
            <template v-for="item in roles">
              <base-info
                label=""
                :to="`/roles/${item.role.id}`"
                :key="item.role.id"
              >
                <template slot="label">
                  {{ item.role.section.scoutGroup.name }}<br />
                  <i>{{ item.role.section.name }}</i>
                </template>
                {{ item.role.name }}
              </base-info>
            </template>
          </v-card-text>
        </v-card>
        <!-- Member Contacts Summary -->
        <v-card>
          <base-heading label="Member">
            Emergency Contacts
          </base-heading>

          <v-card-text>
            <template v-for="item in contacts">
              <base-info
                :label="item.relationship"
                :to="`/contacts/${item.id}`"
                :key="item.id"
              >
                {{ item.firstname }}
                {{ item.lastname }}
              </base-info>
            </template>
          </v-card-text>
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
    </v-row>
    <v-row>
      <v-col cols="12">
        <!-- Member Role Table -->
        <member-roles-table
          :member="member"
          allow-creation
        ></member-roles-table>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <list-rules-table
          :preset-relation="member"
          preset-relation-type="Member"
          allow-creation
        ></list-rules-table>
      </v-col>
    </v-row>
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
  </div>
  <error-display v-else :error="error"></error-display>
</template>

<script lang="ts">
import {
  AddressData,
  ContactData,
  ContactDataManagementStateEnum,
  ContactDataStateEnum,
  MemberData,
  MemberOverrideData,
  MemberRoleData,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
} from '@api/models';
import { Component } from 'vue-property-decorator';
import ContactCreateDialog from '~/components/dialogs/contact-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';
import MemberEditDialog from '~/components/dialogs/member-edit.vue';
import MemberRoleCreateDialog from '~/components/dialogs/member-role-create.vue';
import BaseInputComponent from '~/components/form/base-input.vue';
import ContactTableComponent from '~/components/tables/contacts-table.vue';
import ListRulesTable from '~/components/tables/list-rules-table.vue';
import MemberRoleTableComponent from '~/components/tables/member-roles-table.vue';
import BaseDisplayPage from '~/pages/base-detail-page';
import * as contact from '~/store/contact';
import * as member from '~/store/member';
import * as ui from '~/store/ui';

@Component({
  components: {
    BaseInputComponent,
    MemberEditDialog,
    ContactCreateDialog,
    MemberRoleCreateDialog,
    DangerConfirmation,
    ContactTableComponent,
    MemberRoleTableComponent,
    ListRulesTable,
  },
})
export default class MemberDetailPage extends BaseDisplayPage {
  // Getters
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

  // Configurables
  breadcrumbParents = [
    {
      to: '/members',
      label: 'Members',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.member
      ? `${this.member.firstname} ${this.member.lastname}`
      : null;
  }

  fetchApiStatusMsg = 'Fetching Member Data';
  async _fetchApiData() {
    await this.$store.dispatch(`${member.namespace}/fetchMemberById`, this.id);
  }
  async _fetchDataEntityNotFound() {
    this.$store.commit(`${member.namespace}/removeMemberById`, this.id);
  }

  // Additional logic
  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  isOverridden(
    fieldname: keyof MemberOverrideData | (keyof MemberOverrideData)[]
  ): boolean {
    if (!this.member?.overrides) {
      return false;
    }
    if (Array.isArray(fieldname)) {
      return fieldname.some(
        (field) => this.member?.overrides?.[field] ?? false
      );
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

  dialogMemberEdit: boolean = false;

  googleMapsLink(address: AddressData) {
    const place = this.$root.$options.filters!.address(address);

    return `https://google.com.au/maps?q=${place.replaceAll(' ', '+')}`;
  }
}
</script>
