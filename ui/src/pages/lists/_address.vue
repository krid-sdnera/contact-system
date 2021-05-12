<template>
  <div v-if="list">
    <v-container>
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
    </v-container>
    <!-- Dialogs -->
    <list-edit :list="list" :open.sync="dialogListEdit"></list-edit>
  </div>
  <v-container v-else-if="loading">
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
  </v-container>
  <div v-else-if="error">Error loading list details</div>
  <div v-else>List not found!</div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { ListData, ListRuleData } from '@api/models';
import BaseInputComponent from '~/components/form/base-input.vue';
import ListEditDialog from '~/components/dialogs/list-edit.vue';
import ListRulesTable from '~/components/tables/list-rules-table.vue';

import * as list from '~/store/emailList';
import * as ui from '~/store/ui';

@Component({
  components: {
    BaseInputComponent,
    ListEditDialog,
    ListRulesTable,
  },
})
export default class ListDetailPage extends Vue {
  get address(): string {
    return String(this.$route.params.address);
  }

  get list(): ListData | null {
    return this.$store.getters[`${list.namespace}/getEmailListByAddress`](
      this.address
    );
  }

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  error = false;
  loading = true;

  unwatchListProp: () => void = () => {};
  async mounted() {
    try {
      await this.$store.dispatch(
        `${list.namespace}/fetchEmailListByAddress`,
        this.address
      );
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  dialogListEdit: boolean = false;
}
</script>
