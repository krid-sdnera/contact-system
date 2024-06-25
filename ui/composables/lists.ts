import type { ListData, ListInput } from '~/server/types/list';
import { usePageControls } from './pageControls';

interface FetchListComposable {
  list: ComputedRef<ListData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchListComposable: Record<string, FetchListComposable> = {};

export const useList = () => {
  const listsState = useState<Record<string, ListData>>('lists', () => ({}));

  return {
    lists: listsState,
    getList(id: number): ComputedRef<ListData | null> {
      return computed(() => listsState.value[String(id)] ?? null);
    },
    setList(list: ListData): void {
      listsState.value[String(list.id)] = list;
    },
    setLists(lists: ListData[]): void {
      lists.forEach((list) => (listsState.value[String(list.id)] = list));
    },
    removeList(listId: number): void {
      delete listsState.value[String(listId)];
    },
    useFetchList: (listId: number | null): FetchListComposable => {
      if (listId === null) {
        return {
          list: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchListComposable[listId]) {
        return fetchListComposable[listId];
      }

      const { data, status } = useApiFetch((api) =>
        api.lists.getListById({ listId: listId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useList().setList(value.list);
      });

      fetchListComposable[listId] = {
        list: useList().getList(listId),
        status,
      };

      return fetchListComposable[listId];
    },
    useListLists: (search: Ref<string>) => {
      const { currentPage, pageSize, useUiPageControls } = usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        return api.lists.getLists({
          page: currentPage.value,
          pageSize: pageSize.value,
          query: search.value,
        });
      });

      const uiPageControls = useUiPageControls({
        status,
        refresh,
        maxPages: computed(() => (data.value ? data.value.totalPages : 0)),
        totalItems: computed(() => (data.value ? data.value.totalItems : 0)),
      });

      watch(data, (value) => {
        if (!value) {
          return;
        }
        useList().setLists([...value.lists]);
      });

      return {
        displayLists: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.lists]
            .map(({ id: listId }) => useList().getList(listId).value)
            .filter((list): list is ListData => list !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch list list';
        }),
      };
    },
    useListAllLists: () => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchListPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.lists.getLists({ page: page, pageSize: 50 })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const lists = [...data.value.lists];

        useList().setLists(lists);

        const listIds = lists.map((list) => list.id);

        if (data.value.totalPages <= page) {
          return listIds; // List Ids from last page.
        }

        return [
          ...listIds, // List Ids from current page.
          ...(await fetchListPage(page + 1)), // List Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchListPage()
        .then((listIdsFetched) => {
          const { lists, removeList } = useList();

          const listsIdsNotFetched = Object.values(lists.value)
            .filter((list) => !listIdsFetched.includes(list.id))
            .map((list) => list.id);

          listsIdsNotFetched.forEach((listId) => removeList(listId));
          status.value = 'success';
        })
        .catch(() => {
          error.value = true;
          errorMessage.value = 'Something went wrong';
          status.value = 'error';
        });

      return {
        status,
        error,
        errorMessage,
      };
    },
    useCreateList: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newList: ListInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newList)
          const { data, status } = await useApiFetch((api) =>
            api.lists.createList({ listInput: newList })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useList().setList(data.value.list);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.list.id;
        },
        created,
        loading,
        error,
        errorMessage,
        reset() {
          created.value = false;
        },
      };
    },
    useUpdateList: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedList: ListInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.lists.updateListById({
              listId: updatedList.id,
              listInput: updatedList,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useList().setList(data.value.list);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.list.id;
        },
        updated,
        loading,
        error,
        errorMessage,
        reset() {
          updated.value = false;
        },
      };
    },
    useDeleteList: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteListId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.lists.deleteListById({
              listId: deleteListId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useList().removeList(deleteListId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteListId;
        },
        deleted,
        loading,
        error,
        errorMessage,
        reset() {
          deleted.value = false;
        },
      };
    },
  };
};
