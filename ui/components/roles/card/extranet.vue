<script setup lang="ts">
import type { RoleData } from '~/server/types/role';

const props = defineProps<{
  role: RoleData | null;
}>();
</script>

<template>
  <v-card v-if="props.role">
    <OverridableTitle label="Extranet"> Advanced </OverridableTitle>

    <v-card-text>
      <OverridableText label="Role Id">
        {{ props.role.externalId }}
      </OverridableText>
      <OverridableText label="Class Id">
        {{ props.role.classId }}
      </OverridableText>
      <OverridableText label="Normalised Class Id">
        {{ props.role.normalisedClassId }}
      </OverridableText>
      <OverridableText label="Section Id">
        {{ props.role.section.externalId }}
      </OverridableText>
      <OverridableText label="Group Id">
        {{ props.role.section.scoutGroup.externalId }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
