<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

const props = defineProps<{
  member: MemberData | null;
}>();
</script>

<template>
  <v-card v-if="props.member">
    <OverridableTitle
      label="Child / Spouse"
      :to="`/members/${props.member.id}`"
    >
      {{ props.member.firstname }} {{ props.member.lastname }}
    </OverridableTitle>

    <v-card-text>
      <OverridableText
        label="Address"
        :to="$filters.googleMapsLink(props.member.address)"
      >
        {{ $filters.address(props.member.address) }}
      </OverridableText>
      <OverridableText label="Email">
        {{ props.member.email }}
      </OverridableText>
      <OverridableText label="Homephone">
        {{ $filters.phone(props.member.phoneHome) }}
      </OverridableText>
      <OverridableText label="Workphone">
        {{ $filters.phone(props.member.phoneWork) }}
      </OverridableText>
      <OverridableText label="Mobile">
        {{ $filters.phone(props.member.phoneMobile) }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
