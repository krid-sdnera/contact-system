<script setup lang="ts">
import type { MemberData, MemberOverrideData } from '~/server/types/member';

useHead({
  title: 'Members',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/members`, label: `Members` },
    { to: ``, label: `Details` },
  ]),
  validate: async (route) => {
    if (Array.isArray(route.params.id)) {
      return false;
    }

    // Check if the id is made up of digits
    return /^\d+$/.test(route.params.id);
  },
});

const route = useRoute();
const memberId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchMember } = useMember();
const { member, status } = useFetchMember(memberId);

function isOverridden(field: string | string[]): boolean {
  const fields = typeof field === 'string' ? [field] : field;

  return fields.some(
    (field) =>
      member.value?.overrides?.[field as keyof MemberOverrideData] === true
  );
}

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}

// const contacts = computed((): ContactData[] => {
//   return this.$store.getters[`${contact.namespace}/getContactsByMemberId`](
//     memberId
//   );
// });

// const roles = computed((): MemberRoleData[] => {
//   return this.$store.getters[`${member.namespace}/getRolesByMemberId`](
//     memberId
//   );
// });
</script>

<template>
  <div v-if="member && status === 'success'">
    <MembersUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :member="member"
    ></MembersUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Details -->
        <v-card class="mb-6">
          <OverridableTitle
            label="Member"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ member.firstname }} {{ member.lastname }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText label="Rego" :overridden="isOverridden('gender')">
              {{ member.membershipNumber }}
            </OverridableText>

            <OverridableText
              label="Date of Birth"
              :overridden="isOverridden('dateOfBirth')"
            >
              {{ $filters.date(member.dateOfBirth) }}
              ({{ $filters.duration(member.dateOfBirth) }})
            </OverridableText>

            <OverridableText
              label="Gender"
              :overridden="isOverridden('gender')"
            >
              {{ member.gender }}
            </OverridableText>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>

        <!-- Member Management -->
        <v-card>
          <v-card-title>Administration</v-card-title>
          <v-card-text>
            <v-chip class="mb-1">
              {{ $filters.capitalize(member.managementState) }}
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
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-text>
          <template v-if="member.metaInvite">
            <template v-if="member.metaInvite.type === 'inviteActive'">
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="red--text">mdi-close</v-icon>
                  <span>Awaiting member completion</span>
                </OverridableText>

                <OverridableText label="This invite will expire on">
                  {{ $filters.date(member.metaInvite.expiryDate) }}
                  ({{ $filters.duration(member.metaInvite.expiryDate) }})
                </OverridableText>

                <OverridableText label="Status">
                  {{ member.metaInvite.status }}
                </OverridableText>
              </v-card-text>
            </template>
            <template
              v-if="member.metaInvite.type === 'inviteAwaitingApproval'"
            >
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="green--text">mdi-check</v-icon>
                  Member has completed invite<br />
                  <v-icon class="red--text">mdi-close</v-icon>
                  Awaiting Group Leader approval
                </OverridableText>

                <OverridableText label="This invite was submitted on">
                  {{ $filters.date(member.metaInvite.submittedDate) }}
                  ({{ $filters.duration(member.metaInvite.submittedDate) }})
                </OverridableText>

                <OverridableText label="Level Description">
                  {{ member.metaInvite.levelDescription }}
                </OverridableText>
              </v-card-text>
            </template>
          </template>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Details -->
        <v-card>
          <OverridableTitle
            :label="`${member.firstname} ${member.lastname}'${
              member.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Address"
              :overridden="isOverridden('address')"
              :to="$filters.googleMapsLink(member.address)"
            >
              {{ $filters.address(member.address) }}
            </OverridableText>

            <OverridableText label="Email" :overridden="isOverridden('email')">
              {{ member.email }}
            </OverridableText>

            <OverridableText
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ $filters.phone(member.phoneHome) }}
            </OverridableText>
            <OverridableText
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ $filters.phone(member.phoneWork) }}
            </OverridableText>
            <OverridableText
              label="Mobile"
              :overridden="isOverridden('phoneMobile')"
            >
              {{ $filters.phone(member.phoneMobile) }}
            </OverridableText>

            <!-- Member School Details -->
            <template v-if="member.schoolName || member.schoolYearLevel">
              <OverridableText
                label="School Name"
                :overridden="isOverridden('schoolName')"
              >
                {{ member.schoolName }}
              </OverridableText>

              <OverridableText
                label="School Year Level"
                :overridden="isOverridden('schoolYearLevel')"
              >
                {{ member.schoolYearLevel }}
              </OverridableText>
            </template>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Member Role Summary -->
        <v-card class="mb-6">
          <OverridableTitle label="Member"> Roles </OverridableTitle>

          <v-card-text>
            <!-- 
              <OverridableText
                v-for="item in roles"
                :key="item.role.id"
                label=""
                :to="`/roles/${item.role.id}`"
              >
                <template slot="label">
                  {{ item.role.section.scoutGroup.name }}<br />
                  <i>{{ item.role.section.name }}</i>
                </template>
                {{ item.role.name }}
              </OverridableText>
              -->
          </v-card-text>
        </v-card>
        <!-- Member Contacts Summary -->
        <v-card>
          <OverridableTitle label="Member">
            Emergency Contacts
          </OverridableTitle>

          <v-card-text>
            <!-- 
              <OverridableText
                v-for="item in contacts"
                :key="item.id"
                :label="item.relationship"
                :to="`/contacts/${item.id}`"
              >
                {{ item.firstname }}
                {{ item.lastname }}
              </OverridableText>
             -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Member Contact Table -->
        <ContactsList :member="member" allow-creation></ContactsList>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <!-- Member Role Table -->
        <MemberRolesList :member="member" allow-creation></MemberRolesList>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ member }" allow-creation></ListRulesList>
      </v-col>
    </v-row>
  </div>
  <div v-else-if="status === 'pending'">
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
  <div v-else>{{ status }}</div>
  <!-- <error-display v-else :error="'unknown''"></error-display> -->
</template>
