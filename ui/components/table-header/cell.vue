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
    <div class="d-flex flex-nowrap align-center flex-column">
      <template v-if="isSorted(column)">
        <v-icon :icon="getSortIcon(column)"></v-icon>
      </template>

      <template v-if="column.filterable">
        <TableHeaderCellFilter
          :column="column"
          :filters="props.filters"
        ></TableHeaderCellFilter>
      </template>
    </div>
  </div>
</template>
