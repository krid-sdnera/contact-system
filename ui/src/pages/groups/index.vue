<template>
  <v-row>
    <v-col>
      <scout-groups-table allow-creation searchable></scout-groups-table>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import {
  AppBreadcrumbOptions,
  setBreadcrumbs,
} from '~/common/helper-factories';
import ScoutGroupTableComponent from '~/components/tables/scout-groups-table.vue';

@Component({ components: { ScoutGroupTableComponent } })
export default class GroupsListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Groups' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
