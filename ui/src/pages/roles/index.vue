<template>
  <roles-table allow-creation searchable></roles-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import RoleTableComponent from '~/components/tables/roles-table.vue';

@Component({ components: { RoleTableComponent } })
export default class RolesListPage extends Vue {}
</script>
