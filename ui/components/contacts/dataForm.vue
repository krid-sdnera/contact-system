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
const fieldMode = computed(() =>
  props.currentContact === undefined ? 'create' : 'update'
);

type ContactInputWithOverride = Omit<ContactInput, 'overrides'> &
  Required<Pick<ContactInput, 'overrides'>>;

function buildInternalContactData(
  currentContact?: ContactData
): ContactInputWithOverride {
  if (currentContact) {
    return {
      state: currentContact.state as unknown as ContactInputStateEnum,
      expiry: currentContact.expiry?.substr(0, 10),
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
      expiry: undefined,
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
      overrides: {
        parentId: true,
        firstname: true,
        nickname: true,
        lastname: true,
        primaryContact: true,
        phoneHome: true,
        phoneMobile: true,
        phoneWork: true,
        occupation: true,
        relationship: true,
        email: true,
        address: true,
      },
    };
  }
}

const showMemberIdSelect = computed(() => {
  if (props.member?.id) {
    // Member record was provided during create.
    return false;
  }
  if (props.currentContact?.memberId) {
    // Current Contact record was provided for updating.
    return false;
  }

  // Assuming we are creating a contact without a provided member.
  return true;
});

const memberSelectModel = ref<MemberData | null>(null);
if (showMemberIdSelect.value === true) {
  watch(memberSelectModel, () => {
    if (!model.value) {
      return;
    }

    model.value.memberId = memberSelectModel.value?.id ?? 0;
  });
}
</script>

<template>
  <v-container v-if="model">
    <!-- State & Expiry -->
    <DataFormState
      v-model:state="model.state"
      v-model:expiry="model.expiry"
      :management="props.currentContact?.managementState"
    ></DataFormState>

    <!-- Member -->
    <OverridableFieldContainer
      v-if="showMemberIdSelect"
      label="Member"
      :mode="fieldMode"
    >
      <MembersFieldSelect
        v-model="memberSelectModel"
        label="Member"
      ></MembersFieldSelect>
    </OverridableFieldContainer>
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
      v-model:overridden="model.overrides.parentId"
      label="Parent ID"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Firstname -->
    <OverridableTextField
      v-model="model.firstname"
      v-model:overridden="model.overrides.firstname"
      label="Firstname"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Nickname -->
    <OverridableTextField
      v-model="model.nickname"
      v-model:overridden="model.overrides.nickname"
      label="Nickname"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Lastname -->
    <OverridableTextField
      v-model="model.lastname"
      v-model:overridden="model.overrides.lastname"
      label="Lastname"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Primary Contact -->
    <OverridableCheckboxField
      v-model="model.primaryContact"
      v-model:overridden="model.overrides.primaryContact"
      label="Primary Contact"
      :mode="fieldMode"
    ></OverridableCheckboxField>

    <v-row>
      <v-col cols="4">
        <!-- Homephone -->
        <OverridableTextField
          v-model="model.phoneHome"
          v-model:overridden="model.overrides.phoneHome"
          label="Homephone"
          :mode="fieldMode"
        ></OverridableTextField>
      </v-col>
      <v-col cols="4">
        <!-- Mobilephone -->
        <OverridableTextField
          v-model="model.phoneMobile"
          v-model:overridden="model.overrides.phoneMobile"
          label="Mobilephone"
          :mode="fieldMode"
        ></OverridableTextField>
      </v-col>
      <v-col cols="4">
        <!-- Workphone -->
        <OverridableTextField
          v-model="model.phoneWork"
          v-model:overridden="model.overrides.phoneWork"
          label="Workphone"
          :mode="fieldMode"
        ></OverridableTextField>
      </v-col>
    </v-row>

    <!-- Occupation -->
    <OverridableTextField
      v-model="model.occupation"
      v-model:overridden="model.overrides.occupation"
      label="Occupation"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Relationship -->
    <OverridableTextField
      v-model="model.relationship"
      v-model:overridden="model.overrides.relationship"
      label="Relationship"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Email -->
    <OverridableTextField
      v-model="model.email"
      v-model:overridden="model.overrides.email"
      label="Email"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- Address -->
    <OverridableAddressField
      v-model="model.address"
      v-model:overridden="model.overrides.address"
      label="Address"
      :mode="fieldMode"
    ></OverridableAddressField>

    <small>*indicates required field</small>
  </v-container>
</template>
