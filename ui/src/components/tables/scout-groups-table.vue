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
        <!-- <scout-group-create
          v-if="allowCreation"
          :scoutgroup="scoutGroup"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></scout-group-create> -->
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
      <v-btn :to="{ path: `/groups/${item.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting Group"
        :message="`delete the group, ${item.name}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  ScoutGroupData,
  ScoutGroups,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
// import ScoutGroupCreateDialog from '~/components/dialogs/scout-group-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as scoutGroup from '~/store/scoutGroup';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    // ScoutGroupCreateDialog,
    DangerConfirmation,
  },
})
export default class ScoutgroupTableComponent extends BaseTable<
  ScoutGroupData,
  number
> {
  name = 'scout-groups-table';
  title = 'Groups';

  get items(): ScoutGroupData[] {
    const itemIdsToDisplay = this.serverItemIdsToDisplay;
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${scoutGroup.namespace}/getScoutGroups`]
      .filter((x: ScoutGroupData) => itemIdsToDisplay.includes(x.id))
      .sort((a: ScoutGroupData, b: ScoutGroupData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'Name', value: 'name' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  async fetchItems() {
    this.loading = true;

    try {
      const payload: ScoutGroups = await this.$store.dispatch(
        `${scoutGroup.namespace}/fetchScoutGroups`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.scoutGroups.map(
        (scoutgroup: ScoutGroupData) => scoutgroup.id
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

  handleCreateSubmit(response: ScoutGroupData) {
    if (response?.id) {
      this.$router.push(`/groups/${response.id}`);
    }
  }

  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return await this.$store.dispatch(
      `${scoutGroup.namespace}/deleteScoutGroupById`,
      {
        scoutgroupId: id,
      }
    );
  }
}
</script>
