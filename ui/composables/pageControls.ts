import { useStorage } from '@vueuse/core';

interface AsyncDataExecuteOptions {
  _initial?: boolean;
  dedupe?: boolean | 'cancel' | 'defer';
}

export const usePageControls = () => {
  const currentPage = ref(1);
  const pageSize = useStorage<number>('pageSize', 10);

  return {
    currentPage,
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
          // update.itemsPerPage not reqired to update as it is already v-model'ed.

          // TODO Sort
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
    sortBy: any;
    groupBy: any;
    search: any;
  }) => void;
}
