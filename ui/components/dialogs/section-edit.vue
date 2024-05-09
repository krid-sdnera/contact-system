<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="newSection !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ section.name }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Section Name -->
            <base-input
              :original="section.name"
              :field.sync="newSection.name"
              label="Section Name"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- External ID -->
            <base-input
              :original="section.externalId"
              :field.sync="newSection.externalId"
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
          @click="closeEditSectionModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditSectionModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditSectionModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { SectionData, SectionInput } from '@api/models';

import * as section from '~/store/section';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/helper-factories';
@Component
export default class DialogSectionEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly section!: SectionData;

  newSection: SectionInput | null = null;
  originalChanged: boolean = false;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewSectionData();
    }
  }

  @Watch('section', { immediate: true, deep: true })
  handleSectionataChanged(section: SectionData) {
    if (!section) {
      // show snack error bar
      return;
    }
    if (this.newSection !== null) {
      // show warning that the underlying section data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.buildNewSectionData();
  }

  buildNewSectionData() {
    this.originalChanged = false;
    this.newSection = Object.assign({}, {
      name: this.section.name,
      externalId: this.section.externalId,
      scoutGroupId: this.section.scoutGroup.id,
    } as SectionInput);
  }

  closeEditSectionModal() {
    this.dialog = false;
  }

  async saveEditSectionModal() {
    try {
      await this.$store.dispatch(`${section.namespace}/updateSectionById`, {
        sectionId: this.section.id,
        sectionInput: this.newSection,
      });

      this.dialog = false;
      this.newSection = null;
      this.originalChanged = false;
      createAlert(this.$store, {
        message: 'Section created.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to create Section.',
        type: 'error',
      });
    }
  }
}
</script>
