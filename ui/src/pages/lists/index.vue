<template>
  <v-container>
    <v-row>
      <v-col>
        <lists-table searchable allow-creation></lists-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import { AppBreadcrumbOptions, setBreadcrumbs } from '~/common/breadcrumb';
import ListTableComponent from '~/components/tables/lists-table.vue';

@Component({
  components: {
    ListTableComponent,
  },
})
export default class ListsListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Lists' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
