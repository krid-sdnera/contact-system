<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListRuleInput } from '~/server/types/listRule';

const { useCreateListRule } = useListRule();
const { create, created, loading, error, errorMessage, reset } =
  useCreateListRule();

const model = defineModel<boolean>();
const props = defineProps<{
  relation?: RuleRelationProp;
}>();
const emit = defineEmits<{
  created: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const listRuleInput = ref<ListRuleInput | null>(null);
const listRuleListInput = ref<ListData | null>(null);

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
  if (listRuleInput.value === null || listRuleListInput.value === null) {
    return;
  }

  console.log(listRuleInput.value);
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
    const listRuleId = await create(
      listRuleListInput.value.id,
      listRuleInput.value
    );

    if (listRuleId) {
      emit('created', listRuleId);
    }

    createAlert({
      message: 'ListRule created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create ListRule.',
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
        <div>Creating a new listRule</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ListRulesDataForm
          v-model="listRuleInput"
          v-model:list="listRuleListInput"
          :relation="props.relation"
        ></ListRulesDataForm>
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
