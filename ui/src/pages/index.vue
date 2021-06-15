<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title class="headline">
            The Contact system
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item to="/members" nuxt>
                <v-list-item-icon>
                  <v-icon color="green">mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  View current members
                </v-list-item-content>
              </v-list-item>
              <v-list-item to="/members/invites" nuxt>
                <v-list-item-icon>
                  <v-icon color="green">mdi-account-multiple-plus</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  View invited members (TODO)
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card-text>
          <v-card-actions> </v-card-actions>
        </v-card>
      </v-col>
      <v-col>
        <v-card>
          <v-card-title class="headline">
            Quick Access
          </v-card-title>
          <v-card-text>
            <v-treeview :items="exportTreeItems" open-on-click>
              <template v-slot:append="{ item }">
                <member-export
                  v-if="!item.children"
                  :open.sync="item.dialogExport"
                  :api-options="{}"
                  :preset-member-fields="[
                    'firstname',
                    'lastname',
                    'membershipNumber',
                    'age',
                  ]"
                  :preset-contact-fields="[
                    'firstname',
                    'lastname',
                    'phoneMobile',
                  ]"
                  :preset-section="item.section"
                  :btn-label="`Export members`"
                ></member-export>
                <v-btn
                  :to="`/${item.scoutGroup ? 'groups' : 'sections'}/${item.id}`"
                  color="primary"
                  icon
                  nuxt
                >
                  <v-icon>mdi-eye</v-icon>
                </v-btn>
              </template>
            </v-treeview>
          </v-card-text>
          <v-card-actions> </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { ScoutGroupData, SectionData } from '@api/models';
import { Component, Vue, Watch } from 'vue-property-decorator';
import {
  AppBreadcrumbOptions,
  setBreadcrumbs,
} from '~/common/helper-factories';
import MemberExportDialog from '~/components/export/member-export.vue';
import * as scoutGroup from '~/store/scoutGroup';
import * as section from '~/store/section';

@Component({
  components: {
    MemberExportDialog,
  },
})
export default class HomePage extends Vue {
  get breadcrumbs(): AppBreadcrumbOptions[] {
    return [{ to: null, label: 'Dashboard' }];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }

  dialogExport: boolean = false;
  get sections() {
    return this.$store.getters[`${section.namespace}/getSections`];
  }
  get sectionsInScoutGroup() {
    return (scoutGroupId: number) => {
      return this.$store.getters[
        `${section.namespace}/getSectionsByScoutGroupId`
      ](scoutGroupId);
    };
  }
  get scoutGroups() {
    return this.$store.getters[`${scoutGroup.namespace}/getScoutGroups`];
  }

  exportTreeItems = [];

  async mounted() {
    await Promise.all([
      this.$store.dispatch(`${section.namespace}/fetchAllSections`, {}),
      this.$store.dispatch(`${scoutGroup.namespace}/fetchAllScoutGroups`, {}),
    ]);
    this.exportTreeItems = this.scoutGroups.map(
      (scoutGroup: ScoutGroupData) => ({
        id: scoutGroup.id,
        name: scoutGroup.name,
        scoutGroup: scoutGroup,
        children: this.sectionsInScoutGroup(scoutGroup.id).map(
          (section: SectionData) => ({
            id: section.id,
            name: section.name,
            section: section,
            dialogExport: false,
          })
        ),
      })
    );
  }
}
</script>
