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
      <v-col>
        <!-- Name -->
        <v-text-field
          v-model="model.name"
          label="Name"
          type="text"
        ></v-text-field>
      </v-col>
    </v-row>
    <DataFormFieldset legend="Unique Identifier" variant="outlined">
      <v-row>
        <v-col>
          <!-- Explaination Header -->
          <p class="mb-6">
            This field is used to track this scout group against an extranet
            record. It is not needed for local scout groups.
          </p>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <!-- External ID -->
          <v-text-field
            v-model="model.externalId"
            label="External ID"
            type="text"
          ></v-text-field>
        </v-col>
      </v-row>
    </DataFormFieldset>
    <small>*indicates required field</small>
  </v-container>
</template>
