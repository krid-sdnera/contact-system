<template>
  <v-container>
    <v-row>
      <v-col>
        <sections-table allow-creation searchable></sections-table>
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
import SectionTableComponent from '~/components/tables/sections-table.vue';

@Component({ components: { SectionTableComponent } })
export default class SectionsListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Sections' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
