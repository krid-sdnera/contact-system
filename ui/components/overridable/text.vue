<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    label?: string;
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

const isExternalLink = computed(() => {
  if (typeof props.to === 'string') {
    return props.to.startsWith('https://');
  }
  return false;
});

const isGoogleMapsLink = computed(() => {
  if (typeof props.to === 'string') {
    return props.to.startsWith('https://google.com.au/maps');
  }
  return false;
});
</script>

<template>
  <div class="base-info pt-2">
    <div class="text-body-1">
      <slot name="label"></slot>
      {{ props.label }}
    </div>
    <div class="d-flex justify-space-between" style="width: 100%">
      <a v-if="isExternalLink" :href="props.to" class="" target="__blank">
        <slot></slot>
        <v-icon
          v-if="isGoogleMapsLink"
          size="x-small"
          style="vertical-align: top"
        >
          mdi-google-maps
        </v-icon>
      </a>
      <NuxtLink v-else-if="props.to" :to="props.to">
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
  </div>
</template>

<style lang="css" scoped>
div.base-info a {
  text-decoration: none;
}
div.base-info a:hover {
  text-decoration: underline;
}
</style>
