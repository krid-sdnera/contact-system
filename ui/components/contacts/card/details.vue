<script setup lang="ts">
import type { ContactData } from '~/server/types/contact';

const props = defineProps<{
  contact: ContactData | null;
}>();

const { isOverridden } = useOverriddenContact(computed(() => props.contact));
</script>

<template>
  <v-card v-if="props.contact">
    <OverridableTitle
      label="Contact"
      :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
    >
      {{ props.contact.firstname }} {{ props.contact.lastname }}
    </OverridableTitle>

    <v-card-text>
      <OverridableText label="Extranet Parent Id">
        {{ props.contact.parentId }}
      </OverridableText>

      <OverridableText
        label="Primary Contact"
        :overridden="isOverridden('primaryContact')"
      >
        {{ props.contact.primaryContact ? 'Yes' : 'No' }}
      </OverridableText>

      <OverridableText
        label="Relationship Contact"
        :overridden="isOverridden('relationship')"
      >
        {{ props.contact.relationship }}
      </OverridableText>

      <OverridableText
        label="Occupation"
        :overridden="isOverridden('occupation')"
      >
        {{ props.contact.occupation }}
      </OverridableText>
    </v-card-text>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
