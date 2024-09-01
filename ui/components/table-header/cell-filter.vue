<script setup lang="ts">
const { column, filters } = defineProps<{
  column: TableControlsHeader;
  filters: Ref<Record<string, string | undefined>>;
}>();
const filterValue = ref<string>('');

watch(
  filters,
  () => {
    filterValue.value = filters.value[column.key] ?? '';
  },
  { immediate: true, deep: true }
);

const menuOpen = ref<boolean>(false);
function submit() {
  menuOpen.value = false;
  filters.value[column.key] = filterValue.value;
}
function reset() {
  menuOpen.value = false;
  filterValue.value = '';
  filters.value[column.key] = undefined;
}
</script>

<template>
  <v-menu v-model="menuOpen" offset-y :close-on-content-click="false">
    <template v-slot:activator="{ props }">
      <v-btn
        icon="mdi-filter"
        variant="text"
        size="x-small"
        :color="filterValue ? 'primary' : ''"
        v-bind="props"
      ></v-btn>
    </template>
    <v-card width="400" elevation="10" variant="outlined" color="light-blue">
      <v-card-text class="pb-0">
        <v-text-field
          v-model="filterValue"
          type="text"
          :label="`Filter '${column?.title}' by`"
          :autofocus="true"
          hide-details
          v-on:keyup.enter="submit()"
        ></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="submit()" color="success">Filter</v-btn>
        <v-btn @click="reset()" color="error">Reset</v-btn>
      </v-card-actions>
    </v-card>
  </v-menu>
</template>
