<template>
  <span>
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
    <span>
      <span v-for="status in apiStatus" v-bind:key="status">
        {{ status }}
      </span>
    </span>
    <span class="ml-2">
      <v-icon v-if="dataRefreshRequest === false" @click="requestDataRefresh()">
        mdi-refresh
      </v-icon>
      <v-progress-circular v-else size="24" indeterminate></v-progress-circular>
    </span>
  </span>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import * as ui from '~/store/ui';

@Component
export default class ApiActivityIndicator extends Vue {
  get isUpdateApiRequestInProgress(): boolean {
    return this.$store.getters[`${ui.namespace}/isUpdateApiRequestInProgress`];
  }
  get apiStatus(): string[] {
    return this.$store.getters[`${ui.namespace}/apiStatus`];
  }

  get dataRefreshRequest(): string[] {
    return this.$store.getters[`${ui.namespace}/dataRefreshRequest`];
  }
  requestDataRefresh() {
    this.$store.commit(`${ui.namespace}/requestDataRefresh`);
  }
}
</script>

<style lang="css" scoped>
@keyframes rotating {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.data-refresh-request.v-icon {
  animation: rotating 1s linear infinite;
}
</style>
