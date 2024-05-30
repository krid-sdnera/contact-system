<script setup lang="ts">
import type {
  ListMemberData,
  ListMemberOverrideData,
} from '~/server/types/listListMember';

useHead({
  title: 'ListMembers',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/listListMembers`, label: `ListMembers` },
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
const listListMemberId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchListMember } = useListMember();
const { listListMember, status } = useFetchListMember(listListMemberId);

function isOverridden(field: string | string[]): boolean {
  const fields = typeof field === 'string' ? [field] : field;

  return fields.some(
    (field) =>
      listListMember.value?.overrides?.[
        field as keyof ListMemberOverrideData
      ] === true
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
//   return this.$store.getters[`${contact.namespace}/getContactsByListMemberId`](
//     listListMemberId
//   );
// });

// const roles = computed((): ListMemberRoleData[] => {
//   return this.$store.getters[`${listListMember.namespace}/getRolesByListMemberId`](
//     listListMemberId
//   );
// });
</script>

<template>
  <div v-if="listListMember && status === 'success'">
    <ListMembersUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :listListMember="listListMember"
    ></ListMembersUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- ListMember Details -->
        <v-card class="mb-6">
          <OverridableTitle
            label="ListMember"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ listListMember.firstname }} {{ listListMember.lastname }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText label="Rego" :overridden="isOverridden('gender')">
              {{ listListMember.listListMembershipNumber }}
            </OverridableText>

            <OverridableText
              label="Date of Birth"
              :overridden="isOverridden('dateOfBirth')"
            >
              {{ $filters.date(listListMember.dateOfBirth) }}
              ({{ $filters.duration(listListMember.dateOfBirth) }})
            </OverridableText>

            <OverridableText
              label="Gender"
              :overridden="isOverridden('gender')"
            >
              {{ listListMember.gender }}
            </OverridableText>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>

        <!-- ListMember Management -->
        <v-card>
          <v-card-title>Administration</v-card-title>
          <v-card-text>
            <v-chip class="mb-1">
              {{ $filters.capitalize(listListMember.managementState) }}
            </v-chip>
            <v-chip v-if="listListMember.expiry" class="mb-1">{{
              listListMember.expiry
            }}</v-chip>
          </v-card-text>
          <v-card-text>
            <v-chip
              v-if="listListMember.autoUpgradeEnabled === true"
              class="mb-1"
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
          <template v-if="listListMember.metaInvite">
            <template v-if="listListMember.metaInvite.type === 'inviteActive'">
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="red--text">mdi-close</v-icon>
                  <span>Awaiting listListMember completion</span>
                </OverridableText>

                <OverridableText label="This invite will expire on">
                  {{ $filters.date(listListMember.metaInvite.expiryDate) }}
                  ({{
                    $filters.duration(listListMember.metaInvite.expiryDate)
                  }})
                </OverridableText>

                <OverridableText label="Status">
                  {{ listListMember.metaInvite.status }}
                </OverridableText>
              </v-card-text>
            </template>
            <template
              v-if="listListMember.metaInvite.type === 'inviteAwaitingApproval'"
            >
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="green--text">mdi-check</v-icon>
                  ListMember has completed invite<br />
                  <v-icon class="red--text">mdi-close</v-icon>
                  Awaiting Group Leader approval
                </OverridableText>

                <OverridableText label="This invite was submitted on">
                  {{ $filters.date(listListMember.metaInvite.submittedDate) }}
                  ({{
                    $filters.duration(listListMember.metaInvite.submittedDate)
                  }})
                </OverridableText>

                <OverridableText label="Level Description">
                  {{ listListMember.metaInvite.levelDescription }}
                </OverridableText>
              </v-card-text>
            </template>
          </template>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- ListMember Details -->
        <v-card>
          <OverridableTitle
            :label="`${listListMember.firstname} ${listListMember.lastname}'${
              listListMember.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Address"
              :overridden="isOverridden('address')"
              :to="$filters.googleMapsLink(listListMember.address)"
            >
              {{ $filters.address(listListMember.address) }}
            </OverridableText>

            <OverridableText label="Email" :overridden="isOverridden('email')">
              {{ listListMember.email }}
            </OverridableText>

            <OverridableText
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ $filters.phone(listListMember.phoneHome) }}
            </OverridableText>
            <OverridableText
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ $filters.phone(listListMember.phoneWork) }}
            </OverridableText>
            <OverridableText
              label="Mobile"
              :overridden="isOverridden('phoneMobile')"
            >
              {{ $filters.phone(listListMember.phoneMobile) }}
            </OverridableText>

            <!-- ListMember School Details -->
            <template
              v-if="listListMember.schoolName || listListMember.schoolYearLevel"
            >
              <OverridableText
                label="School Name"
                :overridden="isOverridden('schoolName')"
              >
                {{ listListMember.schoolName }}
              </OverridableText>

              <OverridableText
                label="School Year Level"
                :overridden="isOverridden('schoolYearLevel')"
              >
                {{ listListMember.schoolYearLevel }}
              </OverridableText>
            </template>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- ListMember Role Summary -->
        <v-card class="mb-6">
          <OverridableTitle label="ListMember"> Roles </OverridableTitle>

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
        <!-- ListMember Contacts Summary -->
        <v-card>
          <OverridableTitle label="ListMember">
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
        <!-- ListMember Contact Table -->
        <ContactsList
          :listListMember="listListMember"
          allow-creation
        ></ContactsList>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <!-- ListMember Role Table -->
        <ListMemberRolesList
          :listListMember="listListMember"
          allow-creation
        ></ListMemberRolesList>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <!-- <list-rules-table
          :preset-relation="listListMember"
          preset-relation-type="ListMember"
          allow-creation
        ></list-rules-table> -->
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
