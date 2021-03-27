<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-2">
        New Email List
      </v-btn>
    </template>
    <v-card v-if="newList !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">
          Create new List
        </span>
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
          @click="closeCreateListModal"
        >
          Cancel
        </v-btn>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveCreateListModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { ListInput } from '@api/models';
import { Component, Emit, PropSync, Vue, Watch } from 'vue-property-decorator';
import { createAlert } from '~/common/alert';
import * as list from '~/store/emailList';
import * as ui from '~/store/ui';

@Component
export default class DialogListCreateComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  newList: ListInput | null = null;

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

  buildNewListData() {
    this.newList = Object.assign({}, {
      name: '',
      address: '',
    } as ListInput);
  }

  closeCreateListModal() {
    this.dialog = false;
  }

  @Emit('submit')
  async saveCreateListModal() {
    try {
      console.log(this.newList);
      const listResponse = await this.$store.dispatch(
        `${list.namespace}/createEmailList`,
        { listInput: this.newList }
      );

      this.dialog = false;
      this.newList = null;
      createAlert(this.$store, {
        message: 'List created.',
        type: 'success',
      });

      return listResponse;
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to create List.',
        type: 'error',
      });
    }
  }
}
</script>
