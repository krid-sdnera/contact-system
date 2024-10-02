<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

useHead({
  title: 'Contacts',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/contacts`, label: `Contacts` },
    { to: ``, label: `Details` },
  ]),
  validate: async (route) => {
    if (Array.isArray(route.params.id)) {
      return false;
    }

    // Check if the id is made up of digits
    return /^\d+$/.test(route.params.id);
  },
});

const route = useRoute();
const contactId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchContact } = useContact();
const { contact: contactRef, status } = useFetchContact(contactId);

const contact = computed(() =>
  status.value === 'success' ? contactRef.value : null
);

const { getMember, useFetchMember } = useMember();
const unwatchContact = watch(contactRef, () => {
  if (contactRef.value) {
    unwatchContact();
    const { status } = useFetchMember(contactRef.value.memberId);
  }
});
const member = computed((): MemberData | null => {
  return contact.value ? getMember(contact.value?.memberId).value : null;
});

const { isOverridden } = useOverriddenContact(contact);
</script>

<template>
  <div>
    <v-row>
      <v-col>
        <v-card v-if="contact" color="red-darken-4">
          <OverridableTitle
            label="Contact"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ $filters.propperName(contact) }}
          </OverridableTitle>
        </v-card>
        <v-skeleton-loader v-else type="heading"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row class="flex-row-reverse">
      <v-col cols="12" sm="3">
        <v-row>
          <v-col cols="12">
            <CardSectionJump
              :jumps="[{ label: 'List Rules', hash: '#list-rules' }]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <ContactsCardAdmin :contact="contact"></ContactsCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <ContactsCardDetails :contact="contact"></ContactsCardDetails>
          </v-col>
          <v-col cols="12" sm="6">
            <ContactsCardContact :contact="contact"></ContactsCardContact>
          </v-col>
          <v-col cols="12" sm="6">
            <ContactsCardMember :member="member"></ContactsCardMember>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="contact">
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ contact }" allow-creation></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
