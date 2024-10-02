<script setup lang="ts">
import type { RoleInput, RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const model = defineModel<RoleInput | null>();
const props = defineProps<{
  currentRole?: RoleData;
  section?: SectionData;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalRoleData(props.currentRole);
});

function buildInternalRoleData(currentRole?: RoleData): RoleInput {
  if (currentRole) {
    return {
      name: currentRole.name,
      externalId: currentRole.externalId,
      classId: currentRole.classId,
      normalisedClassId: currentRole.normalisedClassId,
      sectionId: currentRole.section.id,
    };
  } else {
    return {
      name: '',
      externalId: '',
      classId: '',
      normalisedClassId: '',
      sectionId: props.section?.id ?? 0,
    };
  }
}

const showSectionIdSelect = computed(() => {
  if (props.section?.id) {
    // Section record was provided during creation.
    return false;
  }
  if (props.currentRole?.section.id) {
    // Current Role record was provided for updating.
    return false;
  }

  // Assuming we are creating a role without a provided section.
  return true;
});

const sectionSelectModel = ref<SectionData | null>(null);
if (showSectionIdSelect.value === true) {
  watch(sectionSelectModel, () => {
    if (!model.value) {
      return;
    }

    model.value.sectionId = sectionSelectModel.value?.id ?? 0;
  });
}
</script>

<template>
  <v-container v-if="model">
    <v-row>
      <!-- Section -->
      <v-col v-if="showSectionIdSelect">
        <SectionsFieldSelect v-model="sectionSelectModel"></SectionsFieldSelect>
      </v-col>
      <v-col v-else>
        Linked with
        {{ props.section?.name ?? props.currentRole?.section.name }}
      </v-col>
    </v-row>

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

    <DataFormFieldset legend="Unique Identifiers">
      <v-row>
        <v-col>
          <!-- Explaination Header -->
          <p class="mb-6">
            These fields are used to track this role against an extranet record.
            They are not needed local roles.
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

      <v-row>
        <v-col>
          <!-- Class ID -->
          <v-text-field
            v-model="model.classId"
            label="Class ID"
            type="text"
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <!-- Normalised Class ID -->
          <v-text-field
            v-model="model.normalisedClassId"
            label="Normalised Class ID"
            type="text"
          ></v-text-field>
        </v-col>
      </v-row>
    </DataFormFieldset>

    <small>*indicates required field</small>
  </v-container>
</template>
