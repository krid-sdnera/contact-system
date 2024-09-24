<script setup lang="ts">
import type { RoleData } from '~/server/types/role';

const props = defineProps<{
  role: RoleData | null;
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
  () => props.role,
  () => useRouter().push(`/roles`)
);
</script>

<template>
  <v-card v-if="props.role">
    <RolesDialogUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :role="props.role"
    ></RolesDialogUpdate>

    <RolesDialogDelete
      v-model="dialogDelete"
      :role="props.role"
    ></RolesDialogDelete>

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
