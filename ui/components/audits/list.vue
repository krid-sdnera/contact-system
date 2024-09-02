<script setup lang="ts">
import type { AuditData } from '~/server/types/audit';

const props = withDefaults(
  defineProps<{
    searchable?: boolean;
    trackParams?: boolean;
  }>(),
  {
    searchable: false,
    trackParams: false,
  }
);

const { useListAudits } = useAudit();
const { displayAudits, uiPageControls, refresh, loading, error, errorMessage } =
  useListAudits(undefined, props.trackParams);

const { $filters } = useNuxtApp();

const headers: TableControlsHeader[] = [
  { title: 'ID', key: 'id' },
  { title: 'Entity', key: 'entity', filterable: true },
  {
    title: 'Created At',
    key: 'createdAt',
    value: (item: AuditData) => $filters.datetime(new Date(item.createdAt)),
    filterable: true,
  },
  { title: 'Actor', key: 'actor', filterable: true },
  { title: 'Action', key: 'action', filterable: true },
  {
    title: 'Event',
    key: 'eventData',
    align: 'center',
  },
];
const { shownHeaders, useUiTableControls } = useTableControls(
  'auditListColumns',
  headers,
  [
    'entity', //wrap
    'createdAt',
    'actor',
    'action',
    'eventData',
  ]
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

type AuditAction = 'create' | 'update' | 'delete';
type EventDataSource = Record<string, { from: any; to: any } | string>;

type EventData<AA extends AuditAction> = AA extends 'create'
  ? Record<string, string>
  : AA extends 'update'
  ? Record<string, { from: any; to: any }>
  : AA extends 'delete'
  ? Record<string, string>
  : {};

function parseEventData<AA extends AuditAction>(
  eventData: string,
  action: AA
): EventData<AA> {
  try {
    const json = JSON.parse(eventData) as EventDataSource;

    if (!json) {
      return {} as EventData<AA>;
    }

    switch (action) {
      case 'create': {
        return json as EventData<AA>;
      }
      case 'update': {
        return json as EventData<AA>;
      }
      case 'delete': {
        return json as EventData<AA>;
      }
      default: {
        return {} as EventData<AA>;
      }
    }
  } catch {
    return {} as EventData<AA>;
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
      :search="uiPageControls.search.value"
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
            v-model="uiPageControls.search.value"
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

      <template v-slot:headers="{ columns, isSorted, getSortIcon, toggleSort }">
        <TableHeaderRow
          :header="{ columns, toggleSort, getSortIcon, isSorted }"
          :filters="uiPageControls.filters"
        ></TableHeaderRow>
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
        <v-row v-if="item.action === 'create'" dense>
          <v-col cols="8" offset="4" class="text-left">
            <input
              type="checkbox"
              :id="`audit-${item.id}-change-create`"
              class="audit-change-revealer"
            />
            <div class="change-block">
              <label :for="`audit-${item.id}-change-create`">
                <pre
                  class="text-green"
                  v-text="
                    `+ ${renderValue(
                      parseEventData(item.eventData, item.action)
                    )}`
                  "
                ></pre>
              </label>
            </div>
          </v-col>
        </v-row>

        <v-row
          v-else-if="item.action === 'update'"
          dense
          v-for="(change, field, index) in parseEventData(
            item.eventData,
            item.action
          )"
          :class="{ 'border-t-sm': index !== 0 }"
        >
          <v-col cols="4" class="text-right">{{ field }}</v-col>

          <v-col cols="8" class="text-left">
            <input
              type="checkbox"
              :id="`audit-${item.id}-change-${index}`"
              class="audit-change-revealer"
            />

            <div class="change-block">
              <label :for="`audit-${item.id}-change-${index}`">
                <pre
                  class="text-red"
                  v-text="`- ${renderValue(change?.from)}`"
                ></pre>
                <pre
                  class="text-green"
                  v-text="`+ ${renderValue(change?.to)}`"
                ></pre>
              </label>
            </div>
          </v-col>
        </v-row>

        <v-row v-else-if="item.action === 'delete'" dense>
          <v-col cols="8" offset="4" class="text-left">
            <input
              type="checkbox"
              :id="`audit-${item.id}-change-delete`"
              class="audit-change-revealer"
            />
            <div class="change-block">
              <label :for="`audit-${item.id}-change-delete`">
                <pre
                  class="text-red"
                  v-text="
                    `- ${renderValue(
                      parseEventData(item.eventData, item.action)
                    )}`
                  "
                ></pre>
              </label>
            </div>
          </v-col>
        </v-row>
      </template>

      <template v-slot:no-data>
        <v-btn color="primary" @click="refresh">No Data: Refresh</v-btn>
      </template>
    </v-data-table-server>
  </div>
</template>

<style lang="scss" scoped>
.change-block {
  max-height: 5rem;
  overflow: scroll;
  mask-image: linear-gradient(to bottom, black 90%, transparent 100%);
}

.audit-change-revealer {
  display: none;
}
.audit-change-revealer:checked ~ .change-block {
  max-height: 25rem;
  mask-image: linear-gradient(to bottom, black 95%, transparent 100%);
}
</style>
