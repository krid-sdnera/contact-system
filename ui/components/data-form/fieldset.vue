<script setup lang="ts">
const props = defineProps<{
  colour?: string;
  legend?: string;
}>();
</script>

<template>
  <v-row>
    <v-col>
      <v-card class="pa-2" v-bind="$attrs">
        <v-card-title v-if="props.legend">{{ props.legend }}</v-card-title>
        <v-card-text>
          <slot></slot>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
