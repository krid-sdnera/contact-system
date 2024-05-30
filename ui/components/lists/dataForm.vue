<script setup lang="ts">
import type { ListInput, ListData } from '~/server/types/list';

const model = defineModel<ListInput | null>();
const props = defineProps<{
  currentList?: ListData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalListData(props.currentList);
});

function buildInternalListData(currentList?: ListData): ListInput {
  if (currentList) {
    return {
      address: currentList.address,
      name: currentList.name,
    };
  } else {
    return {
      address: '',
      name: '',
    };
  }
}
</script>

<template>
  <v-container v-if="model">
    <v-row>
      <!-- Address -->
      <v-text-field
        v-model="model.address"
        label="Address"
        type="text"
      ></v-text-field>
    </v-row>
    <v-row>
      <!-- Name -->
      <v-text-field
        v-model="model.name"
        label="Name"
        type="text"
      ></v-text-field>
    </v-row>
    <small>*indicates required field</small>
  </v-container>
</template>
