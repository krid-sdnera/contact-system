<script setup lang="ts">
useHead({
  title: 'ListMembers',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/listListMembers`, label: `ListMembers` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <ListMembersList allow-creation searchable></ListMembersList>
    </v-col>
  </v-row>
</template>
