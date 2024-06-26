<script setup lang="ts">
import type { MemberData } from '~/server/types/member';
import type {
  MemberRoleInput,
  MemberRoleData,
} from '~/server/types/memberRole';
import type { RoleData } from '~/server/types/role';

const { useUpdateMemberRole } = useMemberRole();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateMemberRole();

const model = defineModel<boolean>();
const props = defineProps<{
  memberRole: MemberRoleData;
}>();
const emit = defineEmits<{
  updated: [string];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const { getMember } = useMember();
const member = getMember(props.memberRole.memberId);
const memberRoleInput = ref<MemberRoleInput | null>(null);
const memberRoleRoleInput = ref<RoleData | null>(null);

watch(model, (newValue) => {
  if (newValue === true) {
    // Reset to allow for reuse.
    reset();
  }
});

function close() {
  model.value = false;
}

async function submitUpdate() {
  if (
    memberRoleInput.value === null ||
    memberRoleRoleInput.value === null ||
    member.value === null
  ) {
    return;
  }

  try {
    const memberRoleId = await update({
      memberId: member.value.id,
      roleId: memberRoleRoleInput.value.id,
      ...memberRoleInput.value,
    });

    if (memberRoleId) {
      emit('updated', memberRoleId);
    }

    createAlert({
      message: 'MemberRole clone.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to clone MemberRole.',
      type: 'error',
    });
  }
}

const disableBtn = computed(
  () => globalPending.value || loading.value || updated.value
);
</script>

<template>
  <v-dialog v-model="model" persistent scrollable max-width="600px">
    <v-card style="height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>Clone {{ props.memberRole.id }} (mbr-role)?</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <MemberRolesDataForm
          v-model:role="memberRoleRoleInput"
          v-model="memberRoleInput"
          :currentMemberRole="props.memberRole"
        ></MemberRolesDataForm>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="disableBtn" color="error" @click="close">
          Cancel
        </v-btn>
        <v-btn :disabled="disableBtn" color="primary" @click="submitUpdate">
          Clone
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
