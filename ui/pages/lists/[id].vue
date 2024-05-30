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

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}
</script>

<template>
  <div v-if="list && status === 'success'">
    <ListsUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :list="list"
    ></ListsUpdate>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <!-- List Details -->
        <v-card class="mb-6">
          <OverridableTitle label="List">
            {{ list.name }}
          </OverridableTitle>

          <v-card-text>
            <OverridableText label="Address">
              {{ list.address }}
            </OverridableText>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-pencil" @click="itemUpdate()"></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Rules Table -->
        <ListRulesList :list="list" searchable></ListRulesList>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Members Table -->
        <ListMembersList :list="list" searchable></ListMembersList>
      </v-col>
    </v-row>
  </div>
  <div v-else-if="status === 'pending'">
    <!-- Skeletons -->
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article" class="mb-6"></v-skeleton-loader>
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-col>
    </v-row>
  </div>
  <div v-else>{{ status }}</div>
  <!-- <error-display v-else :error="'unknown''"></error-display> -->
</template>
