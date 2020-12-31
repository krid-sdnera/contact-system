<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="newScoutGroup !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ scoutGroup.name }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- ScoutGroup Name -->
            <base-input
              :original="scoutGroup.name"
              :field.sync="newScoutGroup.name"
              label="ScoutGroup Name"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- External ID -->
            <base-input
              :original="scoutGroup.externalId"
              :field.sync="newScoutGroup.externalId"
              label="External ID"
              field-type="text"
            ></base-input>
          </v-row>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="closeEditScoutGroupModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditScoutGroupModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditScoutGroupModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { ScoutGroupData, ScoutGroupInput } from '@api/models';

import * as scoutGroup from '~/store/scoutGroup';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/alert';

@Component
export default class DialogScoutGroupEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly scoutGroup!: ScoutGroupData;

  newScoutGroup: ScoutGroupInput | null = null;
  originalChanged: boolean = false;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewScoutGroupData();
    }
  }

  @Watch('scoutGroup', { immediate: true, deep: true })
  handleScoutGroupDataChanged(scoutGroup: ScoutGroupData) {
    if (!scoutGroup) {
      // show snack error bar
      return;
    }
    if (this.newScoutGroup !== null) {
      // show warning that the underlying scoutGroup data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }
    this.buildNewScoutGroupData();
  }

  buildNewScoutGroupData() {
    this.originalChanged = false;
    this.newScoutGroup = Object.assign({}, {
      name: this.scoutGroup.name,
      externalId: this.scoutGroup.externalId,
    } as ScoutGroupInput);
  }

  closeEditScoutGroupModal() {
    this.dialog = false;
  }

  async saveEditScoutGroupModal() {
    try {
      await this.$store.dispatch(
        `${scoutGroup.namespace}/updateScoutGroupById`,
        {
          scoutGroupId: this.scoutGroup.id,
          scoutGroupInput: this.newScoutGroup,
        }
      );

      this.dialog = false;
      this.newScoutGroup = null;
      this.originalChanged = false;
      createAlert(this.$store, {
        message: 'Scout Group created.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to create Scout Group.',
        type: 'error',
      });
    }
  }
}
</script>
