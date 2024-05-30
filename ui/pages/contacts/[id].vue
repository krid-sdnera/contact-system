<script setup lang="ts">
import type { ContactData, ContactOverrideData } from '~/server/types/contact';
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
const { contact, status } = useFetchContact(contactId);

const { getMember, useFetchMember } = useMember();
const unwatchContact = watch(contact, () => {
  if (contact.value) {
    unwatchContact();
    const { status } = useFetchMember(contact.value.memberId);
  }
});
const member = computed((): MemberData | null => {
  return contact.value ? getMember(contact.value?.memberId).value : null;
});

function isOverridden(field: string | string[]): boolean {
  const fields = typeof field === 'string' ? [field] : field;

  return fields.some(
    (field) =>
      contact.value?.overrides?.[field as keyof ContactOverrideData] === true
  );
}

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}
</script>

<template>
  <div v-if="contact && status === 'success'">
    <ContactsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :contact="contact"
    ></ContactsUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact Details -->
        <v-card class="mb-6">
          <OverridableTitle
            label="Contact"
            :overridden="isOverridden(['firstname', 'nickname', 'lastname'])"
          >
            {{ contact.firstname }} {{ contact.lastname }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Extranet Parent Id"
              :overridden="isOverridden('parentId')"
            >
              {{ contact.parentId }}
            </OverridableText>

            <OverridableText
              label="Primary Contact"
              :overridden="isOverridden('primaryContact')"
            >
              {{ contact.primaryContact ? 'Yes' : 'No' }}
            </OverridableText>

            <OverridableText
              label="Relationship Contact"
              :overridden="isOverridden('relationship')"
            >
              {{ contact.relationship }}
            </OverridableText>

            <OverridableText
              label="Occupation"
              :overridden="isOverridden('occupation')"
            >
              {{ contact.occupation }}
            </OverridableText>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>

        <!-- Contact Management -->
        <v-card>
          <v-card-title>Advanced</v-card-title>
          <v-card-text>
            <v-chip class="mb-1" :class="{ red: contact.state === 'disabled' }">
              {{ $filters.capitalize(contact.state) }}
            </v-chip>
            <v-chip class="mb-1">
              {{ $filters.capitalize(contact.managementState) }}
            </v-chip>
            <v-chip v-if="contact.expiry" class="mb-1">{{
              contact.expiry
            }}</v-chip>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact Details -->
        <v-card>
          <OverridableTitle
            :label="`${contact.firstname} ${contact.lastname}'${
              contact.lastname.endsWith('s') ? '' : 's'
            }`"
          >
            Contact Details
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Address"
              :overridden="isOverridden('address')"
              :to="$filters.googleMapsLink(contact.address)"
            >
              {{ $filters.address(contact.address) }}
            </OverridableText>

            <OverridableText label="Email" :overridden="isOverridden('email')">
              {{ contact.email }}
            </OverridableText>

            <OverridableText
              label="Homephone"
              :overridden="isOverridden('phoneHome')"
            >
              {{ $filters.phone(contact.phoneHome) }}
            </OverridableText>
            <OverridableText
              label="Workphone"
              :overridden="isOverridden('phoneWork')"
            >
              {{ $filters.phone(contact.phoneWork) }}
            </OverridableText>
            <OverridableText
              label="Mobile"
              :overridden="isOverridden('phoneMobile')"
            >
              {{ $filters.phone(contact.phoneMobile) }}
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <!-- Contact member details -->
        <v-card v-if="member">
          <OverridableTitle
            label="Child / Spouse"
            :to="`/members/${member.id}`"
          >
            {{ member.firstname }} {{ member.lastname }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText
              label="Address"
              :to="$filters.googleMapsLink(member.address)"
            >
              {{ $filters.address(contact.address) }}
            </OverridableText>
            <OverridableText label="Email">
              {{ member.email }}
            </OverridableText>
            <OverridableText label="Homephone">
              {{ $filters.phone(contact.phoneHome) }}
            </OverridableText>
            <OverridableText label="Workphone">
              {{ $filters.phone(contact.phoneWork) }}
            </OverridableText>
            <OverridableText label="Mobile">
              {{ $filters.phone(contact.phoneMobile) }}
            </OverridableText>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Email Rules Table -->
        <ListRulesList :relation="{ contact }" allow-creation></ListRulesList>
      </v-col>
    </v-row>
  </div>
  <div v-else-if="status === 'pending'">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <div v-else>{{ status }}</div>
  <!-- <error-display v-else :error="'unknown''"></error-display> -->
</template>
