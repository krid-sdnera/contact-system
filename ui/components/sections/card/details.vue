<script setup lang="ts">
import type { SectionData } from '~/server/types/section';

const props = defineProps<{
  section: SectionData | null;
}>();
</script>

<template>
  <v-card v-if="props.section">
    <OverridableTitle label="section">
      {{ props.section.name }}
    </OverridableTitle>

    <v-card-text>
      <OverridableText
        label="Group"
        :to="`/groups/${props.section.scoutGroup.id}`"
      >
        {{ props.section.scoutGroup.name }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
