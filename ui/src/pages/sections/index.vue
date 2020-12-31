<template>
  <sections-table allow-creation searchable></sections-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import SectionTableComponent from '~/components/tables/sections-table.vue';

@Component({ components: { SectionTableComponent } })
export default class SectionsListPage extends Vue {}
</script>
