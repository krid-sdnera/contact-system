<script setup lang="ts">
import type { RoleInput, RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const { useCreateRole } = useRole();
const { create, created, loading, error, errorMessage, reset } =
  useCreateRole();

const model = defineModel<boolean>();
const props = defineProps<{
  section?: SectionData;
}>();
const emit = defineEmits<{
  created: [number];
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

async function submitCreate() {
  if (roleInput.value === null) {
    return;
  }

  try {
    const roleId = await create(roleInput.value);

    if (roleId) {
      emit('created', roleId);
    }

    createAlert({
      message: 'Role created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create Role.',
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
        <div v-if="props.section">
          Creating a new role for {{ props.section.name }}
        </div>
        <div v-else>Creating a new role</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <RolesDataForm
          v-model="roleInput"
          :section="props.section"
        ></RolesDataForm>
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
