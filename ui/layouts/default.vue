<script setup lang="ts">
const { isLoggedIn, doLogout } = useAuth();

// Search related props
const searchQuery = ref<string>('');
const searchDialog = ref<boolean>(false);
watch(searchQuery, (newQuery, oldQuery) => {
  if (newQuery === '') {
    // New query is empty, dont close or open dialog.
    return;
  }

  if (newQuery !== '' && searchDialog.value === false) {
    // Old query was empty, but new query has data, open dialog.
    searchDialog.value = true;
  }
});
function searchClose() {
  searchDialog.value = false;
  searchQuery.value = '';
}

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
    icon: 'mdi-account-supervisor-circle',
    title: 'Sections',
    to: '/sections',
  },
  {
    icon: 'mdi-account-group',
    title: 'Groups',
    to: '/groups',
  },
  {
    icon: 'mdi-email',
    title: 'Lists',
    to: '/lists',
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

      <!-- <v-toolbar-title >Contact System</v-toolbar-title> -->
      <v-toolbar-items>
        <Breadcrumbs></Breadcrumbs>
      </v-toolbar-items>

      <RequestStatus />

      <v-spacer />

      <v-text-field
        v-model="searchQuery"
        hide-details
        clearable
        label="Search"
        class="mr-4"
      ></v-text-field>

      <v-btn color="primary" v-if="!isLoggedIn" nuxt to="/login">Login</v-btn>
      <v-btn color="primary" v-else @click="doLogout">Logout</v-btn>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <slot />
      </v-container>

      <v-dialog
        content-class="dialog-position-top"
        v-model="searchDialog"
        :location="'top'"
        min-height="50vh"
      >
        <v-card>
          <v-card-text>
            <SearchList
              v-model="searchQuery"
              @close="searchClose()"
            ></SearchList>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-main>

    <AlertList />
  </v-app>
</template>

<style scoped>
:deep(.dialog-position-top) {
  align-self: flex-start;
}
</style>
