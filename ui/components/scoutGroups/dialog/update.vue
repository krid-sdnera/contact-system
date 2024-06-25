<script setup lang="ts">
import type {
  ScoutGroupInput,
  ScoutGroupData,
} from '~/server/types/scoutGroup';

const { useUpdateScoutGroup } = useScoutGroup();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateScoutGroup();

const model = defineModel<boolean>();
const props = defineProps<{
  scoutGroup: ScoutGroupData;
}>();
const emit = defineEmits<{
  updated: [number];
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

async function submitUpdate() {
  if (scoutGroupInput.value === null) {
    return;
  }

  try {
    const scoutGroupId = await update({
      id: props.scoutGroup.id,
      ...scoutGroupInput.value,
    });

    if (scoutGroupId) {
      emit('updated', scoutGroupId);
    }

    createAlert({
      message: 'ScoutGroup updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update ScoutGroup.',
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
        <div>
          Update {{ scoutGroupInput?.firstname || props.scoutGroup.firstname }}
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ScoutGroupsDataForm
          v-model="scoutGroupInput"
          :current-scoutGroup="props.scoutGroup"
        ></ScoutGroupsDataForm>
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
