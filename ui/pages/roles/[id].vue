<script setup lang="ts">
import type { RoleData } from '~/server/types/role';

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
const { role, status } = useFetchRole(roleId);

const section = computed(() => role.value?.section);
const scoutGroup = computed(() => role.value?.section.scoutGroup);

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}
</script>

<template>
  <div v-if="role && section && scoutGroup && status === 'success'">
    <RolesUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :role="role"
    ></RolesUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Role Details -->
        <v-card class="mb-6">
          <OverridableTitle label="Role">
            {{ role.name }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText label="Section" :to="`/sections/${section.id}`">
              {{ section.name }}
            </OverridableText>
            <OverridableText label="Group" :to="`/groups/${scoutGroup.id}`">
              {{ scoutGroup.name }}
            </OverridableText>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Scout Group Details -->
        <v-card class="mb-6">
          <OverridableTitle label="Extranet"> Advanced </OverridableTitle>
          <v-card-text>
            <OverridableText label="Role Id">
              {{ role.externalId }}
            </OverridableText>
            <OverridableText label="Class Id">
              {{ role.classId }}
            </OverridableText>
            <OverridableText label="Normalised Class Id">
              {{ role.normalisedClassId }}
            </OverridableText>
            <OverridableText label="Section Id">
              {{ section.externalId }}
            </OverridableText>
            <OverridableText label="Group Id">
              {{ scoutGroup.externalId }}
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <MembersList :role="role" searchable></MembersList>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ role }" allow-creation></ListRulesList>
      </v-col>
    </v-row>
  </div>
  <div v-else-if="status === 'pending'">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <div v-else>{{ status }}</div>
  <!-- <error-display v-else :error="'unknown''"></error-display> -->
</template>
