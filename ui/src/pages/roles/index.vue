<template>
  <v-container>
    <v-row>
      <v-col>
        <roles-table allow-creation searchable></roles-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import {
  AppBreadcrumbOptions,
  setBreadcrumbs,
} from '~/common/helper-factories';
import RoleTableComponent from '~/components/tables/roles-table.vue';

@Component({ components: { RoleTableComponent } })
export default class RolesListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Roles' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
