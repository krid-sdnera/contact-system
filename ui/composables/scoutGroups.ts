import type {
  ScoutGroupData,
  ScoutGroupInput,
} from '~/server/types/scoutGroup';
import { usePageControls } from './pageControls';

interface FetchScoutGroupComposable {
  scoutGroup: ComputedRef<ScoutGroupData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchScoutGroupComposable: Record<string, FetchScoutGroupComposable> = {};

export const useScoutGroup = () => {
  const scoutGroupsState = useState<Record<string, ScoutGroupData>>(
    'scoutGroups',
    () => ({})
  );

  return {
    scoutGroups: scoutGroupsState,
    getScoutGroup(id: number): ComputedRef<ScoutGroupData | null> {
      return computed(() => scoutGroupsState.value[String(id)] ?? null);
    },
    setScoutGroup(scoutGroup: ScoutGroupData): void {
      scoutGroupsState.value[String(scoutGroup.id)] = scoutGroup;
    },
    setScoutGroups(scoutGroups: ScoutGroupData[]): void {
      scoutGroups.forEach(
        (scoutGroup) =>
          (scoutGroupsState.value[String(scoutGroup.id)] = scoutGroup)
      );
    },
    removeScoutGroup(scoutGroupId: number): void {
      delete scoutGroupsState.value[String(scoutGroupId)];
    },
    useFetchScoutGroup: (
      scoutGroupId: number | null
    ): FetchScoutGroupComposable => {
      if (scoutGroupId === null) {
        return {
          scoutGroup: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchScoutGroupComposable[scoutGroupId]) {
        return fetchScoutGroupComposable[scoutGroupId];
      }

      const { data, status } = useApiFetch((api) =>
        api.scoutGroups.getScoutGroupById({ scoutGroupId: scoutGroupId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useScoutGroup().setScoutGroup(value.scoutGroup);
      });

      fetchScoutGroupComposable[scoutGroupId] = {
        scoutGroup: useScoutGroup().getScoutGroup(scoutGroupId),
        status,
      };

      return fetchScoutGroupComposable[scoutGroupId];
    },
    useListScoutGroups: () => {
      const { currentPage, pageSize, apiSortBy, apiQuery, useUiPageControls } =
        usePageControls();

      const { data, refresh, status } = useApiFetch((api) =>
        api.scoutGroups.getScoutGroups({
          page: currentPage.value,
          pageSize: pageSize.value,
          sort: apiSortBy.value,
          query: apiQuery.value,
        })
      );

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
        useScoutGroup().setScoutGroups([...value.scoutGroups]);
      });

      return {
        displayScoutGroups: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.scoutGroups]
            .map(
              ({ id: scoutGroupId }) =>
                useScoutGroup().getScoutGroup(scoutGroupId).value
            )
            .filter(
              (scoutGroup): scoutGroup is ScoutGroupData => scoutGroup !== null
            );
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch scoutGroup list';
        }),
      };
    },
    useListAllScoutGroups: () => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchScoutGroupPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.scoutGroups.getScoutGroups({ page: page, pageSize: 50 })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const scoutGroups = [...data.value.scoutGroups];

        useScoutGroup().setScoutGroups(scoutGroups);

        const scoutGroupIds = scoutGroups.map((scoutGroup) => scoutGroup.id);

        if (data.value.totalPages <= page) {
          return scoutGroupIds; // ScoutGroup Ids from last page.
        }

        return [
          ...scoutGroupIds, // ScoutGroup Ids from current page.
          ...(await fetchScoutGroupPage(page + 1)), // ScoutGroup Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchScoutGroupPage()
        .then((scoutGroupIdsFetched) => {
          const { scoutGroups, removeScoutGroup } = useScoutGroup();

          const scoutGroupsIdsNotFetched = Object.values(scoutGroups.value)
            .filter(
              (scoutGroup) => !scoutGroupIdsFetched.includes(scoutGroup.id)
            )
            .map((scoutGroup) => scoutGroup.id);

          scoutGroupsIdsNotFetched.forEach((scoutGroupId) =>
            removeScoutGroup(scoutGroupId)
          );
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
    useCreateScoutGroup: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newScoutGroup: ScoutGroupInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newScoutGroup)
          const { data, status } = await useApiFetch((api) =>
            api.scoutGroups.createScoutGroup({ scoutGroupInput: newScoutGroup })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useScoutGroup().setScoutGroup(data.value.scoutGroup);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.scoutGroup.id;
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
    useUpdateScoutGroup: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedScoutGroup: ScoutGroupInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.scoutGroups.updateScoutGroupById({
              scoutGroupId: updatedScoutGroup.id,
              scoutGroupInput: updatedScoutGroup,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useScoutGroup().setScoutGroup(data.value.scoutGroup);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.scoutGroup.id;
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
    useDeleteScoutGroup: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteScoutGroupId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.scoutGroups.deleteScoutGroupById({
              scoutGroupId: deleteScoutGroupId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useScoutGroup().removeScoutGroup(deleteScoutGroupId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteScoutGroupId;
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
