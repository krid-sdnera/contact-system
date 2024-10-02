<script setup lang="ts">
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
const { section: sectionRef, status } = useFetchSection(sectionId);

const section = computed(() =>
  status.value === 'success' ? sectionRef.value : null
);
</script>

<template>
  <div>
    <v-row>
      <v-col>
        <v-card v-if="section" color="light-green-darken-4">
          <OverridableTitle label="Section">
            {{ section.name }}
          </OverridableTitle>
        </v-card>
        <v-skeleton-loader v-else type="heading"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row class="flex-row-reverse">
      <v-col cols="12" sm="3">
        <v-row>
          <v-col cols="12">
            <CardSectionJump
              :jumps="[
                { label: 'Roles', hash: '#roles' },
                { label: 'Members', hash: '#members' },
                { label: 'List Rules', hash: '#list-rules' },
              ]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <SectionsCardAdmin :section="section"></SectionsCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <SectionsCardDetails :section="section"></SectionsCardDetails>
          </v-col>
          <v-col cols="12" sm="6">
            <SectionsCardExtranet :section="section"></SectionsCardExtranet>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="roles">
      <v-col v-if="section">
        <!-- Roles Table -->
        <RolesList :section="section" allow-creation></RolesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="members">
      <v-col v-if="section">
        <!-- Members Table -->
        <MembersList :section="section" searchable></MembersList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="section">
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ section }" allow-creation></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
