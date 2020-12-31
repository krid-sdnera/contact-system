<template>
  <members-table allow-creation searchable></members-table>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';

@Component({ components: { MemberTableComponent } })
export default class MembersListPage extends Vue {}
</script>
