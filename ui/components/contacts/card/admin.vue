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
function itemDeleted(id: number) {
  dialogDelete.value = false;
}
</script>

<template>
  <v-card v-if="props.contact">
    <ContactsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :contact="props.contact"
    ></ContactsUpdate>

    <ContactsDelete
      v-model="dialogDelete"
      @updated="itemDeleted"
      :contact="props.contact"
    ></ContactsDelete>

    <v-card-title>Admin Actions</v-card-title>

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
