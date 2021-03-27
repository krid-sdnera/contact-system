<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :permanent="!isMobile"
      :clipped="clipped"
      :mini-variant.sync="mini"
      :expand-on-hover="expandOnHover"
      app
      bottom
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
          :id="`menu-item-${i}`"
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template v-slot:append>
        <v-list v-if="!isMobile">
          <v-list-item
            @click.stop="
              expandOnHover = !expandOnHover;
              mini = !mini;
              clipped = !clipped;
            "
          >
            <v-list-item-action>
              <v-icon v-if="expandOnHover && mini">mdi-chevron-right</v-icon>
              <v-icon v-else-if="expandOnHover && !mini"
                >mdi-pin-outline</v-icon
              >
              <v-icon v-else>mdi-pin</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title v-if="expandOnHover">Pin</v-list-item-title>
              <v-list-item-title v-else>Collapse</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <div v-if="!mini" class="d-flex justify-center align-center mb-2">
          <span class="mx-1">&copy;</span>
          <span class="mx-1">&middot;</span>
          <span class="mx-1" style="font-size: 0.5em;">DA</span>
          <span class="mx-1">&middot;</span>
          <span class="mx-1">{{ new Date().getFullYear() }} </span>
        </div>
      </template>
    </v-navigation-drawer>
    <v-app-bar fixed app :clipped-left="clipped">
      <v-btn v-if="isMobile" icon @click.stop="menuDrawer = !menuDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn>
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <search-table v-if="!isMobile"></search-table>
      <v-btn color="primary" v-if="!isLoggedIn" nuxt to="/login">Login</v-btn>
      <v-btn color="primary" v-else @click="handleLogout">Logout</v-btn>
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
    <alerts></alerts>
  </v-app>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import Alerts from '~/components/alerts/alerts.vue';
import SearchTable from '~/components/tables/search-table.vue';
import * as ui from '~/store/ui';
import * as auth from '~/store/auth';

@Component({ components: { Alerts, SearchTable } })
export default class DefaultLayout extends Vue {
  clipped = true;
  menuDrawer = false;
  fixed = false;
  items = [
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

  expandOnHover = true;
  mini = true;
  right = true;
  rightDrawer = false;
  title = 'Contact System';

  get drawer() {
    return this.menuDrawer || !this.isMobile;
  }
  set drawer(value) {
    this.menuDrawer = value;
  }

  get isMobile() {
    if (typeof this.$vuetify.breakpoint.name === 'number') {
      return;
    }
    return ['xs', 'sm'].includes(this.$vuetify.breakpoint.name);
  }

  @Watch('isMobile', { immediate: true })
  handleBreakpointChange(isMobile: boolean) {
    console.log('ismobile', isMobile);
    this.mini = !isMobile;
    this.expandOnHover = !isMobile;
    this.clipped = !isMobile;
    this.menuDrawer = !isMobile;
  }

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
