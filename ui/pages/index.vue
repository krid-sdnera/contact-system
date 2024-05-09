<script setup lang="ts">
useHead({
  title: 'Home',
});

definePageMeta({
  breadcrumbs: useBuildBreadcrumbs([{ to: `/`, label: `Home` }]),
});
</script>

<template>
  <v-row>
    <v-col>
      <v-card>
        <v-card-title class="headline">The Contact system</v-card-title>
        <v-card-text>
          <v-list>
            <v-list-item to="/members" nuxt>
              <template #prepend>
                <v-icon color="green">mdi-account</v-icon>
              </template>
              View current members
            </v-list-item>
            <v-list-item to="/members/invites" nuxt>
              <template #prepend>
                <v-icon color="green">mdi-account-multiple-plus</v-icon>
              </template>
              View invited members (TODO)
            </v-list-item>
          </v-list>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col>
      <v-card>
        <v-card-title class="headline"> Quick Access </v-card-title>
        <v-card-text> {Link to different units} (TODO)</v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
