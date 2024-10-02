<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

const props = defineProps<{
  member: MemberData | null;
}>();

const { isOverridden } = useOverriddenMember(computed(() => props.member));
</script>

<template>
  <v-card v-if="props.member">
    <v-card-title>Details</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText label="Rego" :overridden="isOverridden('gender')">
        {{ props.member.membershipNumber }}
      </OverridableText>

      <OverridableText
        label="Date of Birth"
        :overridden="isOverridden('dateOfBirth')"
      >
        {{ $filters.date(props.member.dateOfBirth) }}
        ({{ $filters.duration(props.member.dateOfBirth) }})
      </OverridableText>

      <OverridableText label="Gender" :overridden="isOverridden('gender')">
        {{ props.member.gender }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
