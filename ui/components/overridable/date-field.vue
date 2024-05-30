<script setup lang="ts">
import { useDate } from 'vuetify';

const model = defineModel<string>();
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

const original = JSON.parse(JSON.stringify(unref(model)));

watch(overridden, (newVal) => {
  if (newVal === false) {
    model.value = JSON.parse(JSON.stringify(original));
  }
});

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
  model.value = adaptor.toISO(d);
}
</script>

<template>
  <v-row
    class="flex-nowrap pb-2"
    :class="{ 'pl-10': props.hideOverrideCheckbox }"
  >
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

    <v-date-input
      v-model="datePickerValue"
      :disabled="!overridden"
      show-adjacent-months
      persistent-placeholder
      prepend-icon=""
      prepend-inner-icon="$calendar"
      hint="Date is in mm/dd/yyyy"
      persistent-hint
    ></v-date-input>
  </v-row>
</template>
