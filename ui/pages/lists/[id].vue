<script setup lang="ts">
useHead({
  title: 'Lists',
});

definePageMeta({
  middleware: ['auth'],
  breadcrumbs: useBuildBreadcrumbs([
    { to: `/`, label: `Home` },
    { to: `/lists`, label: `Lists` },
    { to: ``, label: `Details` },
  ]),
  validate: async (route) => {
    if (Array.isArray(route.params.id)) {
      return false;
    }

    // Check if the id is made up of digits
    return /^\d+$/.test(route.params.id);
  },
});

const route = useRoute();
const listId = Number(
  Array.isArray(route.params.id) ? route.params.id[0] : route.params.id
);

const { useFetchList } = useList();
const { list, status } = useFetchList(listId);
</script>

<template>
  <div>
    <v-row>
      <v-col>
        <v-card v-if="list" color="yellow-darken-3">
          <OverridableTitle label="List">
            {{ list.name }}
          </OverridableTitle>
        </v-card>
        <v-skeleton-loader v-else type="heading"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row class="flex-row-reverse">
      <v-col cols="12" sm="3">
        <v-row>
          <v-col cols="12">
            <CardSectionJump
              :jumps="[
                { label: 'Rules', hash: '#list-rules' },
                { label: 'Recipients', hash: '#recipients' },
              ]"
            ></CardSectionJump>
          </v-col>
          <v-col cols="12">
            <ListsCardAdmin :list="list"></ListsCardAdmin>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="9">
        <v-row>
          <v-col cols="12" sm="6">
            <ListsCardDetails :list="list"></ListsCardDetails>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row id="list-rules">
      <v-col v-if="list">
        <!-- Rules Table -->
        <ListRulesList :list="list" searchable></ListRulesList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>

    <v-row id="recipients">
      <v-col v-if="list">
        <!-- Members Table -->
        <ListMembersList :list="list" searchable></ListMembersList>
      </v-col>
      <v-col v-else>
        <v-skeleton-loader type="table"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
</template>
