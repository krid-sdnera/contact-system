<template>
  <div class="base-info pt-2">
    <div class="text--secondary">
      <slot name="label"></slot>
      {{ label }}
    </div>
    <div
      class="text--primary d-flex justify-space-between"
      style="width: 100%;"
    >
      <a
        v-if="isExternalLink"
        :href="to"
        class="text--primary"
        target="__blank"
      >
        <slot></slot>
        <v-icon v-if="isGoogleMapsLink" x-small style="vertical-align: top;">
          mdi-google-maps
        </v-icon>
      </a>
      <nuxt-link v-else-if="to" :to="to" class="text--primary">
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
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseInfoComponent extends Vue {
  @Prop(String)
  readonly label!: string;

  @Prop()
  to: string | { path?: string; hash?: string } | undefined;

  @Prop({ type: Boolean, default: false })
  overridden!: boolean;

  get isHashed(): boolean {
    if (typeof this.to === 'string') {
      return false;
    } else {
      return !!this.to?.hash;
    }
  }

  get isExternalLink(): boolean {
    if (typeof this.to === 'string') {
      return this.to.startsWith('https://');
    }
    return false;
  }

  get isGoogleMapsLink(): boolean {
    if (typeof this.to === 'string') {
      return this.to.startsWith('https://google.com.au/maps');
    }
    return false;
  }
}
</script>

<style lang="css" scoped>
div.base-info a {
  text-decoration: none;
}
div.base-info a:hover {
  text-decoration: underline;
}
</style>
