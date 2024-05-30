<script setup lang="ts">
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { SectionInput, SectionData } from '~/server/types/section';

const model = defineModel<SectionInput | null>();
const props = defineProps<{
  currentSection?: SectionData;
  scoutGroup?: ScoutGroupData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalSectionData(props.currentSection);
});

function buildInternalSectionData(currentSection?: SectionData): SectionInput {
  if (currentSection) {
    return {
      name: currentSection.name,
      externalId: currentSection.externalId,
      scoutGroupId: currentSection.scoutGroup.id,
    };
  } else {
    return {
      name: '',
      externalId: '',
      scoutGroupId: props.scoutGroup?.id ?? 0,
    };
  }
}

const showScoutGroupIdSelect = computed(() => {
  if (props.scoutGroup?.id) {
    // ScoutGroup record was provided during creation.
    return false;
  }
  if (props.currentSection?.scoutGroup.id) {
    // Current Section record was provided for updating.
    return false;
  }

  // Assuming we are creating a section without a provided scoutgroup.
  return true;
});
</script>

<template>
  <v-container v-if="model">
    <v-row>
      <!-- Scout Group -->
      <v-text-field
        v-if="showScoutGroupIdSelect"
        v-model="model.scoutGroupId"
        label="Scout Group (TODO: Make a search box)"
        type="text"
      ></v-text-field>
      <v-col v-else>
        Linked with
        {{
          props.scoutGroup?.name ??
          `Scout Group #${props.currentSection?.scoutGroup.name}`
        }}
      </v-col>
    </v-row>

    <v-row>
      <!-- Name -->
      <v-text-field
        v-model="model.name"
        label="Name"
        type="text"
      ></v-text-field>
    </v-row>

    <v-row>
      <!-- External ID -->
      <v-text-field
        v-model="model.externalId"
        label="External ID"
        type="text"
      ></v-text-field>
    </v-row>
    <small>*indicates required field</small>
  </v-container>
</template>
