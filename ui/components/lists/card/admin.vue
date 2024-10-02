<script setup lang="ts">
import type { ListData } from '~/server/types/list';

const props = defineProps<{
  list: ListData | null;
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
  () => props.list,
  () => useRouter().push(`/lists`)
);
</script>

<template>
  <v-card v-if="props.list">
    <ListsDialogUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :list="props.list"
    ></ListsDialogUpdate>

    <ListsDialogDelete
      v-model="dialogDelete"
      :list="props.list"
    ></ListsDialogDelete>

    <v-card-title>Admin Actions</v-card-title>

    <v-divider></v-divider>

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
