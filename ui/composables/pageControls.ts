import {
  useDebounceFn,
  useStorage,
  useUrlSearchParams,
  type PromisifyFn,
} from '@vueuse/core';
import type { LocationQueryValue } from 'vue-router';

interface AsyncDataExecuteOptions {
  _initial?: boolean;
  dedupe?: boolean | 'cancel' | 'defer';
}

interface SortBy {
  key: string;
  order: 'asc' | 'desc';
}

export const usePageControls = (defaults?: { sortBy?: SortBy[] }) => {
  const currentPage = ref(1);
  const pageSize = useStorage<number>('pageSize', 10);
  const sortBy = ref<SortBy[]>(defaults?.sortBy ?? []);
  const search = ref<string>('');
  const filters = ref<Record<string, string | undefined>>({});

  return {
    currentPage,
    pageSize,
    apiSortBy: computed(() => ApiSort.encode(sortBy.value)),
    apiQuery: computed(() => ApiQuery.encode(search.value, filters.value)),
    useUiPageControls(opts: {
      status: Ref<AsyncDataRequestStatus>;
      refresh: RefreshFn;
      maxPages: ComputedRef<number>;
      totalItems: ComputedRef<number>;
    }): UiPageControls {
      const loading = computed<boolean>(() => opts.status.value === 'pending');

      const { refreshDebounced } = configureSyncRefsAndParams(
        { currentPage, pageSize, sortBy, search, filters },
        opts.refresh
      );

      return {
        currentPage,
        pageSize,
        sortBy,
        search,
        filters,
        loading,
        refresh: refreshDebounced,
        maxPages: opts.maxPages,
        totalItems: opts.totalItems,
        updateOptions(update) {
          currentPage.value = update.page;
          sortBy.value = update.sortBy;
          search.value = update.search;
          // update.itemsPerPage not reqired to update as it is already v-model'ed.

          // TODO Group by

          refreshDebounced();
        },
      };
    },
  };
};

export interface UiPageControls {
  currentPage: Ref<number>;
  pageSize: Ref<number>;
  sortBy: Ref<SortBy[]>;
  search: Ref<string>;
  filters: Ref<Record<string, string | undefined>>;
  loading: ComputedRef<boolean>;
  refresh: PromisifyFn<RefreshFn>;
  maxPages: ComputedRef<number>;
  totalItems: Ref<number>;
  updateOptions: (update: {
    page: number;
    itemsPerPage: number;
    sortBy: SortBy[];
    groupBy: any;
    search: any;
  }) => void;
}

interface TrackableRefsAndParams {
  currentPage: Ref<number>;
  pageSize: Ref<number>;
  sortBy: Ref<SortBy[]>;
  search: Ref<string>;
  filters: Ref<Record<string, string | undefined>>;
}

type RefreshFn = (opt?: AsyncDataExecuteOptions) => Promise<void>;

const paramToString = (value: LocationQueryValue | LocationQueryValue[]) =>
  Array.isArray(value) ? value[0] : value;

function configureSyncRefsAndParams(
  { currentPage, pageSize, sortBy, search, filters }: TrackableRefsAndParams,
  refresh: RefreshFn
): { refreshDebounced: PromisifyFn<RefreshFn> } {
  const refreshDebounced = useDebounceFn(refresh, 1000, { maxWait: 5000 });

  let updatingParmsLock = false;

  const route = useRoute();

  function urlParamsToRefs() {
    if (updatingParmsLock) {
      return;
    }

    if (route.query.page) {
      currentPage.value = Number(paramToString(route.query.page) ?? 1);
    } else {
      currentPage.value = 1;
    }

    if (route.query.size) {
      pageSize.value = Number(paramToString(route.query.size) ?? 10);
    } else {
      // pageSize.value = 1;
    }

    if (route.query.sort) {
      sortBy.value = ApiSort.decode(paramToString(route.query.sort));
    } else {
      sortBy.value = [];
    }

    if (route.query.search) {
      search.value = paramToString(route.query.search) ?? '';
    } else {
      search.value = '';
    }

    const ignoreKeys = ['page', 'size', 'sort', 'search'];

    const originalKeys = Object.keys(filters.value).filter(
      (key) => !ignoreKeys.includes(key)
    );
    const newKeys = Object.keys(route.query).filter(
      (key) => !ignoreKeys.includes(key)
    );

    for (const key of newKeys) {
      const value = paramToString(route.query[key]);
      filters.value[key] = value ?? undefined;
    }

    const originalKeysNotInNew = originalKeys.filter(
      (key) => !newKeys.includes(key)
    );

    for (const key of originalKeysNotInNew) {
      filters.value[key] = undefined;
    }

    refreshDebounced();
  }

  function refsToUrlParams() {
    updatingParmsLock = true;
    const urlParams = useUrlSearchParams('history');
    urlParams.page = String(currentPage.value);
    urlParams.size = String(pageSize.value);
    urlParams.sort = ApiSort.encode(sortBy.value);
    urlParams.search = search.value;
    Object.entries(filters.value).forEach(([key, value]) => {
      if (!value) {
        delete urlParams[key];
        return;
      }

      urlParams[key] = value ?? '';
    });
    updatingParmsLock = false;

    refreshDebounced();
  }

  watch(() => route.fullPath, urlParamsToRefs, { immediate: true });
  watch([currentPage, pageSize, sortBy, search, filters], refsToUrlParams, {
    deep: true,
  });

  return {
    refreshDebounced,
  };
}

class ApiSort {
  static encode(data: SortBy[]): string {
    if (!data) {
      return '';
    }

    if (data.length < 1) {
      return '';
    }

    return data.map((s) => `${s.key}:${s.order}`).join(',');
  }
  static decode(data: string | null): SortBy[] {
    if (!data) {
      return [];
    }

    const parts = data.split(',');

    return parts.map((part) => {
      const sortParts = part.split(':', 2);
      return {
        key: sortParts[0],
        order: sortParts[0] === 'desc' ? 'desc' : 'asc',
      };
    });
  }
}

interface ApiQueryData {
  search?: string;
  filters?: Record<string, string | number | boolean | undefined>;
}

class ApiQuery {
  static encode(search: string, filters: Record<string, string | undefined>) {
    const query: ApiQueryData = {};
    const hasSearch = Boolean(search);
    const hasFilters = Object.keys(filters).length > 0;

    if (hasSearch && !hasFilters) {
      // Search is only present, send as plain string.
      return search;
    }

    // Build query object.
    if (hasSearch) {
      query.search = search;
    }
    if (hasFilters) {
      query.filters = filters;
    }

    return JSON.stringify(query);
  }
}
