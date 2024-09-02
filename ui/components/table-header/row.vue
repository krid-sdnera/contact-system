<script setup lang="ts">
const props = defineProps<{
  header: {
    columns: TableControlsHeader[];
    toggleSort: (column: TableControlsHeader) => void;
    getSortIcon: (column: TableControlsHeader) => string;
    isSorted: (column: TableControlsHeader) => boolean;
  };
  filters: Ref<Record<string, string | undefined>>;
}>();

const { columns, toggleSort, getSortIcon, isSorted } = props.header;
</script>

<template>
  <tr>
    <td v-for="column in props.header.columns" :key="column.key">
      <TableHeaderCell
        :header="{ column, toggleSort, getSortIcon, isSorted }"
        :filters="props.filters"
      ></TableHeaderCell>
    </td>
  </tr>
</template>
