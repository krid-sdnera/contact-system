<script setup lang="ts">
import type { SectionData } from '~/server/types/section';

const props = defineProps<{
  section: SectionData | null;
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
  () => props.section,
  () => useRouter().push(`/sections`)
);
</script>

<template>
  <v-card v-if="props.section">
    <SectionsDialogUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :section="props.section"
    ></SectionsDialogUpdate>

    <SectionsDialogDelete
      v-model="dialogDelete"
      :section="props.section"
    ></SectionsDialogDelete>

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
