<template>
  <v-container>
    <v-row>
      <v-col>
        <contacts-table searchable></contacts-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import { AppBreadcrumbOptions, setBreadcrumbs } from '~/common/breadcrumb';
import ContactTableComponent from '~/components/tables/contacts-table.vue';

@Component({
  components: {
    ContactTableComponent,
  },
})
export default class ContactsListPage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [
      { to: '/', label: 'Dashboard' },
      { to: null, label: 'Contacts' },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }
}
</script>
