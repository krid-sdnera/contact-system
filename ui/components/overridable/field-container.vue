<script setup lang="ts">
const model = defineModel<string | number | Object>();
const overridden = defineModel<boolean>('overridden');

const props = withDefaults(
  defineProps<{
    label: string;
    mode?: 'create' | 'update';
    hideOverrideCheckbox?: boolean;
  }>(),
  {
    hideOverrideCheckbox: false,
    mode: 'update',
  }
);

function copy(d: any) {
  if (['string', 'number', 'boolean', 'undefined'].includes(typeof d)) {
    return d;
  }

  try {
    return JSON.parse(JSON.stringify(d));
  } catch {
    return '';
  }
}

const original = copy(unref(model));

watch(overridden, (newVal) => {
  if (newVal === false) {
    model.value = copy(original);
  }
});

const showCheckbox = computed(() => {
  if (props.hideOverrideCheckbox) {
    return false;
  }

  return props.mode === 'update';
});
const showLeftPadding = computed(() => {
  if (props.mode === 'create') {
    return false;
  }

  return props.hideOverrideCheckbox === true;
});
</script>

<template>
  <v-row>
    <v-col class="d-flex" :class="{ 'pl-13': showLeftPadding }">
      <v-tooltip v-if="showCheckbox" location="bottom">
        <template v-slot:activator="{ props }">
          <v-checkbox
            v-bind="props"
            v-model="overridden"
            hide-details
          ></v-checkbox>
        </template>
        <span v-if="overridden">
          {{ label }} is currently overridden.<br />
          Unchecking will allow updates from Extranet data.
        </span>
        <span v-else-if="!overridden">
          {{ label }} can be updated from Extranet data.<br />
          Checking will hold its current value.
        </span>
        <span v-else>Something went wrong.</span>
      </v-tooltip>

      <slot :disabled="!overridden"></slot>
    </v-col>
  </v-row>
</template>
