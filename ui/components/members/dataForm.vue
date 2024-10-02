<script setup lang="ts">
import type { MemberInput, MemberData } from '~/server/types/member';
import { MemberInputStateEnum } from '~/server/types/member';

const model = defineModel<MemberInputWithOverride | null>();
const props = defineProps<{
  currentMember?: MemberData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalMemberData(props.currentMember);
});
const fieldMode = computed(() =>
  props.currentMember === undefined ? 'create' : 'update'
);

type MemberInputWithOverride = Omit<MemberInput, 'overrides'> &
  Required<Pick<MemberInput, 'overrides'>>;

function buildInternalMemberData(
  currentMember?: MemberData
): MemberInputWithOverride {
  if (currentMember) {
    return {
      state: (currentMember.state ||
        MemberInputStateEnum.Enabled) as MemberInputStateEnum,
      expiry: currentMember.expiry?.substr(0, 10),
      firstname: currentMember.firstname,
      nickname: currentMember.nickname,
      lastname: currentMember.lastname,
      address: {
        street1: currentMember.address?.street1 || '',
        street2: currentMember.address?.street2,
        city: currentMember.address?.city || '',
        state: currentMember.address?.state || '',
        postcode: currentMember.address?.postcode || '',
      },
      dateOfBirth: currentMember.dateOfBirth?.toISOString().substr(0, 10),
      membershipNumber: currentMember.membershipNumber,
      phoneHome: currentMember.phoneHome,
      phoneMobile: currentMember.phoneMobile,
      phoneWork: currentMember.phoneWork,
      schoolName: currentMember.schoolName,
      schoolYearLevel: currentMember.schoolYearLevel,
      email: currentMember.email,
      gender: currentMember.gender,
      overrides: Object.assign({}, currentMember.overrides || {}),
    };
  } else {
    return {
      state: MemberInputStateEnum.Enabled,
      expiry: undefined,
      firstname: '',
      nickname: '',
      lastname: '',
      address: {
        street1: '',
        street2: '',
        city: '',
        state: '',
        postcode: '',
      },
      dateOfBirth: undefined,
      membershipNumber: '',
      phoneHome: '',
      phoneMobile: '',
      phoneWork: '',
      schoolName: '',
      schoolYearLevel: '',
      email: '',
      gender: '',
      overrides: {},
    };
  }
}
</script>

<template>
  <v-container v-if="model">
    <!-- State & Expiry -->
    <DataFormState
      v-model:state="model.state"
      v-model:expiry="model.expiry"
      :management="props.currentMember?.managementState"
    ></DataFormState>

    <!-- Membership Number -->
    <OverridableTextField
      v-model="model.membershipNumber"
      label="Membership Number"
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

    <!-- Date of birth -->
    <OverridableDateField
      v-model="model.dateOfBirth"
      v-model:overridden="model.overrides.dateOfBirth"
      label="Date of birth"
      :mode="fieldMode"
    ></OverridableDateField>

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

    <!-- School Name -->
    <OverridableTextField
      v-model="model.schoolName"
      v-model:overridden="model.overrides.schoolName"
      label="School Name"
      :mode="fieldMode"
    ></OverridableTextField>

    <!-- School Year Level -->
    <OverridableTextField
      v-model="model.schoolYearLevel"
      v-model:overridden="model.overrides.schoolYearLevel"
      label="School Year Level"
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
