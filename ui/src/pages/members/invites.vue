<template>
  <members-table allow-creation searchable invites-only></members-table>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import MemberTableComponent from '~/components/tables/member-roles-table.vue';

@Component({ components: { MemberTableComponent } })
export default class MemberInvitesListPage extends Vue {}
</script>
