<script setup lang="ts">
import type { ContactInput, ContactData } from '~/server/types/contact';
import { ContactInputStateEnum } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';

const model = defineModel<ContactInputWithOverride | null>();
const props = defineProps<{
  currentContact?: ContactData;
  member?: MemberData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalContactData(props.currentContact);
});

type ContactInputWithOverride = Omit<ContactInput, 'overrides'> &
  Required<Pick<ContactInput, 'overrides'>>;

function buildInternalContactData(
  currentContact?: ContactData
): ContactInputWithOverride {
  if (currentContact) {
    return {
      state: currentContact.state as unknown as ContactInputStateEnum,
      firstname: currentContact.firstname,
      nickname: currentContact.nickname,
      lastname: currentContact.lastname,
      primaryContact: currentContact.primaryContact,
      address: {
        street1: currentContact.address?.street1 || '',
        street2: currentContact.address?.street2,
        city: currentContact.address?.city || '',
        state: currentContact.address?.state || '',
        postcode: currentContact.address?.postcode || '',
      },
      memberId: currentContact.memberId,
      parentId: currentContact.parentId,
      phoneHome: currentContact.phoneHome,
      phoneMobile: currentContact.phoneMobile,
      phoneWork: currentContact.phoneWork,
      email: currentContact.email,
      occupation: currentContact.occupation,
      relationship: currentContact.relationship,
      overrides: Object.assign({}, currentContact.overrides || {}),
    };
  } else {
    return {
      state: ContactInputStateEnum.Enabled,
      memberId: props.member?.id,
      parentId: undefined,
      expiry: undefined,
      firstname: '',
      nickname: '',
      lastname: '',
      primaryContact: false,
      address: {
        street1: '',
        street2: '',
        city: '',
        state: '',
        postcode: '',
      },
      phoneHome: '',
      phoneMobile: '',
      phoneWork: '',
      email: '',
      occupation: '',
      relationship: '',
      overrides: {},
    };
  }
}

const showMemberIdSelect = computed(() => {
  if (props.member?.id) {
    // Member record was provided during creation.
    return false;
  }
  if (props.currentContact?.memberId) {
    // Current Contact record was provided for updating.
    return false;
  }

  // Assuming we are creating a contact without a provided member.
  return true;
});
</script>

<template>
  <v-container v-if="model">
    <!-- State & Expiry -->
    <DataFormState
      v-model:state="model.state"
      v-model:expiry="model.expiry"
    ></DataFormState>

    <!-- Member -->
    <OverridableTextField
      v-if="showMemberIdSelect"
      v-model="model.memberId"
      label="Member (TODO: Make a search box)"
    ></OverridableTextField>
    <v-row v-else>
      <v-col>
        Linked with
        {{
          props.member?.firstname ?? `Member #${props.currentContact?.memberId}`
        }}
      </v-col>
    </v-row>

    <!-- Parent ID -->
    <OverridableTextField
      v-model="model.parentId"
      label="Parent ID"
      hide-override-checkbox
    ></OverridableTextField>

    <!-- Firstname -->
    <OverridableTextField
      v-model="model.firstname"
      v-model:overridden="model.overrides.firstname"
      label="Firstname"
    ></OverridableTextField>

    <!-- Nickname -->
    <OverridableTextField
      v-model="model.nickname"
      v-model:overridden="model.overrides.nickname"
      label="Nickname"
    ></OverridableTextField>

    <!-- Lastname -->
    <OverridableTextField
      v-model="model.lastname"
      v-model:overridden="model.overrides.lastname"
      label="Lastname"
    ></OverridableTextField>

    <!-- Primary Contact -->
    <OverridableTextField
      v-model="model.primaryContact"
      v-model:overridden="model.overrides.primaryContact"
      label="Primary Contact"
      type="date"
    ></OverridableTextField>

    <v-row>
      <v-col cols="4">
        <!-- Homephone -->
        <OverridableTextField
          v-model="model.phoneHome"
          v-model:overridden="model.overrides.phoneHome"
          label="Homephone"
        ></OverridableTextField>
      </v-col>
      <v-col cols="4">
        <!-- Mobilephone -->
        <OverridableTextField
          v-model="model.phoneMobile"
          v-model:overridden="model.overrides.phoneMobile"
          label="Mobilephone"
        ></OverridableTextField>
      </v-col>
      <v-col cols="4">
        <!-- Workphone -->
        <OverridableTextField
          v-model="model.phoneWork"
          v-model:overridden="model.overrides.phoneWork"
          label="Workphone"
        ></OverridableTextField>
      </v-col>
    </v-row>

    <!-- Occupation -->
    <OverridableTextField
      v-model="model.occupation"
      v-model:overridden="model.overrides.occupation"
      label="Occupation"
    ></OverridableTextField>

    <!-- Relationship -->
    <OverridableTextField
      v-model="model.relationship"
      v-model:overridden="model.overrides.relationship"
      label="Relationship"
    ></OverridableTextField>

    <!-- Email -->
    <OverridableTextField
      v-model="model.email"
      v-model:overridden="model.overrides.email"
      label="Email"
    ></OverridableTextField>

    <!-- Address -->
    <OverridableAddressField
      v-model="model.address"
      v-model:overridden="model.overrides.address"
      label="Address"
    ></OverridableAddressField>

    <small>*indicates required field</small>
  </v-container>
</template>
