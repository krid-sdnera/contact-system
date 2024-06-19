<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

const props = defineProps<{
  scoutGroup: ScoutGroupData | null;
}>();
</script>

<template>
  <v-card v-if="props.scoutGroup">
    <OverridableTitle label="Group">
      {{ props.scoutGroup.name }}
    </OverridableTitle>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
