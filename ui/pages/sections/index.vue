<script setup lang="ts">
useHead({
  title: 'Sections',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/sections`, label: `Sections` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <SectionsList allow-creation searchable></SectionsList>
    </v-col>
  </v-row>
</template>
