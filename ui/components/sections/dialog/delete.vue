<script setup lang="ts">
import type { SectionInput, SectionData } from '~/server/types/section';

const { useDeleteSection } = useSection();
const { deleteFn, deleted, loading, error, errorMessage, reset } =
  useDeleteSection();

const model = defineModel<boolean>();
const props = defineProps<{
  section: SectionData;
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
    const sectionId = await deleteFn(props.section.id);

    if (sectionId) {
      emit('deleted', sectionId);
    }

    createAlert({
      message: 'Section deleted.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to delete Section.',
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
        <div>Delete {{ props.section.firstname }}?</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        You are about to delete "{{ props.section.firstname }}"<br />
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
