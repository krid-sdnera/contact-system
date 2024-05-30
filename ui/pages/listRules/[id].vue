<script setup lang="ts">
import type {
  ListRuleData,
  ListRuleOverrideData,
} from '~/server/types/listRule';

useHead({
  title: 'ListRules',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/listRules`, label: `ListRules` },
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
const listRuleId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchListRule } = useListRule();
const { listRule, status } = useFetchListRule(listRuleId);

function isOverridden(field: string | string[]): boolean {
  const fields = typeof field === 'string' ? [field] : field;

  return fields.some(
    (field) =>
      listRule.value?.overrides?.[field as keyof ListRuleOverrideData] === true
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
//   return this.$store.getters[`${contact.namespace}/getContactsByListRuleId`](
//     listRuleId
//   );
// });

// const roles = computed((): ListRuleRoleData[] => {
//   return this.$store.getters[`${listRule.namespace}/getRolesByListRuleId`](
//     listRuleId
//   );
// });
</script>

<template>
  <div v-if="listRule && status === 'success'">
    <ListRulesUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :listRule="listRule"
    ></ListRulesUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- ListRule Details -->
        <v-card class="mb-6">
          <OverridableTitle
            label="ListRule"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ listRule.firstname }} {{ listRule.lastname }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText label="Rego" :overridden="isOverridden('gender')">
              {{ listRule.listRuleshipNumber }}
            </OverridableText>

            <OverridableText
              label="Date of Birth"
              :overridden="isOverridden('dateOfBirth')"
            >
              {{ $filters.date(listRule.dateOfBirth) }}
              ({{ $filters.duration(listRule.dateOfBirth) }})
            </OverridableText>

            <OverridableText
              label="Gender"
              :overridden="isOverridden('gender')"
            >
              {{ listRule.gender }}
            </OverridableText>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>

        <!-- ListRule Management -->
        <v-card>
          <v-card-title>Administration</v-card-title>
          <v-card-text>
            <v-chip class="mb-1">
              {{ $filters.capitalize(listRule.managementState) }}
            </v-chip>
            <v-chip v-if="listRule.expiry" class="mb-1">{{
              listRule.expiry
            }}</v-chip>
          </v-card-text>
          <v-card-text>
            <v-chip v-if="listRule.autoUpgradeEnabled === true" class="mb-1"
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
          <template v-if="listRule.metaInvite">
            <template v-if="listRule.metaInvite.type === 'inviteActive'">
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="red--text">mdi-close</v-icon>
                  <span>Awaiting listRule completion</span>
                </OverridableText>

                <OverridableText label="This invite will expire on">
                  {{ $filters.date(listRule.metaInvite.expiryDate) }}
                  ({{ $filters.duration(listRule.metaInvite.expiryDate) }})
                </OverridableText>

                <OverridableText label="Status">
                  {{ listRule.metaInvite.status }}
                </OverridableText>
              </v-card-text>
            </template>
            <template
              v-if="listRule.metaInvite.type === 'inviteAwaitingApproval'"
            >
              <v-card-text>
                <OverridableText label="Invitation process active">
                  <v-icon class="green--text">mdi-check</v-icon>
                  ListRule has completed invite<br />
                  <v-icon class="red--text">mdi-close</v-icon>
                  Awaiting Group Leader approval
                </OverridableText>

                <OverridableText label="This invite was submitted on">
                  {{ $filters.date(listRule.metaInvite.submittedDate) }}
                  ({{ $filters.duration(listRule.metaInvite.submittedDate) }})
                </OverridableText>

                <OverridableText label="Level Description">
                  {{ listRule.metaInvite.levelDescription }}
                </OverridableText>
              </v-card-text>
            </template>
          </template>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- ListRule Details -->
        <v-card>
          <OverridableTitle
            :label="`${listRule.firstname} ${listRule.lastname}'${
              listRule.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Address"
              :overridden="isOverridden('address')"
              :to="$filters.googleMapsLink(listRule.address)"
            >
              {{ $filters.address(listRule.address) }}
            </OverridableText>

            <OverridableText label="Email" :overridden="isOverridden('email')">
              {{ listRule.email }}
            </OverridableText>

            <OverridableText
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ $filters.phone(listRule.phoneHome) }}
            </OverridableText>
            <OverridableText
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ $filters.phone(listRule.phoneWork) }}
            </OverridableText>
            <OverridableText
              label="Mobile"
              :overridden="isOverridden('phoneMobile')"
            >
              {{ $filters.phone(listRule.phoneMobile) }}
            </OverridableText>

            <!-- ListRule School Details -->
            <template v-if="listRule.schoolName || listRule.schoolYearLevel">
              <OverridableText
                label="School Name"
                :overridden="isOverridden('schoolName')"
              >
                {{ listRule.schoolName }}
              </OverridableText>

              <OverridableText
                label="School Year Level"
                :overridden="isOverridden('schoolYearLevel')"
              >
                {{ listRule.schoolYearLevel }}
              </OverridableText>
            </template>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- ListRule Role Summary -->
        <v-card class="mb-6">
          <OverridableTitle label="ListRule"> Roles </OverridableTitle>

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
        <!-- ListRule Contacts Summary -->
        <v-card>
          <OverridableTitle label="ListRule">
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
        <!-- ListRule Contact Table -->
        <ContactsList :listRule="listRule" allow-creation></ContactsList>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <!-- ListRule Role Table -->
        <ListRuleRolesList
          :listRule="listRule"
          allow-creation
        ></ListRuleRolesList>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <!-- <list-rules-table
          :preset-relation="listRule"
          preset-relation-type="ListRule"
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
