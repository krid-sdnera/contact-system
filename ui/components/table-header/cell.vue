<script setup lang="ts">
const props = defineProps<{
  header: {
    column: TableControlsHeader;
    toggleSort: (column: TableControlsHeader) => void;
    getSortIcon: (column: TableControlsHeader) => string;
    isSorted: (column: TableControlsHeader) => boolean;
  };
  filters: Ref<Record<string, string | undefined>>;
}>();

const { column, toggleSort, getSortIcon, isSorted } = props.header;
</script>

<template>
  <div class="d-flex flex-nowrap align-center">
    <span class="mr-2 cursor-pointer" @click="() => toggleSort(column)">
      {{ column.title }}
    </span>
    <div class="d-flex flex-nowrap align-center">
      <v-icon
        v-if="column.sortable"
        :icon="isSorted(column) ? getSortIcon(column) : 'mdi-swap-vertical'"
        :color="isSorted(column) ? 'primary' : ''"
        @click="() => toggleSort(column)"
      ></v-icon>

      <TableHeaderCellFilter
        v-if="column.filterable"
        :column="column"
        :filters="props.filters"
      ></TableHeaderCellFilter>
    </div>
  </div>
</template>
