<script setup lang="ts">
useHead({
  title: 'Lists',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/lists`, label: `Lists` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <ListsList allow-creation searchable></ListsList>
    </v-col>
  </v-row>
</template>
