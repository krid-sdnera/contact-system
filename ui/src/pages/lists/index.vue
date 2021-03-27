<template>
  <lists-table searchable allow-creation></lists-table>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import ListTableComponent from '~/components/tables/lists-table.vue';

@Component({
  components: {
    ListTableComponent,
  },
})
export default class ListsListPage extends Vue {}
</script>
