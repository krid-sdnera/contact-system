<script setup lang="ts">
import type { AddressData } from '~/server/types/address';

const model = defineModel<AddressData>();
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

    <v-col v-if="model">
      <v-row>
        <v-col cols="6" class="py-0 pl-0">
          <!-- Address Line 1 -->
          <v-text-field
            v-model="model.street1"
            label="Street Line 1"
            :disabled="!overridden"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="py-0 pr-0">
          <!-- Address Line 2 -->
          <v-text-field
            v-model="model.street2"
            label="Street Line 2"
            :disabled="!overridden"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4" class="py-0 pl-0">
          <!-- Address City -->
          <v-text-field
            v-model="model.city"
            label="City"
            :disabled="!overridden"
          ></v-text-field>
        </v-col>
        <v-col cols="4" class="py-0">
          <!-- Address State -->
          <v-text-field
            v-model="model.state"
            label="State"
            :disabled="!overridden"
          ></v-text-field>
        </v-col>
        <v-col cols="4" class="py-0 pr-0">
          <!-- Address Postcode -->
          <v-text-field
            v-model="model.postcode"
            label="Postcode"
            :disabled="!overridden"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>
