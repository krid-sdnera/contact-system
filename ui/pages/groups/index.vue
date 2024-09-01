<script setup lang="ts">
useHead({
  title: 'ScoutGroups',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/groups`, label: `Groups` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <ScoutGroupsList allow-creation searchable track-params></ScoutGroupsList>
    </v-col>
  </v-row>
</template>
