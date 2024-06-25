<script setup lang="ts">
import type { RoleInput, RoleData } from '~/server/types/role';

const { useUpdateRole } = useRole();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateRole();

const model = defineModel<boolean>();
const props = defineProps<{
  role: RoleData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const roleInput = ref<RoleInput | null>(null);

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
  if (roleInput.value === null) {
    return;
  }

  try {
    const roleId = await update({
      id: props.role.id,
      ...roleInput.value,
    });

    if (roleId) {
      emit('updated', roleId);
    }

    createAlert({
      message: 'Role updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update Role.',
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
        <div>Update {{ roleInput?.firstname || props.role.firstname }}</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <RolesDataForm
          v-model="roleInput"
          :current-role="props.role"
        ></RolesDataForm>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="disableBtn" color="error" @click="close">
          Cancel
        </v-btn>
        <v-btn :disabled="disableBtn" color="primary" @click="submitUpdate">
          Update
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
