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
const { member: memberRef, status } = useFetchMember(memberId);

const member = computed(() =>
  status.value === 'success' ? memberRef.value : null
);
</script>

<template>
  <div>
    <v-row class="flex-row-reverse">
      <v-col cols="12" sm="3">
        <v-row>
          <v-col cols="12">
            <CardSectionJump
              :jumps="[
                { label: 'Contacts', hash: '#contacts' },
                { label: 'Assigned Roles', hash: '#member-roles' },
                { label: 'List Rules', hash: '#list-rules' },
              ]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <MembersCardAdmin :member="member"></MembersCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <MembersCardDetails :member="member"></MembersCardDetails>
          </v-col>
          <v-col cols="12" sm="6">
            <MembersCardContact :member="member"></MembersCardContact>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="contacts">
      <v-col v-if="member">
        <!-- Member Contact Table -->
        <ContactsList :member="member" allow-creation></ContactsList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="member-roles">
      <v-col v-if="member">
        <!-- Member Role Table -->
        <MemberRolesList :member="member" allow-creation></MemberRolesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="member">
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ member }" allow-creation></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
