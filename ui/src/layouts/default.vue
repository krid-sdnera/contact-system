<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar :clipped-left="clipped" fixed app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-btn icon @click.stop="miniVariant = !miniVariant">
        <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
      </v-btn>
      <v-btn icon @click.stop="clipped = !clipped">
        <v-icon>mdi-application</v-icon>
      </v-btn>
      <v-btn icon @click.stop="fixed = !fixed">
        <v-icon>mdi-minus</v-icon>
      </v-btn>
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <v-btn icon @click.stop="rightDrawer = !rightDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn>
    </v-app-bar>
    <v-dialog
      v-model="isUpdateApiRequestInProgress"
      hide-overlay
      persistent
      width="300"
    >
      <v-card color="primary">
        <v-card-text>
          Saving data
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-main>
      <v-container>
        <nuxt />
      </v-container>
    </v-main>
    <v-navigation-drawer v-model="rightDrawer" :right="right" temporary fixed>
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light>
              mdi-repeat
            </v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-footer :absolute="!fixed" app>
      <span>&copy; {{ new Date().getFullYear() }}</span>
      <v-spacer />
      <v-btn @click="handleLogout">Logout</v-btn>
      <div>
        <v-tooltip v-if="!$vuetify.theme.dark" bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-on="on"
              color="info"
              small
              fab
              @click="$vuetify.theme.dark = !$vuetify.theme.dark"
            >
              <v-icon class="mr-1">mdi-moon-waxing-crescent</v-icon>
            </v-btn>
          </template>
          <span>Dark Mode On</span>
        </v-tooltip>

        <v-tooltip v-else bottom>
          <template v-slot:activator="{ on }">
            <v-btn
              v-on="on"
              color="info"
              small
              fab
              @click="$vuetify.theme.dark = !$vuetify.theme.dark"
            >
              <v-icon color="yellow">mdi-white-balance-sunny</v-icon>
            </v-btn>
          </template>
          <span>Dark Mode Off</span>
        </v-tooltip>
      </div>
    </v-footer>
    <alerts></alerts>
  </v-app>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import Alerts from '~/components/alerts/alerts.vue';
import * as ui from '~/store/ui';
import * as auth from '~/store/auth';

@Component({ components: { Alerts } })
export default class DefaultLayout extends Vue {
  clipped = false;
  drawer = false;
  fixed = false;
  items = [
    {
      icon: 'mdi-apps',
      title: 'Dashboard',
      to: '/',
    },
    {
      icon: 'mdi-chart-bubble',
      title: 'Members',
      to: '/members',
    },
    {
      icon: 'mdi-chart-bubble',
      title: 'Contacts',
      to: '/contacts',
    },
    {
      icon: 'mdi-chart-bubble',
      title: 'Roles',
      to: '/roles',
    },
    {
      icon: 'mdi-chart-bubble',
      title: 'Sections',
      to: '/sections',
    },
    {
      icon: 'mdi-chart-bubble',
      title: 'Groups',
      to: '/groups',
    },
  ];

  miniVariant = false;
  right = true;
  rightDrawer = false;
  title = 'Contact System';

  get isUpdateApiRequestInProgress(): boolean {
    return this.$store.getters[`${ui.namespace}/isUpdateApiRequestInProgress`];
  }

  async handleLogout() {
    await this.$store.dispatch(`${auth.namespace}/logout`);
  }

  get isLoggedIn(): boolean {
    return this.$store.getters[`${auth.namespace}/isLoggedIn`];
  }
}
</script>
