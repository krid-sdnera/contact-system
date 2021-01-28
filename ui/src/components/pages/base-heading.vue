<template>
  <v-card-title class="base-heading flex-column align-start">
    <div class="text--secondary subtitle-1">{{ label }}</div>
    <div
      class="text--primary d-flex justify-space-between"
      style="width: 100%;"
    >
      <nuxt-link v-if="to" :to="to" class="text--primary">
        <slot></slot>
        <v-icon v-if="isHashed" x-small style="vertical-align: top;">
          mdi-share
        </v-icon>
        <v-icon v-else x-small style="vertical-align: top;">
          mdi-open-in-new
        </v-icon>
      </nuxt-link>
      <div v-else><slot></slot></div>

      <v-icon v-if="overridden">mdi-backup-restore</v-icon>
    </div>
  </v-card-title>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component
export default class BaseHeadingComponent extends Vue {
  @Prop({ required: true })
  label!: string;

  @Prop()
  to: string | undefined;

  @Prop({ type: Boolean, default: false })
  overridden!: boolean;

  get isHashed(): boolean {
    if (typeof this.to === 'string') {
      return false;
    } else {
      return !!this.to?.hash;
    }
  }
}
</script>

<style lang="css" scoped>
div.base-heading a {
  text-decoration: none;
}
div.base-heading a:hover {
  text-decoration: underline;
}
</style>
