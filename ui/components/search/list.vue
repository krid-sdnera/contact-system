<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

// const model = defineModel<string>({ required: true });
const props = defineProps<{}>();
const emit = defineEmits<{
  close: [];
}>();

const { useListMembers } = useMember();
const {
  displayMembers,
  uiPageControls: uiPageControlsMembers,
  refresh: refreshMembers,
  loading: loadingMembers,
  error: errorMembers,
  errorMessage: errorMessageMembers,
} = useListMembers();
const { useListContacts } = useContact();
const {
  displayContacts,
  uiPageControls: uiPageControlsContacts,
  refresh: refreshContacts,
  loading: loadingContacts,
  error: errorContacts,
  errorMessage: errorMessageContacts,
} = useListContacts();

function uiPageControlsCombiner(
  ...uiPageControls: UiPageControls[]
): UiPageControls {
  const totalItems = computed(() =>
    uiPageControls
      .map((upc) => Math.min(upc.pageSize.value, upc.totalItems.value))
      .reduce((acc, v) => acc + v, 0)
  );

  return {
    currentPage: computed(() => 1),
    pageSize: totalItems,
    sortBy: computed(() => []),
    search: computed({
      get: () => {
        return uiPageControls[0].search.value;
      },
      set: (newSearch) => {
        uiPageControls.forEach((upc) => (upc.search.value = newSearch));
      },
    }),
    filters: computed(() => ({} as Record<string, string | undefined>)),
    loading: computed(() => uiPageControls.some((upc) => upc.loading.value)),
    refresh: async () =>
      Promise.all(uiPageControls.map((upc) => upc.refresh())).then(() => {}),
    maxPages: computed(() => 1),
    totalItems: totalItems,
    updateOptions: (updateData) =>
      uiPageControls.map((upc) =>
        upc.updateOptions({
          page: 1,
          itemsPerPage: upc.pageSize.value,
          sortBy: updateData.sortBy,
          groupBy: updateData.groupBy,
          search: updateData.search,
        })
      ),
  };
}

const hasEmptySearch = computed(() => !Boolean(uiPageControls.search.value));

const uiPageControls = uiPageControlsCombiner(
  uiPageControlsMembers,
  uiPageControlsContacts
);
const refresh = async () => Promise.all([refreshMembers(), refreshContacts()]);
const loading = computed(
  () => !hasEmptySearch.value && (loadingMembers.value || loadingContacts.value)
);
const error = computed(() => errorMembers.value || errorContacts.value);
const errorMessage = computed(
  () => errorMessageMembers.value + errorMessageContacts.value
);

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  { title: 'Firstname', key: 'firstname' },
  { title: 'Nickname', key: 'nickname' },
  { title: 'Lastname', key: 'lastname' },
  { title: 'Membership Number', key: 'membershipNumber' },
  {
    title: 'Address',
    key: 'address',
    value: (item: MemberData) => $filters.address(item.address),
  },
  { title: 'Email', key: 'email' },
  { title: 'Home Phone', key: 'phoneHome' },
  { title: 'Mobile Phone', key: 'phoneMobile' },
  { title: 'Work Phone', key: 'phoneWork' },
  { title: 'Type', key: 'type' },
  { title: 'Actions', key: 'actionButtons', sortable: false },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'searchListColumns',
  headers,
  [
    'firstname', //wrap
    'lastname',
    'email',
    'gender',
    'membershipNumber',
  ]
);
const uiTableControls = useUiTableControls();
const tableControlDialog = ref<boolean>(false);

const displayItems = computed(() => {
  if (hasEmptySearch.value) {
    return [];
  }

  const arr = [];
  if (displayMembers.value) {
    arr.push(...displayMembers.value.map((x) => ({ ...x, type: 'member' })));
  }
  if (displayContacts.value) {
    arr.push(...displayContacts.value.map((x) => ({ ...x, type: 'contact' })));
  }

  return arr;
});

function close() {
  emit('close');
  uiPageControls.search.value = '';
}
</script>

<template>
  <div>
    <v-data-table-server
      :headers="shownHeaders"
      :items="displayItems"
      :loading="loading"
      v-model:items-per-page="uiPageControls.pageSize.value"
      :items-length="uiPageControls.totalItems.value"
      :search="uiPageControls.search.value"
      @update:options="uiPageControls.updateOptions"
    >
      <template v-slot:loading>
        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
      </template>
      <template v-slot:top>
        <v-toolbar>
          <v-text-field
            hide-details
            label="Search"
            class="mx-4"
            v-model="uiPageControls.search.value"
            autofocus
            variant="plain"
          ></v-text-field>

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>

          <v-btn icon="mdi-close" @click="close()"></v-btn>
        </v-toolbar>
      </template>

      <template v-slot:item.id="{ item }">
        <NuxtLink
          v-if="item.type === 'member'"
          :to="`/members/${item.id}`"
          @click="close()"
        >
          {{ item.id }}
        </NuxtLink>
        <NuxtLink
          v-if="item.type === 'contact'"
          :to="`/contacts/${item.id}`"
          @click="close()"
        >
          {{ item.id }}
        </NuxtLink>
      </template>

      <template v-slot:item.actionButtons="{ item }">
        <v-btn
          v-if="item.type === 'member'"
          variant="text"
          icon="mdi-eye"
          :to="`/members/${item.id}`"
          @click="close()"
        />
        <v-btn
          v-if="item.type === 'contact'"
          variant="text"
          icon="mdi-eye"
          :to="`/contacts/${item.id}`"
          @click="close()"
        />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="refresh">Start your search</v-btn>
      </template>

      <template v-slot:bottom>
        <div></div>
      </template>
    </v-data-table-server>
  </div>
</template>
