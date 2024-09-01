<script setup lang="ts">
useHead({
  title: 'Contacts',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/contacts`, label: `Contacts` },
  ]),
});
</script>

<template>
  <v-row>
    <v-col>
      <ContactsList allow-creation searchable track-params></ContactsList>
    </v-col>
  </v-row>
</template>
