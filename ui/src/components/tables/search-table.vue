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
import { MemberData, Members } from '@api/models';
import { Component, Watch } from 'vue-property-decorator';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';
import MemberCreateDialog from '~/components/dialogs/member-create.vue';
import BaseTable from '~/components/tables/base-table';
import * as member from '~/store/member';

@Component({
  components: {
    MemberCreateDialog,
    DangerConfirmation,
  },
})
export default class SearchTableComponent extends BaseTable<
  MemberData,
  number
> {
  name = 'search-table';
  title = 'Search';

  get items(): MemberData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    return this.$store.getters[`${member.namespace}/getMembers`]
      .filter((x: MemberData) => itemIdsToDisplay.includes(x.id))
      .sort((a: MemberData, b: MemberData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [];

  async fetchItems() {
    if (!this.apiOptions.query || this.apiOptions.query === null) {
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

  selected: MemberData | null = null;

  @Watch('selected')
  handleSelectedChange(member: MemberData) {
    if (member.id) {
      this.$router.push(`/members/${member.id}`);
    }
  }
}
</script>
