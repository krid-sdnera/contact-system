<script setup lang="ts">
useHead({
  title: 'Roles',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/roles`, label: `Roles` },
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
const roleId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchRole } = useRole();
const { role: roleRef, status } = useFetchRole(roleId);

const role = computed(() =>
  status.value === 'success' ? roleRef.value : null
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
                { label: 'Members', hash: '#members' },
                { label: 'List Rules', hash: '#list-rules' },
              ]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <RolesCardAdmin :role="role"></RolesCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <RolesCardDetails :role="role"></RolesCardDetails>
          </v-col>
          <v-col cols="12" sm="6">
            <RolesCardExtranet :role="role"></RolesCardExtranet>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="members">
      <v-col v-if="role">
        <MembersList :role="role" searchable></MembersList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="role">
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ role }" allow-creation></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
