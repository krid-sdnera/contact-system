<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="newList !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">Editing {{ list.firstname }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Name -->
            <base-input
              :field.sync="newList.name"
              label="Name"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Address -->
            <base-input
              :field.sync="newList.address"
              label="Address"
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
          @click="closeEditListModal"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="saveEditListModal"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveEditListModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';
import { ListData, ListInput } from '@api/models';

import * as list from '~/store/emailList';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/helper-factories';
@Component
export default class DialogListEditComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object)
  readonly list!: ListData;

  newList: ListInput | null = null;
  originalChanged: boolean = false;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewListData();
    }
  }

  @Watch('list', { immediate: true, deep: true })
  handleListDataUpdate(list: ListData) {
    if (!list) {
      // show snack error bar
      return;
    }
    if (this.newList !== null) {
      // show warning that the underlying list data has updated.
      // do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.buildNewListData();
  }

  buildNewListData() {
    this.originalChanged = false;
    this.newList = Object.assign({}, {
      name: this.list.name,
      address: this.list.address,
    } as ListInput);
  }

  closeEditListModal() {
    this.dialog = false;
  }

  async saveEditListModal() {
    try {
      await this.$store.dispatch(`${list.namespace}/updateEmailListById`, {
        listId: this.list.id,
        listInput: this.newList,
      });

      this.$router.push(`/lists/${this.newList?.address}`);

      this.dialog = false;
      this.newList = null;
      this.originalChanged = false;
      createAlert(this.$store, {
        message: 'List updated.',
        type: 'success',
      });
    } catch (e) {
      console.error(e);
      createAlert(this.$store, {
        message: 'Failed to update List.',
        type: 'error',
      });
    }
  }
}
</script>
