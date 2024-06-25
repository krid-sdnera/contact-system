<script setup lang="ts">
const model = defineModel<boolean>();
const overridden = defineModel<boolean>('overridden');

const props = withDefaults(
  defineProps<{
    label: string;
    hideOverrideCheckbox?: boolean;
  }>(),
  {
    hideOverrideCheckbox: false,
  }
);

const original = unref(model);

watch(overridden, (newVal) => {
  if (newVal === false) {
    model.value = original || false;
  }
});
</script>

<template>
  <v-row class="flex-nowrap" :class="{ 'pl-10': props.hideOverrideCheckbox }">
    <v-tooltip v-if="!props.hideOverrideCheckbox" location="bottom">
      <template v-slot:activator="{ props }">
        <v-checkbox v-bind="props" v-model="overridden"></v-checkbox>
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

    <v-checkbox
      v-model="model"
      :label="label"
      :disabled="!overridden"
    ></v-checkbox>
  </v-row>
</template>
