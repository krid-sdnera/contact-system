<script setup lang="ts">
import type { ContactData } from '~/server/types/contact';

const props = defineProps<{
  contact: ContactData | null;
}>();

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}

const dialogDelete = ref<boolean>(false);
function itemDelete() {
  dialogDelete.value = true;
}

usePostDeleteAction(
  () => props.contact,
  () => useRouter().push(`/contacts`)
);

const dialogStateChange = ref<boolean>(false);
function itemStateChange() {
  dialogStateChange.value = true;
}
function itemStateChanged(id: number) {
  dialogStateChange.value = false;
}
</script>

<template>
  <v-card v-if="props.contact">
    <ContactsDialogUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :contact="props.contact"
    ></ContactsDialogUpdate>

    <ContactsDialogStateChange
      v-model="dialogStateChange"
      @updated="itemStateChanged"
      :contact="props.contact"
    ></ContactsDialogStateChange>

    <ContactsDialogDelete
      v-model="dialogDelete"
      :contact="props.contact"
    ></ContactsDialogDelete>

    <v-card-title>Admin Actions</v-card-title>

    <v-card-text>
      <v-btn
        v-if="props.contact?.state === 'enabled'"
        @click="itemStateChange"
        color="green-darken-1"
      >
        Contact enabled
      </v-btn>
      <v-btn v-else @click="itemStateChange" color="red-darken-1">
        Contact disabled
      </v-btn>
    </v-card-text>

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        variant="tonal"
        icon="mdi-pencil"
        color="warning"
        @click="itemUpdate()"
      ></v-btn>
      <v-btn
        variant="tonal"
        icon="mdi-delete"
        color="error"
        @click="itemDelete()"
      ></v-btn>
    </v-card-actions>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
