<template>
  <div class="alert-container">
    <alert-item
      v-for="alert in alerts"
      v-bind:key="alert.uniq"
      :alert="alert"
    ></alert-item>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { AppAlert } from '~/common/alert';
import AlertItem from '~/components/alerts/alert-item.vue';

import * as ui from '~/store/ui';

@Component({
  components: {
    AlertItem,
  },
})
export default class Alerts extends Vue {
  get alerts(): AppAlert {
    return this.$store.getters[`${ui.namespace}/alerts`];
  }
}
</script>

<style lang="css" scoped>
.alert-container {
  position: fixed;
  bottom: 0px;
  right: 16px;
  z-index: 999;
}
</style>
