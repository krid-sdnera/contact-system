<script setup lang="ts">
const model = defineModel<string | number>();
const overridden = defineModel<boolean>('overridden');

const props = defineProps<{
  label: string;
  hideOverrideCheckbox?: boolean;
}>();
</script>

<template>
  <OverridableFieldContainer
    v-model="model"
    v-model:overridden="overridden"
    :label="props.label"
    :hideOverrideCheckbox="props.hideOverrideCheckbox"
    v-slot="{ disabled }"
  >
    <v-text-field
      v-model="model"
      :label="props.label"
      :disabled="disabled"
      hide-details
    ></v-text-field>
  </OverridableFieldContainer>
</template>
