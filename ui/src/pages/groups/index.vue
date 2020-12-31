<template>
  <scout-groups-table allow-creation searchable></scout-groups-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import ScoutGroupTableComponent from '~/components/tables/scout-groups-table.vue';

@Component({ components: { ScoutGroupTableComponent } })
export default class GroupsListPage extends Vue {}
</script>
