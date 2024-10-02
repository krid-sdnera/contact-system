<script setup lang="ts">
const props = defineProps<{
  colour?: string;
  legend?: string;
}>();
</script>

<template>
  <v-row class="mb-4">
    <v-col>
      <v-card
        elevation="6"
        variant="outlined"
        class="pa-2"
        :color="props.colour"
      >
        <v-card-title v-if="props.legend">{{ props.legend }}</v-card-title>
        <v-card-text>
          <slot></slot>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
