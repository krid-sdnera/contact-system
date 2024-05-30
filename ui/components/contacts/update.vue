<script setup lang="ts">
import type { ContactInput, ContactData } from '~/server/types/contact';

const { useUpdateContact } = useContact();
const { update, updated, loading, error, errorMessage, reset } =
  useUpdateContact();

const model = defineModel<boolean>();
const props = defineProps<{
  contact: ContactData;
}>();
const emit = defineEmits<{
  updated: [number];
}>();

const { createAlert } = useAlerts();
const { globalPending } = useApi();

const contactInput = ref<ContactInput | null>(null);

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
  if (contactInput.value === null) {
    return;
  }

  try {
    const contactId = await update({
      id: props.contact.id,
      ...contactInput.value,
    });

    if (contactId) {
      emit('updated', contactId);
    }

    createAlert({
      message: 'Contact updated.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to update Contact.',
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
          Update {{ contactInput?.firstname || props.contact.firstname }}
        </div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ContactsDataForm
          v-model="contactInput"
          :current-contact="props.contact"
        ></ContactsDataForm>
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
