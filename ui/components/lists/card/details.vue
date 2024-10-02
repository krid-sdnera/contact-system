<script setup lang="ts">
import type { ListData } from '~/server/types/list';

const props = defineProps<{
  list: ListData | null;
}>();
</script>

<template>
  <v-card v-if="props.list">
    <v-card-title>Details</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText label="Name">
        {{ props.list.name }}
      </OverridableText>

      <OverridableText label="Address">
        {{ props.list.address }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
