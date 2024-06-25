<script setup lang="ts">
import type { ListInput, ListData } from '~/server/types/list';

const { useUpdateList } = useList();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateList();

const model = defineModel<boolean>();
const props = defineProps<{
  list: ListData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const listInput = ref<ListInput | null>(null);

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
  if (listInput.value === null) {
    return;
  }

  try {
    const listId = await update({
      id: props.list.id,
      ...listInput.value,
    });

    if (listId) {
      emit('updated', listId);
    }

    createAlert({
      message: 'List updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update List.',
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
          Update {{ listInput?.name || props.list.name }} ({{
            listInput?.address || props.list.address
          }})
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ListsDataForm
          v-model="listInput"
          :current-list="props.list"
        ></ListsDataForm>
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
