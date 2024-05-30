<script setup lang="ts">
import type { SectionData } from '~/server/types/section';

useHead({
  title: 'Sections',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/sections`, label: `Sections` },
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
const sectionId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchSection } = useSection();
const { section, status } = useFetchSection(sectionId);

const scoutGroup = computed(() => section.value?.scoutGroup);

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}
</script>

<template>
  <div v-if="section && scoutGroup && status === 'success'">
    <SectionsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :section="section"
    ></SectionsUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Section Details -->
        <v-card class="mb-6">
          <OverridableTitle label="section">
            {{ section.name }}
          </OverridableTitle>

          <v-card-text>
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
            <OverridableText label="Section Id">
              {{ section.externalId }}
            </OverridableText>
            <OverridableText label="Group Id">
              {{ scoutGroup.externalId }}
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="4">
        <!-- Jumps -->
        <v-card class="mb-6">
          <OverridableTitle label="Jump to"></OverridableTitle>

          <v-card-text>
            <OverridableText :to="{ hash: '#roles' }"> Roles </OverridableText>
            <OverridableText :to="{ hash: '#members' }">
              Members
            </OverridableText>
            <OverridableText :to="{ hash: '#list-rules' }">
              List Rules
            </OverridableText>
          </v-card-text>
        </v-card>

        <!-- Advanced Details -->
        <v-card class="mb-6">
          <OverridableTitle label="Extranet">Advanced</OverridableTitle>

          <v-card-text>
            <OverridableText label="Section Id">
              {{ section.externalId }}
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row id="roles">
      <v-col>
        <!-- Roles Table -->
        <RolesList :section="section" allow-creation></RolesList>
      </v-col>
    </v-row>

    <v-row id="members">
      <v-col>
        <!-- Members Table -->
        <MembersList :section="section" searchable></MembersList>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col>
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ section }" allow-creation></ListRulesList>
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
      <v-col cols="12">
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <div v-else>{{ status }}</div>
  <!-- <error-display v-else :error="'unknown''"></error-display> -->
</template>
