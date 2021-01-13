<template>
  <v-autocomplete
    v-model="selected"
    :items="items"
    :loading="loading"
    :search-input.sync="search"
    color="white"
    dense
    hide-details
    hide-no-data
    hide-selected
    item-text="firstname"
    item-value="id"
    placeholder="Start typing to Search"
    prepend-icon="mdi-magnify"
    return-object
    class="mr-3"
  >
    <template v-slot:item="data">
      <template>
        <v-list-item-content>
          <v-list-item-title>
            {{ data.item.firstname }} {{ data.item.lastname }}
          </v-list-item-title>
          <v-list-item-subtitle>{{
            data.item.address | address
          }}</v-list-item-subtitle>
        </v-list-item-content>
      </template>
    </template>
  </v-autocomplete>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  MemberData,
  MemberDataManagementStateEnum,
  MemberDataStateEnum,
  Members,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
import MemberCreateDialog from '~/components/dialogs/member-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as member from '~/store/member';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    MemberCreateDialog,
    DangerConfirmation,
  },
})
export default class SearchTableComponent extends BaseTable<MemberData> {
  name = 'search-table';
  title = 'Search';

  get items(): MemberData[] {
    const itemIdsToDisplay: number[] = this.serverItemIdsToDisplay as number[];
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${member.namespace}/getMembers`]
      .filter((x: MemberData) => itemIdsToDisplay.includes(x.id))
      .sort((a: MemberData, b: MemberData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [];

  async fetchItems() {
    if (this.apiOptions.query === '') {
      this.serverItemIdsToDisplay = [];
      this.totalItems = 0;
      return;
    }

    this.loading = true;

    try {
      const payload: Members = await this.$store.dispatch(
        `${member.namespace}/fetchMembers`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.members.map(
        (member: MemberData) => member.id
      );
      this.totalItems = payload.totalItems;
      if (this.apiOptions.page > payload.totalPages) {
        this.options.page = payload.totalPages;
      }
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  @Watch('selected')
  handleSelectedChange(member: MemberData) {
    console.log(member);
    if (member.id) {
      this.$router.push(`/members/${member.id}`);
    }
  }
}
</script>
