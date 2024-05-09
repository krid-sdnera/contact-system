<template>
  <v-row>
    <v-col>
      <members-table allow-creation searchable></members-table>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import {
  AppBreadcrumbOptions,
  setBreadcrumbs,
} from '~/common/helper-factories';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';

@Component({ components: { MemberTableComponent } })
export default class MembersListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Members' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
