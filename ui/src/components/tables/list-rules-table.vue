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
        <list-rule-create
          v-if="allowCreation"
          :open.sync="dialogCreate"
          :list="list"
          :preset-relation="presetRelation"
          :preset-relation-type="presetRelationType"
          @submit="handleCreateSubmit"
        ></list-rule-create>
      </v-toolbar>
    </template>
    <template v-slot:[`item.list`]="{ item }">
      <span>{{ item.listName }}</span>
      <br />
      <nuxt-link nuxt :to="`/lists/${item.listAddress}`">
        {{ item.listAddress }}
      </nuxt-link>
    </template>
    <template v-slot:[`item.relation`]="{ item }">
      <span v-if="item.relationType === 'None'">No relation</span>
      <template v-else>
        <span>{{ item.relationType }}</span>
        <br />
        <nuxt-link
          nuxt
          :to="`/${relationPath(item.relationType)}/${item.relationId}`"
        >
          {{ item.relationName }}
        </nuxt-link>
      </template>
    </template>
    <template v-slot:[`item.useMember`]="{ item }">
      <v-icon v-if="item.useMember" colour="green">mdi-check</v-icon>
      <v-icon v-else colour="red">mdi-close</v-icon>
    </template>
    <template v-slot:[`item.useContact`]="{ item }">
      <v-icon v-if="item.useContact" colour="green">mdi-check</v-icon>
      <v-icon v-else colour="red">mdi-close</v-icon>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <danger-confirmation
        :id="`${item.listId}-${item.id}`"
        :open.sync="dialogRowActionDelete[item.id]"
        title="Deleting List Rule"
        :message="`delete the list rule, ${item.label}`"
        icon="mdi-delete"
        v-on:confirm="handleRowActionDeleteConfirm"
      ></danger-confirmation>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import {
  ContactData,
  ListData,
  ListRuleData,
  ListRules,
  MemberData,
  ModelApiResponse,
  RoleData,
  ScoutGroupData,
  SectionData,
} from '@api/models';
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
export default class ListRuleTableComponent extends BaseTable<ListRuleData> {
  name = 'list-rules-table';
  title = 'List Rules';

  @Prop(Object) readonly list!: ListData;

  @Prop(Object) readonly presetRelation!:
    | ContactData
    | MemberData
    | RoleData
    | SectionData
    | ScoutGroupData
    | undefined;
  @Prop(String) readonly presetRelationType!: string | undefined;

  get items(): ListRuleData[] {
    const itemIdsToDisplay: number[] = this.serverItemIdsToDisplay as number[];
    console.log(itemIdsToDisplay);

    return this.$store.getters[`${list.namespace}/getRules`]
      .filter((x: ListRuleData) => itemIdsToDisplay.includes(x.id))
      .sort((a: ListRuleData, b: ListRuleData) => {
        return itemIdsToDisplay.indexOf(a.id) - itemIdsToDisplay.indexOf(b.id);
      });
  }

  relationPath(relationType: string) {
    const pathMap: Record<string, string> = {
      Contact: 'contacts',
      Member: 'members',
      Role: 'roles',
      Section: 'sections',
      ScoutGroup: 'groups',
    };
    return pathMap[relationType];
  }

  headers = [
    { text: 'Label', value: 'label' },
    { text: 'Comment', value: 'comment' },
    { text: 'List', value: 'list' },
    { text: 'Linked to', value: 'relation' },
    { text: 'Use Member', value: 'useMember' },
    { text: 'Use Contact', value: 'useContact' },
    { text: 'Actions', value: 'actions' },
  ];

  async fetchListRules(): Promise<ListRules> {
    switch (this.presetRelationType) {
      case 'Contact':
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesByContactId`,
          {
            ...this.apiOptions,
            contactId: this.presetRelation.id,
          }
        );
      case 'Member':
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesByMemberId`,
          {
            ...this.apiOptions,
            memberId: this.presetRelation.id,
          }
        );
      case 'Role':
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesByRoleId`,
          {
            ...this.apiOptions,
            roleId: this.presetRelation.id,
          }
        );
      case 'Section':
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesBySectionId`,
          {
            ...this.apiOptions,
            sectionId: this.presetRelation.id,
          }
        );
      case 'ScoutGroup':
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesByScoutGroupId`,
          {
            ...this.apiOptions,
            scoutGroupId: this.presetRelation.id,
          }
        );
      default:
        return this.$store.dispatch(
          `${list.namespace}/fetchListRulesByListId`,
          {
            ...this.apiOptions,
            listId: this.list?.id,
          }
        );
    }
  }

  async fetchItems() {
    this.loading = true;

    try {
      const payload = await this.fetchListRules();
      this.serverItemIdsToDisplay = payload.rules.map(
        (recipient: ListRuleData) => recipient.id
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
    this.fetchItems();
  }

  async rowActionDelete(compositeId: string): Promise<ModelApiResponse | void> {
    const [listId, ruleId] = compositeId.split('-');
    return await this.$store.dispatch(
      `${list.namespace}/deleteEmailListRuleById`,
      {
        listId: Number(listId),
        ruleId: Number(ruleId),
      }
    );
  }
}
</script>
