<script setup lang="ts">
import { useDate } from 'vuetify';

const modelState = defineModel<'enabled' | 'disabled'>('state');
const modelExpiry = defineModel<string | undefined | null>('expiry');

const props = defineProps<{
  management?: 'managed' | 'unmanaged';
}>();

const datePickerValue = ref<Date>();

const adaptor = useDate();

watch(modelExpiry, transformInput, { immediate: true });
watch(datePickerValue, transformOutput, { immediate: true });

function transformInput(d?: string | undefined | null) {
  if (datePickerValue.value && d === adaptor.toISO(datePickerValue.value)) {
    console.log('d and datePickerValue are the same');
    return;
  }
  if (d) {
    datePickerValue.value = adaptor.parseISO(d) as Date;
    return;
  }
  datePickerValue.value = undefined;
}
function transformOutput(d?: Date) {
  if (d && modelExpiry.value === adaptor.toISO(d)) {
    console.log('modelExpiry and d are the same');
    return;
  }
  if (d) {
    modelExpiry.value = adaptor.toISO(d);
    return;
  }
  modelExpiry.value = null;
}

function clearExpiry() {
  datePickerValue.value = undefined;
  modelExpiry.value = undefined;
}
</script>

<template>
  <v-row>
    <v-col cols="12" :md="props.management === 'managed' ? 6 : 12">
      <DataFormFieldset
        legend="State"
        variant="outlined"
        :color="modelState === 'enabled' ? 'light-green-lighten-4' : ''"
      >
        <v-switch
          v-model="modelState"
          :label="`State: ${$filters.capitalize(modelState)}`"
          :color="modelState === 'enabled' ? 'green-darken-2' : ''"
          false-value="disabled"
          true-value="enabled"
        ></v-switch>

        <v-alert v-if="modelState === 'enabled'">
          Shown in the UI and email recipient lists.
        </v-alert>
        <v-alert v-else>
          Hidden from the UI and email recipient lists.
        </v-alert>
      </DataFormFieldset>
    </v-col>

    <v-col v-if="props.management === 'managed'" cols="12" md="6">
      <DataFormFieldset
        legend="Extranet"
        variant="outlined"
        color="light-green-lighten-4"
      >
        <v-alert color="light-green-lighten-4">
          This record tracks updates from Extranet.
        </v-alert>
      </DataFormFieldset>
    </v-col>
    <v-col v-if="props.management === 'unmanaged'">
      <DataFormFieldset legend="Extranet" variant="outlined">
        <v-alert class="mb-2">
          There is no upstream record in Extranet.<br />
          <br />
          Set an expiry to automatically remove this record or leave empty to
          retain record locally. record.
        </v-alert>

        <!-- Expiry -->
        <v-date-input
          v-model="datePickerValue"
          show-adjacent-months
          persistent-placeholder
          prepend-icon=""
          prepend-inner-icon="$calendar"
          hint="Date is in mm/dd/yyyy"
          persistent-hint
          clearable
          @click:clear="clearExpiry"
        ></v-date-input>

        <v-alert v-if="modelExpiry" class="mt-2" color="red-lighten-2">
          Record should be removed
          {{ $filters.duration(modelExpiry, { sentanceFix: true }) }}
        </v-alert>
      </DataFormFieldset>
    </v-col>
  </v-row>
</template>
