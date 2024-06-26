<script setup lang="ts">
import {
  type ContactData,
  ContactInputStateEnum,
} from '~/server/types/contact';

const { usePatchContact } = useContact();
const { patch, patched, loading, error, errorMessage, reset } =
  usePatchContact();

const model = defineModel<boolean>();
const props = defineProps<{
  contact: ContactData;
}>();
const emit = defineEmits<{
  patched: [number];
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

async function submitPatch() {
  // Cache the isEnabled value so we can use it for comparison after
  // the contact is created and the underlying state is update.
  const isEnabledCached = unref(isEnabled);

  try {
    const contactId = await patch({
      id: props.contact.id,
      state: isEnabledCached
        ? ContactInputStateEnum.Disabled
        : ContactInputStateEnum.Enabled,
    });

    if (contactId) {
      emit('patched', contactId);
    }

    createAlert({
      message: `Contact ${isEnabledCached ? 'disabled' : 'enabled'}.`,
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: `Failed to ${isEnabledCached ? 'disable' : 'enable'} Contact.`,
      type: 'error',
    });
  }
}

const disableBtn = computed(
  () => globalPending.value || loading.value || patched.value
);

const isEnabled = computed(() => props.contact.state === 'enabled');
</script>

<template>
  <v-dialog v-model="model" persistent scrollable max-width="600px">
    <v-card style="height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>
          {{ isEnabled ? 'Disable' : 'Enable' }}
          {{ props.contact.firstname }}?
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        You are about to {{ isEnabled ? 'disable' : 'enable' }} "{{
          props.contact.firstname
        }}"<br />
        Are you sure you wish to continue?
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="disableBtn" color="error" @click="close">
          Cancel
        </v-btn>
        <v-btn :disabled="disableBtn" color="primary" @click="submitPatch">
          {{ isEnabled ? 'Disable' : 'Enable' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
