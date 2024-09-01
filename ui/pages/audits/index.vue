<script setup lang="ts">
useHead({
  title: 'Audits',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/audits`, label: `Audits` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <AuditsList searchable track-params></AuditsList>
    </v-col>
  </v-row>
</template>
