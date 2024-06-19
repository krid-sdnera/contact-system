<script setup lang="ts">
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
const { scoutGroup: scoutGroupRef, status } = useFetchScoutGroup(scoutGroupId);

const scoutGroup = computed(() =>
  status.value === 'success' ? scoutGroupRef.value : null
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
                { label: 'Sections', hash: '#sections' },
                { label: 'List Rules', hash: '#list-rules' },
              ]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <ScoutGroupsCardAdmin
              :scoutGroup="scoutGroup"
            ></ScoutGroupsCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <ScoutGroupsCardDetails
              :scoutGroup="scoutGroup"
            ></ScoutGroupsCardDetails>
          </v-col>
          <v-col cols="12" sm="6">
            <ScoutGroupsCardExtranet
              :scoutGroup="scoutGroup"
            ></ScoutGroupsCardExtranet>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="sections">
      <v-col v-if="scoutGroup">
        <!-- Sections Table -->
        <SectionsList :scout-group="scoutGroup" allow-creation></SectionsList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="scoutGroup">
        <!-- Email Rules Table -->
        <ListRulesList
          :relation="{ scoutGroup }"
          allow-creation
        ></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
