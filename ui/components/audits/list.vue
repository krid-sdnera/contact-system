<script setup lang="ts">
import type { AuditData } from '~/server/types/audit';

const props = withDefaults(
  defineProps<{
    searchable?: boolean;
  }>(),
  {
    searchable: false,
  }
);

const search = ref<string>('');

const { useListAudits } = useAudit();
const { displayAudits, uiPageControls, refresh, loading, error, errorMessage } =
  useListAudits(search, {});

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'Entity', key: 'entity' },
  {
    title: 'Created At',
    key: 'createdAt',
    value: (item: AuditData) => $filters.datetime(new Date(item.createdAt)),
  },
  { title: 'Actor', key: 'actor' },
  { title: 'Action', key: 'action' },
  {
    title: 'Event',
    key: 'eventData',
    align: 'center',
  },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'auditListColumns',
  headers,
  ['id', 'entity', 'createdAt', 'actor', 'action', 'eventData']
);
const uiTableControls = useUiTableControls();
const tableControlDialog = ref<boolean>(false);

const eventDataHeaders: TableControlsHeader[] = [
  { title: 'Field', key: 'field' },
  { title: 'From', key: 'from' },
  { title: 'To', key: 'to' },
];

const itemsPerPageOptions = [
  { value: 5, title: '5' },
  { value: 10, title: '10' },
  { value: 25, title: '25' },
  { value: 50, title: '50' },
  { value: 100, title: '100' },
];

function getActionColor(action: string): string {
  return (
    {
      create: 'green', // wrap
      update: 'orange',
      delete: 'red',
    }[action] ?? 'primary'
  );
}
type EventDataSource = Record<string, { from: any; to: any } | string>;

type EventData = Record<string, { from: any; to: any }>;

function parseEventData(eventData: string, action: string): EventData {
  try {
    const json = JSON.parse(eventData) as EventDataSource;

    if (!json) {
      return { empty: { from: '', to: '' } };
    }

    if (action === 'create' || action === 'delete') {
      const formattedJson: EventData = {};
      for (const field in json) {
        const change = json[field];

        formattedJson[field] = {
          from: action === 'delete' ? change : undefined,
          to: action === 'create' ? change : undefined,
        };
      }

      return formattedJson;
    }

    return json as EventData;
  } catch {
    return { error: { from: '', to: '' } };
  }
}

function renderValue(value: any): string {
  if (value === undefined) {
    return 'Empty';
  }
  if (value === null) {
    return 'Empty';
  }
  if (value === '') {
    return 'Empty';
  }

  if (typeof value === 'string') {
    return value;
  }
  if (typeof value === 'number') {
    return String(value);
  }
  if (typeof value === 'boolean') {
    return value ? 'True' : 'False';
  }

  if ('date' in value && 'timezone_type' in value && 'timezone' in value) {
    return String(value.date);
  }

  return JSON.stringify(value, replacerFn, 2);
}

/**
 * Display top level key, value pairs of JSON objects
 *
 * The top level object will have no key, so it's always simply returned.
 * Anything that is not a "number" on the next level will be casted to a string,
 * incl. a special case for arrays, otherwise those would be exposed further more.
 */
function replacerFn(k: string, v: any) {
  return k && v && typeof v !== 'number'
    ? Array.isArray(v)
      ? '[object Array]'
      : '' + v
    : v;
}
</script>

<template>
  <div>
    <v-data-table-server
      :headers="shownHeaders"
      :items="displayAudits"
      :loading="loading"
      v-model:items-per-page="uiPageControls.pageSize.value"
      :items-length="uiPageControls.totalItems.value"
      :search="search"
      :sort-by="uiPageControls.sortBy.value"
      @update:options="uiPageControls.updateOptions"
      :items-per-page-options="itemsPerPageOptions"
    >
      <template v-slot:loading>
        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Audits</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-text-field
            v-if="props.searchable"
            v-model="search"
            label="Find Audit"
            single-line
            hide-details
            clearable
            density="compact"
            class="mr-3"
          ></v-text-field>

          <v-btn icon="mdi-sync" v-tooltip="'Refresh'" @click="refresh"></v-btn>

          <TableControls
            v-model="tableControlDialog"
            :controls="uiTableControls"
          ></TableControls>
        </v-toolbar>
      </template>

      <template v-slot:item.entity="{ item }">
        <span>{{ item.entityType }}</span>
        <br />
        <NuxtLink
          v-if="relationLinkable(item.entityType)"
          :to="relationUrl(item.entityType, item.entityId)"
        >
          {{ item.entityId }}
        </NuxtLink>
        <span v-else> {{ item.entityId }} </span>
      </template>
      <template v-slot:item.actor="{ item }">
        <div>User: {{ item.user?.username }} IP: {{ item.ipAddress }}</div>
        <div>
          Route: {{ item.requestRoute?.replace('open_api_server_', '') }}
        </div>
      </template>
      <template v-slot:item.action="{ item }">
        <v-chip :color="getActionColor(item.action)">
          {{ item.action }}
        </v-chip>
      </template>

      <template v-slot:item.eventData="{ item }">
        <v-row
          dense
          v-for="(change, field, index) in parseEventData(
            item.eventData,
            item.action
          )"
          :class="{ 'border-t-sm': index !== 0 }"
        >
          <v-col cols="4" class="text-right">{{ field }}</v-col>

          <v-col cols="8" class="text-left change-block">
            <pre
              class="text-red"
              v-if="item.action !== 'create'"
              v-text="`- ${renderValue(change?.from)}`"
            ></pre>
            <pre
              class="text-green"
              v-if="item.action !== 'delete'"
              v-text="`+ ${renderValue(change?.to)}`"
            ></pre>
          </v-col>
        </v-row>
      </template>

      <template v-slot:no-data>
        <v-btn color="primary"> No Data? </v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>

<style lang="scss" scoped>
.change-block {
  max-height: 5rem;
  overflow: scroll;
  mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
}
</style>
