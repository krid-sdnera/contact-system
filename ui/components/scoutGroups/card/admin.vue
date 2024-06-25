<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

const props = defineProps<{
  scoutGroup: ScoutGroupData | null;
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
  <v-card v-if="props.scoutGroup">
    <ScoutGroupsDialogUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :scoutGroup="props.scoutGroup"
    ></ScoutGroupsDialogUpdate>

    <ScoutGroupsDialogDelete
      v-model="dialogDelete"
      @updated="itemDeleted"
      :scoutGroup="props.scoutGroup"
    ></ScoutGroupsDialogDelete>

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
