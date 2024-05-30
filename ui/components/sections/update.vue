<script setup lang="ts">
import type { SectionInput, SectionData } from '~/server/types/section';

const { useUpdateSection } = useSection();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateSection();

const model = defineModel<boolean>();
const props = defineProps<{
  section: SectionData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const sectionInput = ref<SectionInput | null>(null);

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
  if (sectionInput.value === null) {
    return;
  }

  try {
    const sectionId = await update({
      id: props.section.id,
      ...sectionInput.value,
    });

    if (sectionId) {
      emit('updated', sectionId);
    }

    createAlert({
      message: 'Section updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update Section.',
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
          Update {{ sectionInput?.firstname || props.section.firstname }}
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <SectionsDataForm
          v-model="sectionInput"
          :current-section="props.section"
        ></SectionsDataForm>
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
