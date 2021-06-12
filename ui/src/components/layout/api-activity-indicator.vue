<template>
  <v-dialog
    v-model="isUpdateApiRequestInProgress"
    hide-overlay
    persistent
    width="300"
  >
    <v-card color="primary">
      <v-card-text>
        Saving data
        <v-progress-linear
          indeterminate
          color="white"
          class="mb-0"
        ></v-progress-linear>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as ui from '~/store/ui';

@Component
export default class ApiActivityIndicator extends Vue {
  get isUpdateApiRequestInProgress(): boolean {
    return this.$store.getters[`${ui.namespace}/isUpdateApiRequestInProgress`];
  }
}
</script>
