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
        <list-create
          v-if="allowCreation"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></list-create>
      </v-toolbar>
    </template>
    <template v-slot:[`item.state`]="{ item }">
      <v-chip :color="getStateColor(item.state)">
        {{ item.state }}
      </v-chip>
    </template>
    <template v-slot:[`item.managementState`]="{ item }">
      <v-chip :color="getMStateColor(item.managementState)">
        {{ item.managementState }}
      </v-chip>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn :to="{ path: `/lists/${item.address}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting List"
        :message="`delete the list, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';
import { ListData, Lists, MemberData, ModelApiResponse } from '@api/models';
import ListCreateDialog from '~/components/dialogs/list-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as list from '~/store/emailList';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    ListCreateDialog,
    DangerConfirmation,
  },
})
export default class ListTableComponent extends BaseTable<ListData, number> {
  name = 'lists-table';
  title = 'Lists';

  // TODO
  @Prop(Object) readonly member: MemberData[] | undefined;

  get items(): ListData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;

    return this.$store.getters[`${list.namespace}/getEmailLists`]
      .filter((x: ListData) => itemIdsToDisplay.includes(x.id))
      .sort((a: ListData, b: ListData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'Name', value: 'name' },
    { text: 'Address', value: 'address' },
    { text: 'Actions', value: 'actions' },
  ];

  async fetchItems() {
    this.loading = true;

    try {
      const payload: Lists = await this.$store.dispatch(
        `${list.namespace}/fetchLists`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.lists.map(
        (list: ListData) => list.id
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

  handleCreateSubmit(response: ListData) {
    if (response?.address) {
      this.$router.push(`/lists/${response.address}`);
    }
  }

  // async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
  //   return await this.$store.dispatch(`${list.namespace}/deleteListById`, {
  //     listId: id,
  //   });
  // }
}
</script>
