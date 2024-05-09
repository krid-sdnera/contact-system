<script setup lang="ts">
import type { NuxtError } from '#app';

console.log('error');

const props = defineProps({
  error: Object as () => NuxtError,
});

const handleError = () => clearError({ redirect: '/' });
</script>

<template>
  <NuxtLayout name="default">
    <v-row v-if="props.error">
      <v-col cols="6" md="6" offset-md="3" sm="12">
        <v-card color="error" variant="outlined">
          <v-card-title>
            {{ error }}
          </v-card-title>
          <v-card-text>
            {{ props.error.statusCode }}
            {{ props.error.message }}
          </v-card-text>
          <v-card-text>
            {{ props.error.data }}
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="handleError"> Go to the Dashboard </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </NuxtLayout>
</template>
