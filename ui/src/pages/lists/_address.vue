<template>
  <div v-if="list && fetchState === appFetchState.Loaded">
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- List Details -->
        <v-card class="mb-6">
          <v-card-title>{{ list.name }}</v-card-title>

          <v-card-subtitle>{{ list.address }}</v-card-subtitle>

          <v-card-text>
            <v-btn color="primary" @click.stop="dialogListEdit = true">
              <v-icon small>mdi-pencil</v-icon> Edit
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Rules Table -->
        <list-rules-table
          :list="list"
          :rules="rules"
          searchable
        ></list-rules-table>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Members Table -->
        <list-members-table :list="list" searchable></list-members-table>
      </v-col>
    </v-row>
    <!-- Dialogs -->
    <list-edit :list="list" :open.sync="dialogListEdit"></list-edit>
  </div>
  <div v-else-if="fetchState === appFetchState.Loading">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <error-display v-else :error="error"></error-display>
</template>

<script lang="ts">
import { ListData } from '@api/models';
import { Component, Vue } from 'vue-property-decorator';
import { AppBreadcrumbOptions } from '~/common/breadcrumb';
import ListEditDialog from '~/components/dialogs/list-edit.vue';
import BaseInputComponent from '~/components/form/base-input.vue';
import ListRulesTable from '~/components/tables/list-rules-table.vue';
import * as list from '~/store/emailList';
import BaseDisplayPage from '../base-detail-page';

@Component({
  components: {
    BaseInputComponent,
    ListEditDialog,
    ListRulesTable,
  },
})
export default class ListDetailPage extends BaseDisplayPage {
  // Getters
  get address(): string {
    return String(this.$route.params.address);
  }

  get list(): ListData | null {
    return this.$store.getters[`${list.namespace}/getEmailListByAddress`](
      this.address
    );
  }

  // Configurables
  breadcrumbParents = [
    {
      to: '/lists',
      label: 'Lists',
    },
  ];
  get breadcrumbLabel(): string | null {
    return this.list ? `${this.list.address}` : null;
  }

  fetchApiStatusMsg = 'Fetching List Data';
  async _fetchApiData() {
    await this.$store.dispatch(
      `${list.namespace}/fetchEmailListByAddress`,
      this.address
    );
  }
  async _fetchDataEntityNotFound() {
    // TODO: use correct commiter
    // this.$store.commit(`${list.namespace}/removeMemberById`, this.id);
  }

  // Additional logic
  dialogListEdit: boolean = false;
}
</script>
