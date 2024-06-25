<script setup lang="ts">
import type { ScoutGroupInput, ScoutGroupData } from '~/server/types/scoutGroup';

const { useCreateScoutGroup } = useScoutGroup();
const { create, created, loading, error, errorMessage, reset } =
  useCreateScoutGroup();

const model = defineModel<boolean>();
const props = defineProps<{}>();
const emit = defineEmits<{
  created: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const scoutGroupInput = ref<ScoutGroupInput | null>(null);

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
  if (scoutGroupInput.value === null) {
    return;
  }

  try {
    const scoutGroupId = await create(scoutGroupInput.value);

    if (scoutGroupId) {
      emit('created', scoutGroupId);
    }

    createAlert({
      message: 'ScoutGroup created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create ScoutGroup.',
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
        <div>Creating a new scoutGroup</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ScoutGroupsDataForm v-model="scoutGroupInput"></ScoutGroupsDataForm>
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
