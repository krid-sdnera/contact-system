<script setup lang="ts">
import type { ContactInput, ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';

const { useCreateContact } = useContact();
const { create, created, loading, error, errorMessage, reset } =
  useCreateContact();

const model = defineModel<boolean>();
const props = defineProps<{
  member?: MemberData;
}>();
const emit = defineEmits<{
  created: [number];
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

async function submitCreate() {
  if (contactInput.value === null) {
    return;
  }

  try {
    const contactId = await create(contactInput.value);

    if (contactId) {
      emit('created', contactId);
    }

    createAlert({
      message: 'Contact created.',
      type: 'success',
    });
    model.value = false;
  } catch (e) {
    console.error(e);
    createAlert({
      message: 'Failed to create Contact.',
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
        <div v-if="props.member">
          Creating a new contact for {{ props.member.firstname }}
        </div>
        <div v-else>Creating a new contact</div>
        <v-btn icon="mdi-close" variant="text" @click="close"></v-btn>
      </v-card-title>

      <v-card-text>
        <ContactsDataForm
          v-model="contactInput"
          :member="props.member"
        ></ContactsDataForm>
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
