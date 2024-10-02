<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

const model = defineModel<MemberData>();
const props = defineProps<{
  label: string;
  filter?: (member: MemberData) => boolean;
}>();

const { useListMembers } = useMember();

const { displayMembers, uiPageControls } = useListMembers();

const items = computed(() => {
  return displayMembers.value
    .filter((member) => {
      if (props.filter) {
        return props.filter(member);
      }
      return true;
    })
    .map((member) => ({
      title: `${member.firstname} ${member.lastname}`,
      subtitle: member.membershipNumber,
      value: member,
    }));
});

function handleSearchUpdate(search: any) {
  // From tip in https://vuetifyjs.com/en/components/autocompletes/#filter
  // > To prevent unnecessary API requests when querying,
  // > ensure that search is not empty and/or doesn’t match
  // > the current model.
  if (!search || search === uiPageControls.search.value) {
    return;
  }

  uiPageControls.updateOptions({
    page: 1,
    itemsPerPage: 10,
    sortBy: [],
    groupBy: {},
    search: search,
  });
}
</script>

<template>
  <v-autocomplete
    v-model="model"
    :label="props.label"
    :loading="uiPageControls.loading.value"
    :items="items"
    item-props
    :search="uiPageControls.search.value"
    @update:search="handleSearchUpdate"
    chips
    hide-details
    no-filter
  >
    <template v-slot:chip="{ props, item }">
      <v-chip
        v-bind="props"
        :text="`${item.value.firstname} ${item.value.lastname} (${item.value.membershipNumber})`"
      ></v-chip>
    </template>
    <template v-slot:no-data>
      <span v-if="uiPageControls.loading.value === true">
        Loading results...
      </span>
      <span v-else> No results for {{ uiPageControls.search }} </span>
    </template>
  </v-autocomplete>
</template>
