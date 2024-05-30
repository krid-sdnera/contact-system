<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    label: string;
    to?: string | { path: string } | { hash: string };
    overridden?: boolean;
  }>(),
  {
    overridden: false,
  }
);

const isHashed = computed<boolean>(() => {
  if (typeof props.to === 'string') {
    return false;
  } else if (props.to && 'hash' in props.to) {
    return !!props.to.hash;
  } else {
    return false;
  }
});
const linkIcon = computed<string>(() => {
  return isHashed.value ? 'mdi-share' : 'mdi-open-in-new';
});
</script>

<template>
  <v-card-title class="base-heading">
    <div class="text-subtitle-1">{{ props.label }}</div>
    <div class="d-flex justify-space-between" style="width: 100%">
      <NuxtLink v-if="props.to" :to="props.to">
        <slot></slot>
        <v-icon
          :icon="linkIcon"
          size="x-small"
          style="vertical-align: top"
        ></v-icon>
      </NuxtLink>
      <div v-else>
        <slot></slot>
      </div>

      <v-icon v-if="props.overridden">mdi-backup-restore</v-icon>
    </div>
  </v-card-title>
</template>

<style lang="css" scoped>
div.base-heading a {
  text-decoration: none;
}
div.base-heading a:hover {
  text-decoration: underline;
}
</style>
