<script setup lang="ts">
const modelState = defineModel<'enabled' | 'disabled'>('state');
const modelExpiry = defineModel<string | undefined | null>('expiry');

watch(modelState, (newState) => {
  if (newState === 'disabled') {
    // Set value to null. This clears the date-input.
    modelExpiry.value = null;
    // Set value to undefined because this is the actual value to return.
    modelExpiry.value = undefined;
  }
});
</script>

<template>
  <v-row class="mb-4">
    <v-col>
      <v-card
        elevation="6"
        variant="outlined"
        class="pa-2"
        :color="modelState === 'enabled' ? 'light-green-lighten-4' : ''"
      >
        <v-card-text>
          <v-row>
            <v-switch
              v-model="modelState"
              :label="`State: ${$filters.capitalize(modelState)}`"
              :color="modelState === 'enabled' ? 'green-darken-2' : ''"
              false-value="disabled"
              true-value="enabled"
            ></v-switch>
          </v-row>

          <!-- Expiry -->
          <v-row>
            <v-date-input
              v-model="modelExpiry"
              show-adjacent-months
              persistent-placeholder
              prepend-icon=""
              prepend-inner-icon="$calendar"
              hint="Date is in mm/dd/yyyy"
              clearable
              persistent-hint
            ></v-date-input>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
