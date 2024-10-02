<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

const props = defineProps<{
  scoutGroup: ScoutGroupData | null;
}>();
</script>

<template>
  <v-card v-if="props.scoutGroup">
    <v-card-title>Extranet</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText label="Group Id">
        {{ props.scoutGroup.externalId }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
