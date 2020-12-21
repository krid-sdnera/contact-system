<template>
  <v-data-table
    :headers="headers"
    :items="sections"
    :options.sync="options"
    :server-items-length="totalSections"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Sections</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-btn color="primary" class="mb-2" @click="openCreateSectionModal">
          New Local Section
        </v-btn>
        <!-- <section-create
          :open.sync="dialogSectionCreate"
          @submit="handleSectionCreateSubmit"
        ></section-create> -->
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn icon nuxt :to="{ path: `/sections/${item.id}` }">
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
import { SectionData, Sections } from '@api/models';
import * as section from '~/store/section';

@Component
export default class SectionsListPage extends Vue {
  totalSections = 5;
  error = false;
  loading = true;
  options: {
    sortBy: string[];
    sortDesc: string[];
    page: number;
    itemsPerPage: number;
  } = {
    sortBy: [],
    sortDesc: [],
    page: 1,
    itemsPerPage: 10,
  };
  sectionIdsToDisplay: number[] = [];
  search: string = '';

  headers = [
    { text: 'Name', value: 'name' },
    { text: 'Actions', value: 'actions', sortable: false },
  ];

  get apiOptions() {
    let sort = '';
    if (this.options.sortBy.length && this.options.sortDesc.length) {
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
    this.options.page = 1;
    this.fetchSectionsWithNewOptions();
  }

  @Watch('options', { deep: true })
  onOptionsChange() {
    this.fetchSectionsWithNewOptions();
  }

  get sections(): SectionData[] {
    return this.$store.getters[`${section.namespace}/getSections`]
      .filter((section: SectionData) =>
        this.sectionIdsToDisplay.includes(section.id)
      )
      .sort((a: SectionData, b: SectionData) => {
        return (
          this.sectionIdsToDisplay.indexOf(a.id) -
          this.sectionIdsToDisplay.indexOf(b.id)
        );
      });
  }

  async mounted() {}

  async fetchSectionsWithNewOptions(): Promise<void> {
    this.loading = true;
    try {
      const payload: Sections = await this.$store.dispatch(
        `${section.namespace}/fetchSections`,
        this.apiOptions
      );

      this.sectionIdsToDisplay = payload.sections.map(
        (section: SectionData) => section.id
      );

      this.totalSections = payload.totalItems;
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

  dialogSectionCreate: boolean = false;

  openCreateSectionModal() {
    this.dialogSectionCreate = true;
  }

  closeCreateSectionModal() {
    this.dialogSectionCreate = false;
  }

  handleSectionCreateSubmit(response: SectionData) {
    if (response?.id) {
      this.$router.push(`/sections/${response.id}`);
    }
  }
}
</script>
