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
        <!-- <section-create
          v-if="allowCreation"
          :section="section"
          :open.sync="dialogCreate"
          @submit="handleCreateSubmit"
        ></section-create> -->
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
      <v-btn :to="{ path: `/sections/${item.id}` }" color="primary" icon nuxt>
        <v-icon small>mdi-eye</v-icon>
      </v-btn>

      <danger-confirmation
        :id="item.id"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting Section"
        :message="`delete the section, ${item.firstname}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import {
  Sections,
  ModelApiResponse,
  SectionData,
  SectionInput,
} from '@api/models';
// import SectionCreateDialog from '~/components/dialogs/section-create.vue';
import DangerConfirmation from '~/components/dialogs/danger-confirmation.vue';

import * as section from '~/store/section';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';
import BaseTable from '~/components/tables/base-table';

@Component({
  components: {
    // SectionCreateDialog,
    DangerConfirmation,
  },
})
export default class SectionTableComponent extends BaseTable<SectionData> {
  name = 'sections-table';
  title = 'Sections';
  @Prop(Array) readonly sections!: SectionData[] | undefined;

  get items(): SectionData[] {
    if (this.sections) {
      this.totalItems = this.sections?.length || 0;

      // @TODO: potentially apply in browser filter if sections are supplied.
      return this.sections || [];
    }
    const itemIdsToDisplay: number[] = this.serverItemIdsToDisplay as number[];
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${section.namespace}/getSections`]
      .filter((x: SectionData) => itemIdsToDisplay.includes(x.id))
      .sort((a: SectionData, b: SectionData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  headers = [
    { text: 'Name', value: 'name' },
    { text: 'Group', value: 'scoutGroup.name' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  async fetchItems() {
    if (this.sections) {
      this.totalItems = this.sections.length;
      return;
    }
    this.loading = true;

    try {
      const payload: Sections = await this.$store.dispatch(
        `${section.namespace}/fetchSections`,
        this.apiOptions
      );

      this.serverItemIdsToDisplay = payload.sections.map(
        (section: SectionData) => section.id
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

  handleCreateSubmit(response: SectionData) {
    if (response?.id) {
      this.$router.push(`/sections/${response.id}`);
    }
  }

  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return await this.$store.dispatch(
      `${section.namespace}/deleteSectionById`,
      {
        sectionId: id,
      }
    );
  }
}
</script>
