<script setup lang="ts">
import type {
  MemberRoleInput,
  MemberRoleData,
} from '~/server/types/memberRole';
import { MemberRoleInputStateEnum } from '~/server/types/memberRole';
import type { RoleData } from '~/server/types/role';

const model = defineModel<MemberRoleInput | null>();
const modelRole = defineModel<RoleData | null>('role');
const props = defineProps<{
  currentMemberRole?: MemberRoleData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalMemberRoleData(props.currentMemberRole);
});

function buildInternalMemberRoleData(
  currentMemberRole?: MemberRoleData
): MemberRoleInput {
  if (currentMemberRole) {
    return {
      state: ((currentMemberRole.state as unknown) ||
        MemberRoleInputStateEnum.Enabled) as MemberRoleInputStateEnum,
      expiry: currentMemberRole.expiry?.substr(0, 10),
    };
  } else {
    return {
      state: MemberRoleInputStateEnum.Enabled,
      expiry: undefined,
    };
  }
}

const { roles, useListAllRoles } = useRole();
const { error, errorMessage, status } = useListAllRoles();

const roleOptions = computed(() => {
  if (error.value) {
    return [];
  }

  return Object.values(roles.value).map((role) => ({
    title: role.name,
    subtitle: `${role.section.name} - ${role.section.scoutGroup.name}`,
    value: role,
  }));
});
</script>

<template>
  <v-container v-if="model">
    <!-- State & Expiry -->
    <DataFormState
      v-model:state="model.state"
      v-model:expiry="model.expiry"
    ></DataFormState>

    <v-row>
      <!-- Role selection -->
      <v-select
        v-model="modelRole"
        label="Role"
        :loading="status !== 'success'"
        :items="roleOptions"
        :color="roleOptions.length == 0 ? 'error' : ''"
      ></v-select>
    </v-row>

    <!-- // TODO: Add subtitles // TODO: Add checkbox to restict roles to ones from
    the current sections -->
    <small>*indicates required field</small>
  </v-container>
</template>
