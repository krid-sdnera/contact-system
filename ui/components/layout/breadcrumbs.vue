<template>
  <ol class="breadcrumb-container pl-0">
    <li
      class="d-inline"
      v-for="(breadcrumb, i) in breadcrumbs"
      v-bind:key="breadcrumb.label"
    >
      <nuxt-link
        v-if="breadcrumb.to !== null"
        :to="breadcrumb.to"
        class="text--primary"
        >{{ breadcrumb.label }}</nuxt-link
      >
      <span v-else class="text--secondary">{{ breadcrumb.label }}</span>
      <template v-if="i !== breadcrumbs.length - 1"> / </template>
    </li>
  </ol>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { AppBreadcrumb } from '~/common/breadcrumb';

import * as ui from '~/store/ui';

@Component
export default class Breadcrumbs extends Vue {
  get breadcrumbs(): AppBreadcrumb[] {
    return this.$store.getters[`${ui.namespace}/breadcrumbs`];
  }
}
</script>

<style lang="css" scoped>
ol.breadcrumb-container {
  list-style-type: none;
}
ol.breadcrumb-container li a {
  text-decoration: none;
}
ol.breadcrumb-container li a:hover {
  text-decoration: underline;
}
</style>
