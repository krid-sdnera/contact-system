<script setup lang="ts">
import type { AddressData } from '~/server/types/address';

const model = defineModel<AddressData>();
const overridden = defineModel<boolean>('overridden');

const props = defineProps<{
  label: string;
  mode?: 'create' | 'update';
  hideOverrideCheckbox?: boolean;
}>();
</script>

<template>
  <OverridableFieldContainer
    v-model="model"
    v-model:overridden="overridden"
    :label="props.label"
    :mode="props.mode"
    :hideOverrideCheckbox="props.hideOverrideCheckbox"
    v-slot="{ disabled }"
  >
    <v-col v-if="model">
      <v-row>
        <v-col cols="6" class="py-0 pl-0">
          <!-- Address Line 1 -->
          <v-text-field
            v-model="model.street1"
            label="Street Line 1"
            :disabled="disabled"
          ></v-text-field>
        </v-col>
        <v-col cols="6" class="py-0 pr-0">
          <!-- Address Line 2 -->
          <v-text-field
            v-model="model.street2"
            label="Street Line 2"
            :disabled="disabled"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4" class="py-0 pl-0">
          <!-- Address City -->
          <v-text-field
            v-model="model.city"
            label="City"
            :disabled="disabled"
          ></v-text-field>
        </v-col>
        <v-col cols="4" class="py-0">
          <!-- Address State -->
          <v-text-field
            v-model="model.state"
            label="State"
            :disabled="disabled"
          ></v-text-field>
        </v-col>
        <v-col cols="4" class="py-0 pr-0">
          <!-- Address Postcode -->
          <v-text-field
            v-model="model.postcode"
            label="Postcode"
            :disabled="disabled"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-col>
  </OverridableFieldContainer>
</template>
