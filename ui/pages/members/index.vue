<script setup lang="ts">
useHead({
  title: 'Members',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/members`, label: `Members` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <MembersList allow-creation searchable track-params></MembersList>
    </v-col>
  </v-row>
</template>
