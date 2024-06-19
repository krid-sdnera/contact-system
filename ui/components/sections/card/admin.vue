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
function itemDeleted(id: number) {
  dialogDelete.value = false;
}
</script>

<template>
  <v-card v-if="props.section">
    <SectionsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :section="props.section"
    ></SectionsUpdate>

    <SectionsDelete
      v-model="dialogDelete"
      @updated="itemDeleted"
      :section="props.section"
    ></SectionsDelete>

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
