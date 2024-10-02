<script setup lang="ts">
import { useDate } from 'vuetify';

const model = defineModel<string>();
const overridden = defineModel<boolean>('overridden');

const props = defineProps<{
  label: string;
  hideOverrideCheckbox?: boolean;
}>();

const datePickerValue = ref<Date>();

const adaptor = useDate();

watch(model, transformInput, { immediate: true });
watch(datePickerValue, transformOutput, { immediate: true });

function transformInput(d?: string) {
  if (!d) {
    return;
  }
  datePickerValue.value = adaptor.parseISO(d) as Date;
}
function transformOutput(d?: Date) {
  if (!d) {
    return;
  }
  model.value = adaptor.toISO(d);
}
</script>

<template>
  <OverridableFieldContainer
    v-model="model"
    v-model:overridden="overridden"
    :label="props.label"
    :hideOverrideCheckbox="props.hideOverrideCheckbox"
    v-slot="{ disabled }"
  >
    <v-date-input
      v-model="datePickerValue"
      :disabled="disabled"
      show-adjacent-months
      persistent-placeholder
      prepend-icon=""
      prepend-inner-icon="$calendar"
      hint="Date is in mm/dd/yyyy"
      persistent-hint
    ></v-date-input>
  </OverridableFieldContainer>
</template>
