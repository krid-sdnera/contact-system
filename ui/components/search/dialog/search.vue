<script setup lang="ts">
const dialog = ref<boolean>(false);

function close() {
  dialog.value = false;
}
</script>

<template>
  <div>
    <v-btn @click="dialog = true" prepend-icon="mdi-magnify" variant="tonal">
      Search
    </v-btn>

    <v-dialog
      content-class="dialog-position-top"
      v-model="dialog"
      :location="'top'"
      min-height="50vh"
    >
      <v-card>
        <v-card-text>
          <SearchList @close="close()"></SearchList>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped>
:deep(.dialog-position-top) {
  align-self: flex-start;
}
</style>
