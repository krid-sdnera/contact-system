<script setup lang="ts">
import type { RoleData } from '~/server/types/role';

const props = defineProps<{
  role: RoleData | null;
}>();
</script>

<template>
  <v-card v-if="props.role">
    <OverridableTitle label="Role">
      {{ props.role.name }}
    </OverridableTitle>

    <v-card-text>
      <OverridableText
        label="Section"
        :to="`/sections/${props.role.section.id}`"
      >
        {{ props.role.section.name }}
      </OverridableText>
      <OverridableText
        label="Group"
        :to="`/groups/${props.role.section.scoutGroup.id}`"
      >
        {{ props.role.section.scoutGroup.name }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
