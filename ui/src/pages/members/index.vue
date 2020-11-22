<template>
  <v-data-table
    :headers="headers"
    :items="members"
    :options.sync="options"
    :server-items-length="totalMembers"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Members</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-btn color="primary" class="mb-2" @click="openCreateMemberModal"
          >New Local Member</v-btn
        >
        <member-create
          :open.sync="dialogMemberCreate"
          @submit="handleMemberCreateSubmit"
        ></member-create>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn icon nuxt :to="{ path: `/members/${item.id}` }">
        <v-icon small>mdi-eye</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon small color="red">mdi-delete</v-icon>
      </v-btn>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import { MemberData } from '@api/models';
import * as member from '~/store/member';

@Component
export default class MembersListPage extends Vue {
  totalMembers = 5;
  error = false;
  loading = true;
  options: {
    sortBy?: string[];
    sortDesc?: string[];
    page?: number;
    itemsPerPage?: number;
  } = {};
  memberIdsToDisplay: number[] = [];
  search: string = '';

  headers = [
    { text: 'Firstname', value: 'firstname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  get apiOptions() {
    console.log(this.options.page);
    console.log(this.options.itemsPerPage);
    console.log(this.options.sortBy);
    console.log(this.options.sortDesc);

    let sort = '';
    if (
      this.options.sortBy &&
      this.options.sortDesc &&
      this.options.sortBy.length &&
      this.options.sortDesc.length
    ) {
      const sortDir = this.options.sortDesc[0] ? 'DESC' : 'ASC';
      sort = this.options.sortBy[0] + ':' + sortDir;
    }
    return {
      query: this.search,
      sort: sort,
      page: this.options.page || 1,
      pageSize: this.options.itemsPerPage || 25,
    };
  }

  @Watch('search')
  onSearchChange() {
    this.fetchMembersWithNewOptions();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.fetchMembersWithNewOptions();
  }

  get members(): MemberData[] {
    return this.$store.getters[
      `${member.namespace}/getMembers`
    ].filter((member: MemberData) =>
      this.memberIdsToDisplay.includes(member.id)
    );
  }

  async mounted() {}

  async fetchMembersWithNewOptions(): Promise<void> {
    this.loading = true;
    try {
      const memberIds: number[] = await this.$store.dispatch(
        `${member.namespace}/fetchMembers`,
        this.apiOptions
      );
      console.log(memberIds);
      this.memberIdsToDisplay = memberIds;
      this.totalMembers = 22;
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogMemberCreate: boolean = false;

  openCreateMemberModal() {
    this.dialogMemberCreate = true;
  }

  closeCreateMemberModal() {
    this.dialogMemberCreate = false;
  }

  handleMemberCreateSubmit(response: MemberData) {
    if (response?.id) {
      this.$router.push(`/members/${response.id}`);
    }
  }
}
</script>
