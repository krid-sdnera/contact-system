<script setup lang="ts">
const { isLoggedIn, doLogout } = useAuth();

import { useStorage } from '@vueuse/core';
const drawer = useStorage<boolean>('drawer', true);

const items = [
  {
    icon: 'mdi-apps',
    title: 'Dashboard',
    to: '/',
  },
  {
    icon: 'mdi-account',
    title: 'Members',
    to: '/members',
  },
  {
    icon: 'mdi-account-child',
    title: 'Contacts',
    to: '/contacts',
  },
  {
    icon: 'mdi-baguette',
    title: 'Roles',
    to: '/roles',
  },
  {
    icon: 'mdi-account-multiple',
    title: 'Sections',
    to: '/sections',
  },
  {
    icon: 'mdi-office-building',
    title: 'Groups',
    to: '/groups',
  },
  {
    icon: 'mdi-email',
    title: 'Lists',
    to: '/lists',
  },
  {
    icon: 'mdi-sine-wave',
    title: 'Audit',
    to: '/audits',
  },
];
</script>

<template>
  <v-app>
    <v-navigation-drawer v-model="drawer">
      <!--      :location="$vuetify.display.mobile ? 'bottom' : undefined"
-->
      <v-list-item
        title="Contact System"
        subtitle="15th Essendon"
      ></v-list-item>
      <v-divider></v-divider>
      <v-list-item
        v-for="(item, i) in items"
        :key="i"
        nav
        :title="item.title"
        :to="item.to"
        router
        exact
      >
        <template v-slot:prepend>
          <v-icon :icon="item.icon"></v-icon>
        </template>
      </v-list-item>
    </v-navigation-drawer>
    <v-app-bar>
      <v-app-bar-nav-icon
        variant="text"
        @click.stop="drawer = !drawer"
      ></v-app-bar-nav-icon>

      <v-toolbar-items>
        <Breadcrumbs></Breadcrumbs>
      </v-toolbar-items>

      <RequestStatus />

      <v-spacer />

      <SearchDialogSearch></SearchDialogSearch>

      <v-btn color="primary" v-if="!isLoggedIn" nuxt to="/login">Login</v-btn>
      <v-btn color="primary" v-else @click="doLogout">Logout</v-btn>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <slot />
      </v-container>
    </v-main>

    <AlertList />
  </v-app>
</template>
