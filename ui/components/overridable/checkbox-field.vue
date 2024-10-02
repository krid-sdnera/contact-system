<script setup lang="ts">
const model = defineModel<boolean>();
const overridden = defineModel<boolean>('overridden');

const props = defineProps<{
  label: string;
  mode?: 'create' | 'update';
  hideOverrideCheckbox?: boolean;
}>();
</script>

<template>
  <OverridableFieldContainer
    :overridden="overridden"
    :label="props.label"
    :mode="props.mode"
    :hideOverrideCheckbox="props.hideOverrideCheckbox"
    v-slot="{ disabled }"
  >
    <v-checkbox
      v-model="model"
      :label="props.label"
      :disabled="disabled"
      hide-details
    ></v-checkbox>
  </OverridableFieldContainer>
</template>
