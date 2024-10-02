<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

const props = defineProps<{
  member: MemberData | null;
}>();

const { isOverridden } = useOverriddenMember(computed(() => props.member));
</script>

<template>
  <v-card v-if="props.member">
    <v-card-title>Contacts</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText
        label="Address"
        :overridden="isOverridden('address')"
        :to="$filters.googleMapsLink(props.member.address)"
      >
        {{ $filters.address(props.member.address) }}
      </OverridableText>

      <OverridableText label="Email" :overridden="isOverridden('email')">
        {{ props.member.email }}
      </OverridableText>

      <OverridableText
        label="Homephone"
        :overridden="isOverridden('phoneHome')"
      >
        {{ $filters.phone(props.member.phoneHome) }}
      </OverridableText>
      <OverridableText
        label="Workphone"
        :overridden="isOverridden('phoneWork')"
      >
        {{ $filters.phone(props.member.phoneWork) }}
      </OverridableText>
      <OverridableText label="Mobile" :overridden="isOverridden('phoneMobile')">
        {{ $filters.phone(props.member.phoneMobile) }}
      </OverridableText>

      <!-- Member School Details -->
      <template v-if="props.member.schoolName || props.member.schoolYearLevel">
        <OverridableText
          label="School Name"
          :overridden="isOverridden('schoolName')"
        >
          {{ props.member.schoolName }}
        </OverridableText>

        <OverridableText
          label="School Year Level"
          :overridden="isOverridden('schoolYearLevel')"
        >
          {{ props.member.schoolYearLevel }}
        </OverridableText>
      </template>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
