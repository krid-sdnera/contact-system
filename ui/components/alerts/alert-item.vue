<template>
  <v-alert dense :type="alert.type">{{ alert.message }}</v-alert>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

import { AppAlert } from '~/common/alert';

import * as ui from '~/store/ui';

@Component
export default class AlertItem extends Vue {
  @Prop(Object)
  readonly alert!: AppAlert;

  mounted() {
    setTimeout(() => {
      this.$store.dispatch(`${ui.namespace}/expireAlert`, alert);
    }, 5000);
  }
}
</script>
