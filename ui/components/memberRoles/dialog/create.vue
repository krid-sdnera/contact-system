<script setup lang="ts">
import type { MemberData } from '~/server/types/member';
import type {
  MemberRoleInput,
  MemberRoleData,
} from '~/server/types/memberRole';
import type { RoleData } from '~/server/types/role';

const { useCreateMemberRole } = useMemberRole();
const { create, created, loading, error, errorMessage, reset } =
  useCreateMemberRole();

const model = defineModel<boolean>();
const props = defineProps<{
  member: MemberData;
}>();
const emit = defineEmits<{
  created: [string];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

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

async function submitCreate() {
  if (memberRoleInput.value === null || memberRoleRoleInput.value === null) {
    return;
  }

  try {
    const memberRoleId = await create(
      props.member.id,
      memberRoleRoleInput.value.id,
      memberRoleInput.value
    );

    if (memberRoleId) {
      emit('created', memberRoleId);
    }

    createAlert({
      message: 'MemberRole created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create MemberRole.',
      type: 'error',
    });
  }
}

const disableBtn = computed(
  () => globalPending.value || loading.value || created.value
);
</script>

<template>
  <v-dialog v-model="model" persistent scrollable max-width="600px">
    <v-card style="height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>Creating a new memberRole</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <MemberRolesDataForm
          v-model:role="memberRoleRoleInput"
          v-model="memberRoleInput"
        ></MemberRolesDataForm>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="disableBtn" color="error" @click="close">
          Cancel
        </v-btn>
        <v-btn :disabled="disableBtn" color="primary" @click="submitCreate">
          Create
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
