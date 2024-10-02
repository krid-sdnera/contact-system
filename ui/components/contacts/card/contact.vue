<script setup lang="ts">
import type { ContactData } from '~/server/types/contact';

const props = defineProps<{
  contact: ContactData | null;
}>();

const { isOverridden } = useOverriddenContact(computed(() => props.contact));
</script>

<template>
  <v-card v-if="props.contact">
    <v-card-title>Contacts</v-card-title>

    <v-divider></v-divider>

    <v-card-text>
      <OverridableText
        label="Address"
        :overridden="isOverridden('address')"
        :to="$filters.googleMapsLink(props.contact.address)"
      >
        {{ $filters.address(props.contact.address) }}
      </OverridableText>

      <OverridableText label="Email" :overridden="isOverridden('email')">
        {{ props.contact.email }}
      </OverridableText>

      <OverridableText
        label="Homephone"
        :overridden="isOverridden('phoneHome')"
      >
        {{ $filters.phone(props.contact.phoneHome) }}
      </OverridableText>
      <OverridableText
        label="Workphone"
        :overridden="isOverridden('phoneWork')"
      >
        {{ $filters.phone(props.contact.phoneWork) }}
      </OverridableText>
      <OverridableText label="Mobile" :overridden="isOverridden('phoneMobile')">
        {{ $filters.phone(props.contact.phoneMobile) }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
