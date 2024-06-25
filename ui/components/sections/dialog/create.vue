<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { SectionInput, SectionData } from '~/server/types/section';

const { useCreateSection } = useSection();
const { create, created, loading, error, errorMessage, reset } =
  useCreateSection();

const model = defineModel<boolean>();
const props = defineProps<{
  scoutGroup?: ScoutGroupData;
}>();
const emit = defineEmits<{
  created: [number];
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

async function submitCreate() {
  if (sectionInput.value === null) {
    return;
  }

  try {
    const sectionId = await create(sectionInput.value);

    if (sectionId) {
      emit('created', sectionId);
    }

    createAlert({
      message: 'Section created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create Section.',
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
        <div>Creating a new section</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <SectionsDataForm
          v-model="sectionInput"
          :scoutGroup="props.scoutGroup"
        ></SectionsDataForm>
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
