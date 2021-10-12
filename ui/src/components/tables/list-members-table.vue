<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :options.sync="options"
    :server-items-length="totalItems"
    :loading="loading"
    class="elevation-1"
    :footer-props="{
      showFirstLastPage: true,
      'items-per-page-options': [10, 15, 25],
    }"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-if="searchable"
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-toolbar>
    </template>
    <template v-slot:[`item.type`]="{ item }">
      <span v-if="item.type === 'member'">Member</span>
      <span v-else-if="item.type === 'contact'">Contact</span>
    </template>
    <template v-slot:[`item.list`]="{ item }">
      <span>{{ item.listName }}</span>
      <br />
      <nuxt-link nuxt :to="`/lists/${item.listAddress}`">
        {{ item.listAddress }}
      </nuxt-link>
    </template>
    <template v-slot:[`item.contributingRuleIds`]="{ item }">
      <span v-for="ruleId in item.contributingRuleIds" v-bind:key="ruleId">
        <span v-if="getRuleData(ruleId) !== null">
          {{ getRuleData(ruleId).label }}
        </span>
        <br />
      </span>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { ListData, ListRuleData, RecipientData, Recipients } from '@api/models';
import { Component, Prop } from 'vue-property-decorator';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';
import ListRuleCreateDialog from '~/components/dialogs/list-rule-create.vue';
import BaseTable from '~/components/tables/base-table';
import * as list from '~/store/emailList';

@Component({
  components: {
    ListRuleCreateDialog,
    DangerConfirmation,
  },
})
export default class ListMemberTableComponent extends BaseTable<
  RecipientData,
  string
> {
  name = 'list-members-table';
  title = 'List Members';

  @Prop(Object) readonly list: ListData | undefined;

  get items(): RecipientData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    return this.$store.getters[`${list.namespace}/getRecipients`]
      .filter((x: RecipientData) => itemIdsToDisplay.includes(x.rowId))
      .sort((a: RecipientData, b: RecipientData) => {
        return (
          itemIdsToDisplay.indexOf(a.rowId) - itemIdsToDisplay.indexOf(b.rowId)
        );
      });
  }

  headers = [
    { text: 'ID', value: 'id' },
    { text: 'Type', value: 'type' },
    { text: 'Name', value: 'name' },
    { text: 'Address', value: 'address' },
    { text: 'List', value: 'list' },
    { text: 'Rules', value: 'contributingRuleIds' },
  ];

  async fetchItems() {
    this.loading = true;

    try {
      const payload: Recipients = await this.$store.dispatch(
        `${list.namespace}/fetchListRecipientsById`,
        {
          ...this.apiOptions,
          listId: this.list?.id,
        }
      );

      this.serverItemIdsToDisplay = Array.from(payload.recipients).map(
        (recipient: RecipientData) => recipient.rowId
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

  handleCreateSubmit(_response: ListData) {
    this.fetchItems();
  }

  // async rowActionDelete(compositeId: string): Promise<ModelApiResponse | void> {
  //   const [listId, ruleId] = compositeId.split('-');
  //   return await this.$store.dispatch(
  //     `${list.namespace}/deleteEmailListRuleById`,
  //     {
  //       listId: Number(listId),
  //       ruleId: Number(ruleId),
  //     }
  //   );
  // }

  getRuleData(ruleId: number): ListRuleData | null {
    return this.$store.getters[`${list.namespace}/getRuleById`](ruleId) || null;
  }
}
</script>
