<script setup lang="ts">
const props = defineProps<{
  view?: boolean | string;
  update?: boolean | string;
  clone?: boolean | string;
  delete?: boolean | string;
}>();

const emit = defineEmits<{
  view: [];
  update: [];
  clone: [];
  delete: [];
}>();
</script>

<template>
  <div class="action-buttons d-flex flex-nowrap">
    <v-btn
      v-if="props.view"
      variant="text"
      icon="mdi-eye"
      :to="typeof props.view === 'string' ? props.view : undefined"
      @click="emit('view')"
    />
    <v-btn
      v-if="props.update"
      variant="text"
      icon="mdi-pencil"
      color="warning"
      :to="typeof props.update === 'string' ? props.update : undefined"
      @click="emit('update')"
    />
    <v-btn
      v-if="props.clone"
      variant="text"
      icon="mdi-plus-circle-multiple-outline"
      color="purple"
      :to="typeof props.clone === 'string' ? props.clone : undefined"
      @click="emit('clone')"
    />
    <v-btn
      v-if="props.delete"
      variant="text"
      icon="mdi-delete"
      color="error"
      :to="typeof props.delete === 'string' ? props.delete : undefined"
      @click="emit('delete')"
    />
  </div>
</template>
