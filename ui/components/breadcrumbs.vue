<script setup lang="ts">
const { breadcrumbs } = useBreadcrumbs();
</script>

<template>
  <template v-for="(breadcrumb, index) in breadcrumbs" :key="breadcrumb.to">
    <v-btn
      :to="breadcrumb.to"
      :readonly="breadcrumbs.length - 1 === index"
      class="breadcrumb"
    >
      {{ breadcrumb.label }}
    </v-btn>
    <v-divider
      class="breadcrumb-separator mx-1 align-self-center border-opacity-75"
      length="24"
      thickness="2"
      vertical
      v-if="breadcrumbs.length - 1 !== index"
    >
    </v-divider>
  </template>
</template>

<style>
.breadcrumb.v-btn--active > .v-btn__overlay {
  opacity: 0 !important;
}

.breadcrumb-separator {
  transform: rotate(25deg);
}
</style>
