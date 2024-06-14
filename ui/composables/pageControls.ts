import { useStorage } from '@vueuse/core';

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

  return {
    currentPage,
    apiSortBy: computed(() => {
      if (!sortBy.value) {
        return '';
      }

      const sort = sortBy.value;
      if (sort.length < 1) {
        return '';
      }

      // TODO: Support multiple orders? API doesnt support it yet.
      return `${sort[0].key}:${sort[0].order}`;
    }),
    pageSize,
    useUiPageControls(opts: {
      status: Ref<AsyncDataRequestStatus>;
      refresh: (opt?: AsyncDataExecuteOptions) => Promise<void>;
      maxPages: ComputedRef<number>;
      totalItems: ComputedRef<number>;
    }): UiPageControls {
      const loading = computed<boolean>(() => opts.status.value === 'pending');

      return {
        currentPage,
        pageSize,
        sortBy: sortBy,
        loading,
        refresh: opts.refresh,
        maxPages: opts.maxPages,
        totalItems: opts.totalItems,
        // // If current page is 5, allow user to jump back 5 pages.
        // hasPrevFivePage: computed(
        //   () => !loading.value && 5 <= currentPage.value
        // ),
        // // If current page is 2, allow user to go back 1 page.
        // hasPrevPage: computed(() => !loading.value && 2 <= currentPage.value),
        // // If current page is 1 less than max, allow user to go forward 1 page.
        // hasNextPage: computed(
        //   () => !loading.value && currentPage.value <= opts.maxPages.value - 1
        // ),
        // // If current page is 5 less than max, allow user to go forward 5 pages.
        // hasNextFivePage: computed(
        //   () => !loading.value && currentPage.value <= opts.maxPages.value - 5
        // ),
        // changePage(delta: number) {
        //   currentPage.value += delta;
        // },
        updateOptions(update) {
          currentPage.value = update.page;
          sortBy.value = update.sortBy;
          // update.itemsPerPage not reqired to update as it is already v-model'ed.

          // TODO Group by

          opts.refresh();
        },
      };
    },
  };
};

export interface UiPageControls {
  currentPage: Ref<number>;
  pageSize: Ref<number>;
  sortBy: Ref<SortBy[]>;
  loading: ComputedRef<boolean>;
  refresh: (opt?: AsyncDataExecuteOptions) => Promise<void>;
  maxPages: ComputedRef<number>;
  totalItems: Ref<number>;
  // hasPrevFivePage: ComputedRef<boolean>;
  // hasPrevPage: ComputedRef<boolean>;
  // hasNextPage: ComputedRef<boolean>;
  // hasNextFivePage: ComputedRef<boolean>;
  // changePage: (delta: number) => void;
  updateOptions: (update: {
    page: number;
    itemsPerPage: number;
    sortBy: SortBy[];
    groupBy: any;
    search: any;
  }) => void;
}
