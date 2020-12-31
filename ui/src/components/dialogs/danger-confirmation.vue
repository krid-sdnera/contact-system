<template>
  <v-dialog v-model="dialog" persistent width="500">
    <template v-slot:activator="{ on, attrs }">
      <v-btn icon color="red" v-bind="attrs" v-on="on">
        <v-icon small>{{ icon }}</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="headline" primary-title>{{ title }}?</v-card-title>
      <v-card-text>
        You are about to
        {{ message }} <br />
        Are you sure you wish to continue?
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="primary"
          text
          :disabled="isAppUpdating || !dialog"
          @click.stop="cancelModal"
        >
          Cancel
        </v-btn>
        <v-btn
          color="warning"
          text
          :disabled="isAppUpdating || !dialog"
          @click.stop="confirmModal"
        >
          Delete
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Prop, PropSync, Emit } from 'vue-property-decorator';

import * as ui from '~/store/ui';

@Component
export default class DangerConfirmation extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop()
  readonly id!: any;

  @Prop()
  readonly title!: string;

  @Prop()
  readonly message!: string;

  @Prop()
  readonly icon!: string;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Emit('cancel')
  cancelModal() {
    this.dialog = false;
    return this.id;
  }

  @Emit('confirm')
  confirmModal() {
    this.dialog = false;
    return this.id;
  }
}
</script>
