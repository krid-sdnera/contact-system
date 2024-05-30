<script setup lang="ts">
useHead({
  title: 'ListRules',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/listRules`, label: `ListRules` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <ListRulesList allow-creation searchable></ListRulesList>
    </v-col>
  </v-row>
</template>
