<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

useHead({
  title: 'ScoutGroups',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/groups`, label: `Groups` },
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
const scoutGroupId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchScoutGroup } = useScoutGroup();
const { scoutGroup, status } = useFetchScoutGroup(scoutGroupId);

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}
</script>

<template>
  <div v-if="scoutGroup && status === 'success'">
    <ScoutGroupsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :scoutGroup="scoutGroup"
    ></ScoutGroupsUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- ScoutGroup Details -->
        <v-card class="mb-6">
          <OverridableTitle label="Group">
            {{ scoutGroup.name }}
          </OverridableTitle>

          <v-card-text></v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Jumps -->
        <v-card class="mb-6">
          <OverridableTitle label="Jump to"></OverridableTitle>

          <v-card-text>
            <OverridableText :to="{ hash: '#sections' }">
              Sections
            </OverridableText>
            <OverridableText :to="{ hash: '#list-rules' }">
              List Rules
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row id="sections">
      <v-col>
        <!-- Sections Table -->
        <SectionsList :scout-group="scoutGroup" allow-creation></SectionsList>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col>
        <!-- Email Rules Table -->
        <ListRulesList
          :relation="{ scoutGroup }"
          allow-creation
        ></ListRulesList>
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
