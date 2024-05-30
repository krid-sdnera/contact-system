<script setup lang="ts">
const model = defineModel<boolean>();
const props = defineProps<{
  controls: UiTableControls;
}>();
</script>

<template>
  <v-dialog v-model="model" scrollable max-width="600px">
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn v-bind="activatorProps" icon="mdi-cog"></v-btn>
    </template>
    <v-card style="max-height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>Table Options</div>
        <v-btn icon="mdi-close" variant="text" @click="model = false"></v-btn>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row dense>
            <v-col
              cols="6"
              md="6"
              sm="12"
              v-for="column in props.controls.availableColumns"
            >
              <v-checkbox
                v-model="props.controls.columnDisplayMap.value[column.key]"
                :label="column.title"
                hide-details
                density="compact"
              >
              </v-checkbox>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
