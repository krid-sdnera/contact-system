<script setup lang="ts">
useHead({
  title: 'Roles',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/roles`, label: `Roles` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <RolesList allow-creation searchable track-params></RolesList>
    </v-col>
  </v-row>
</template>
