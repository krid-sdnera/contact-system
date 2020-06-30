<template>
  <div v-if="member">
    <v-container>
      <v-row>
        <v-col cols="4">
          <v-card class="mb-6">
            <v-card-title
              >{{ member.firstname }} {{ member.lastname }}</v-card-title
            >

            <v-card-subtitle v-if="member.membershipNumber">
              <div class="text--secondary">Rego:</div>
              <div class="text--primary">{{ member.membershipNumber }}</div>
            </v-card-subtitle>

            <v-card-text>
              <div class="text--secondary">Date of Birth:</div>
              <div class="text--primary">
                {{ member.dateOfBirth | dateOfBirth }}
              </div>

              <div class="text--secondary">Gender:</div>
              <div class="text--primary">{{ member.gender }}</div>
            </v-card-text>
          </v-card>

          <v-card>
            <v-card-title>Administration</v-card-title>
            <v-card-text>
              <v-chip>{{ member.state | capitalize }}</v-chip>
              <v-chip>{{ member.managementState | capitalize }}</v-chip>
              <v-chip v-if="member.expiry">{{ member.expiry }}</v-chip>
            </v-card-text>
            <v-card-text>
              <v-btn>Disable member</v-btn>
              <v-btn>Mute member</v-btn>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card>
            <v-card-title>Details</v-card-title>

            <v-card-text>
              <div class="text--secondary">Address:</div>
              <div class="text--primary">{{ address }}</div>
            </v-card-text>

            <v-card-text>
              <template v-if="member.email">
                <div class="text--secondary">Email:</div>
                <div class="text--primary">{{ member.email }}</div>
              </template>
            </v-card-text>

            <v-card-text>
              <template v-if="member.phoneHome">
                <div class="text--secondary">Homephone:</div>
                <div class="text--primary">{{ member.phoneHome }}</div>
              </template>

              <template v-if="member.phoneWork">
                <div class="text--secondary">Workphone:</div>
                <div class="text--primary">{{ member.phoneWork }}</div>
              </template>

              <template v-if="member.phoneMobile">
                <div class="text--secondary">Mobile:</div>
                <div class="text--primary">{{ member.phoneMobile }}</div>
              </template>
            </v-card-text>

            <v-card-text v-if="member.schoolName || member.schoolYearLevel">
              <template v-if="member.schoolName">
                <div class="text--secondary">School Name:</div>
                <div class="text--primary">{{ member.schoolName }}</div>
              </template>

              <template v-if="member.schoolYearLevel">
                <div class="text--secondary">School Year Level:</div>
                <div class="text--primary">{{ member.schoolYearLevel }}</div>
              </template>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card class="mb-6">
            <v-card-title>Roles</v-card-title>

            <v-list>
              <template v-for="item in member.roles">
                <v-list-item :key="item.role.id">
                  <v-list-item-content>
                    <v-list-item-title>{{ item.role.name }}</v-list-item-title>
                    <v-list-item-subtitle>
                      {{ item.role.section.name }} -
                      {{ item.role.section.scoutGroup.name }}
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-list>
          </v-card>
          <v-card>
            <v-card-title>Emergency Contacts</v-card-title>

            <v-list>
              <template v-for="item in member.contacts">
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
                </v-list-item>
              </template>
            </v-list>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-data-table
            :headers="headers.contacts"
            :items="member.contacts"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Contacts</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <nuxt-link :to="{ path: `/contacts/create/for-member/${id}/` }">
                  <v-btn color="primary" dark class="mb-2"
                    >New Local Contact</v-btn
                  >
                </nuxt-link>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <nuxt-link :to="{ path: `/contacts/${item.id}` }">
                <v-icon small class="mr-2">mdi-eye</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/contacts/${item.id}/edit` }">
                <v-icon small class="mr-2">mdi-pencil</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/contacts/${item.id}/edit` }">
                <v-icon small>mdi-delete</v-icon>
              </nuxt-link>
            </template>
          </v-data-table>
        </v-col>
        <v-col cols="12">
          <v-data-table
            :headers="headers.roles"
            :items="member.roles"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Roles</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <nuxt-link :to="{ path: `/roles/create/for-member/${id}/` }">
                  <v-btn color="primary" dark class="mb-2"
                    >New Local Role</v-btn
                  >
                </nuxt-link>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <nuxt-link :to="{ path: `/roles/${item.role.id}/edit` }">
                <v-icon small class="mr-2">mdi-pencil</v-icon>
              </nuxt-link>
              <nuxt-link :to="{ path: `/roles/${item.role.id}/edit` }">
                <v-icon small>mdi-delete</v-icon>
              </nuxt-link>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
    <pre>{{ member }}</pre>
  </div>
  <v-container v-else-if="loading">
    <v-row>
      <v-col cols="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="4">
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
import { MemberData } from '@api/models';

import { namespace as memberNamespace } from '~/store/member';

@Component
export default class MemberDetailPage extends Vue {
  get id(): number {
    return Number(this.$route.params.id);
  }

  get member(): MemberData | null {
    const member = this.$store.getters[`${memberNamespace}/getMemberById`](
      this.id
    );
    if (!member) {
      return null;
    }
    return member;
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

  async mounted() {
    try {
      await this.$store.dispatch(`${memberNamespace}/fetchMemberById`, this.id);
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  get address() {
    if (!this.member) {
      return '';
    }

    return 'Address placeholder';

    // const street1 = this.member.address.street1 || '';
    // const street2 = this.member.address.street2 || '';
    // const city = this.member.address.city || '';
    // const state = this.member.address.state || '';
    // const postcode = this.member.address.postcode || '';

    // return `${street1} ${street2} ${city} ${state} ${postcode}`;
  }
}
</script>
