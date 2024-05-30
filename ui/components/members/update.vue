<script setup lang="ts">
import type { MemberInput, MemberData } from '~/server/types/member';

const { useUpdateMember } = useMember();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateMember();

const model = defineModel<boolean>();
const props = defineProps<{
  member: MemberData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const memberInput = ref<MemberInput | null>(null);

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
  if (memberInput.value === null) {
    return;
  }

  try {
    const memberId = await update({
      id: props.member.id,
      ...memberInput.value,
    });

    if (memberId) {
      emit('updated', memberId);
    }

    createAlert({
      message: 'Member updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update Member.',
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
        <div>Update {{ memberInput?.firstname || props.member.firstname }}</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <MembersDataForm
          v-model="memberInput"
          :current-member="props.member"
        ></MembersDataForm>
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
