<script setup lang="ts">
import type { RoleInput, RoleData } from '~/server/types/role';

const { useDeleteRole } = useRole();
const { deleteFn, deleted, loading, error, errorMessage, reset } =
  useDeleteRole();

const model = defineModel<boolean>();
const props = defineProps<{
  role: RoleData;
}>();
const emit = defineEmits<{
  deleted: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

watch(model, (newValue) => {
  if (newValue === true) {
    // Reset to allow for reuse.
    reset();
  }
});

function close() {
  model.value = false;
}

async function submitDelete() {
  try {
    const roleId = await deleteFn(props.role.id);

    if (roleId) {
      emit('deleted', roleId);
    }

    createAlert({
      message: 'Role deleted.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to delete Role.',
      type: 'error',
    });
  }
}

const disableBtn = computed(
  () => globalPending.value || loading.value || deleted.value
);
</script>

<template>
  <v-dialog v-model="model" persistent scrollable max-width="600px">
    <v-card style="height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>Delete {{ props.role.firstname }}?</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        You are about to delete "{{ props.role.firstname }}"<br />
        Are you sure you wish to continue?
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="disableBtn" color="primary" @click="close">
          Cancel
        </v-btn>
        <v-btn :disabled="disableBtn" color="error" @click="submitDelete">
          Delete
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
