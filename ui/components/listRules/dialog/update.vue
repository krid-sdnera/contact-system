<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListRuleInput, ListRuleData } from '~/server/types/listRule';

const { useUpdateListRule } = useListRule();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateListRule();

const model = defineModel<boolean>();
const props = defineProps<{
  listRule: ListRuleData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const listRuleInput = ref<ListRuleInput | null>(null);

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
  if (listRuleInput.value === null) {
    return;
  }

  if (
    listRuleInput.value.useMember === false &&
    listRuleInput.value.useContact === false
  ) {
    createAlert({
      message: '"Use Member" or "Use Contact" must be selected.',
      type: 'warning',
    });
    return;
  }

  try {
    const listRuleId = await update({
      id: props.listRule.id,
      listId: props.listRule.listId,
      ...listRuleInput.value,
    });

    if (listRuleId) {
      emit('updated', listRuleId);
    }

    createAlert({
      message: 'ListRule updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update ListRule.',
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
          Update {{ listRuleInput?.firstname || props.listRule.firstname }}
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ListRulesDataForm
          v-model="listRuleInput"
          :current-listRule="props.listRule"
        ></ListRulesDataForm>
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
