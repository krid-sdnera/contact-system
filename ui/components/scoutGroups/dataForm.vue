<script setup lang="ts">
import type {
  ScoutGroupInput,
  ScoutGroupData,
} from '~/server/types/scoutGroup';

const model = defineModel<ScoutGroupInput | null>();
const props = defineProps<{
  currentScoutGroup?: ScoutGroupData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalScoutGroupData(props.currentScoutGroup);
});

function buildInternalScoutGroupData(
  currentScoutGroup?: ScoutGroupData
): ScoutGroupInput {
  if (currentScoutGroup) {
    return {
      name: currentScoutGroup.name,
      externalId: currentScoutGroup.externalId,
    };
  } else {
    return {
      name: '',
      externalId: '',
    };
  }
}
</script>

<template>
  <v-container v-if="model">
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
