<template>
  <contacts-table searchable></contacts-table>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import ContactTableComponent from '~/components/tables/contacts-table.vue';

@Component({
  components: {
    ContactTableComponent,
  },
})
export default class ContactsListPage extends Vue {}
</script>
