<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';

const model = defineModel<ScoutGroupData>();
const props = defineProps<{
  filter?: (scoutgroup: ScoutGroupData) => boolean;
}>();

const { scoutGroups, useListAllScoutGroups } = useScoutGroup();

const { status } = useListAllScoutGroups();

const items = computed(() => {
  if (status.value !== 'success') {
    return [];
  }

  return Object.values(scoutGroups.value)
    .filter((scoutGroup) => {
      if (props.filter) {
        return props.filter(scoutGroup);
      }
      return true;
    })
    .map((scoutGroup) => ({
      title: scoutGroup.name,
      value: scoutGroup,
    }));
});
</script>

<template>
  <v-select
    v-model="model"
    label="Scout Group"
    :loading="status !== 'success'"
    :items="items"
    item-props
    :color="items.length == 0 ? 'error' : ''"
  ></v-select>
</template>
