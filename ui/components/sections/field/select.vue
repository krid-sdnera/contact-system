<script setup lang="ts">
import type { SectionData } from '~/server/types/section';

const model = defineModel<SectionData>();
const props = defineProps<{
  filter?: (section: SectionData) => boolean;
}>();

const { sections, useListAllSections } = useSection();

const { status } = useListAllSections();

const items = computed(() => {
  if (status.value !== 'success') {
    return [];
  }

  return Object.values(sections.value)
    .filter((section) => {
      if (props.filter) {
        return props.filter(section);
      }
      return true;
    })
    .map((section) => ({
      title: section.name,
      subtitle: section.scoutGroup.name,
      value: section,
    }));
});
</script>

<template>
  <v-select
    v-model="model"
    label="Section"
    :loading="status !== 'success'"
    :items="items"
    item-props
    :color="items.length == 0 ? 'error' : ''"
  ></v-select>
</template>
