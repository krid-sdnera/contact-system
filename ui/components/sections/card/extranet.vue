<script setup lang="ts">
import type { SectionData } from '~/server/types/section';

const props = defineProps<{
  section: SectionData | null;
}>();
</script>

<template>
  <v-card v-if="props.section">
    <v-card-title>Extranet</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText label="Section Id">
        {{ props.section.externalId }}
      </OverridableText>
      <OverridableText label="Group Id">
        {{ props.section.scoutGroup.externalId }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
