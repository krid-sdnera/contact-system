import type {
  ListMemberData,
  ListMemberInput,
} from '~/server/types/listListMember';
import { usePageControls } from './pageControls';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';
import type { MemberData } from '~/server/types/member';
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { ContactData } from '~/server/types/contact';
import type { ListData } from '~/server/types/list';

interface FetchListMemberComposable {
  listListMember: ComputedRef<ListMemberData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchListMemberComposable: Record<string, FetchListMemberComposable> = {};

export const useListMember = () => {
  const listListMembersState = useState<Record<string, ListMemberData>>(
    'listListMembers',
    () => ({})
  );

  return {
    listListMembers: listListMembersState,
    getListMember(id: number): ComputedRef<ListMemberData | null> {
      return computed(() => listListMembersState.value[String(id)] ?? null);
    },
    setListMember(listListMember: ListMemberData): void {
      listListMembersState.value[String(listListMember.id)] = listListMember;
    },
    setListMembers(listListMembers: ListMemberData[]): void {
      listListMembers.forEach(
        (listListMember) =>
          (listListMembersState.value[String(listListMember.id)] =
            listListMember)
      );
    },
    removeListMember(listListMemberId: number): void {
      delete listListMembersState.value[String(listListMemberId)];
    },
    // useFetchListMember: (listListMemberId: number | null): FetchListMemberComposable => {
    //   if (listListMemberId === null) {
    //     return {
    //       listListMember: computed(() => null),
    //       status: ref('error'),
    //     };
    //   }

    //   if (fetchListMemberComposable[listListMemberId]) {
    //     return fetchListMemberComposable[listListMemberId];
    //   }

    //   const { data, status } = useApiFetch((api) =>
    //     api.lists.getListMemberById({ listListMemberId: listListMemberId })
    //   );

    //   watch(data, (value) => {
    //     if (!value?.success) {
    //       return;
    //     }
    //     useListMember().setListMember(value.listListMember);
    //   });

    //   fetchListMemberComposable[listListMemberId] = {
    //     listListMember: useListMember().getListMember(listListMemberId),
    //     status,
    //   };

    //   return fetchListMemberComposable[listListMemberId];
    // },
    useListListMembers: (
      list: ListData,
      search: Ref<string>,
      hardFilters?: {
        member?: MemberData;
        contact?: ContactData;
        role?: RoleData;
        section?: SectionData;
        scoutGroup?: ScoutGroupData;
      }
    ) => {
      const { currentPage, pageSize, useUiPageControls } = usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        // if (hardFilters?.role) {
        //   return api.roles.getListMembersByRoleId({
        //     roleId: hardFilters.role.id,
        //     page: currentPage.value,
        //     pageSize: pageSize.value,
        //     query: search.value,
        //   });
        // } else if (hardFilters?.section) {
        //   return api.sections.getListMembersBySectionId({
        //     sectionId: hardFilters.section.id,
        //     page: currentPage.value,
        //     pageSize: pageSize.value,
        //     query: search.value,
        //   });
        // }

        // TODO hardFilters

        return api.lists.getListRecipientsByListId({
          listId: list.id,
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
        useListMember().setListMembers([...value.recipients]);
      });

      return {
        displayListMembers: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.recipients]
            .map(
              ({ id: listListMemberId }) =>
                useListMember().getListMember(listListMemberId).value
            )
            .filter(
              (listListMember): listListMember is ListMemberData =>
                listListMember !== null
            );
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch listListMember list';
        }),
      };
    },
    useListAllListMembers: (listId: number) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchListMemberPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.lists.getListRecipientsByListId({
            listId: listId,
            page: page,
            pageSize: 50,
          })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const listListMembers = [...data.value.recipients];

        useListMember().setListMembers(listListMembers);

        const listListMemberIds = listListMembers.map(
          (listListMember) => listListMember.id
        );

        if (data.value.totalPages <= page) {
          return listListMemberIds; // ListMember Ids from last page.
        }

        return [
          ...listListMemberIds, // ListMember Ids from current page.
          ...(await fetchListMemberPage(page + 1)), // ListMember Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchListMemberPage()
        .then((listListMemberIdsFetched) => {
          const { listListMembers, removeListMember } = useListMember();

          const listListMembersIdsNotFetched = Object.values(
            listListMembers.value
          )
            .filter(
              (listListMember) =>
                !listListMemberIdsFetched.includes(listListMember.id)
            )
            .map((listListMember) => listListMember.id);

          listListMembersIdsNotFetched.forEach((listListMemberId) =>
            removeListMember(listListMemberId)
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
    // useCreateListMember: () => {
    //   const created = ref<boolean>(false);
    //   const loading = ref<boolean>(false);
    //   const error = ref<boolean>(false);
    //   const errorMessage = ref<string | undefined>(undefined);

    //   return {
    //     async create(newListMember: ListMemberInput): Promise<number | null> {
    //       loading.value = true;
    //       error.value = false;
    //       errorMessage.value = undefined;

    //       // console.log(newListMember)
    //       const { data, status } = await useApiFetch((api) =>
    //         api.lists.createListMember({ listListMemberInput: newListMember })
    //       );

    //       if (!data.value || data.value.success === false) {
    //         loading.value = false;
    //         error.value = true;
    //         errorMessage.value = 'Failed';
    //         return null;
    //       }

    //       useListMember().setListMember(data.value.listListMember);

    //       // Set `created` ref so create button can be disabled
    //       // forever once we've had a successful creation.
    //       created.value = true;
    //       loading.value = false;

    //       return data.value.listListMember.id;
    //     },
    //     created,
    //     loading,
    //     error,
    //     errorMessage,
    //     reset() {
    //       created.value = false;
    //     },
    //   };
    // },
    // useUpdateListMember: () => {
    //   const updated = ref<boolean>(false);
    //   const loading = ref<boolean>(false);
    //   const error = ref<boolean>(false);
    //   const errorMessage = ref<string | undefined>(undefined);

    //   return {
    //     async update(
    //       updatedListMember: ListMemberInput & { id: number }
    //     ): Promise<number | null> {
    //       loading.value = true;
    //       error.value = false;
    //       errorMessage.value = undefined;

    //       const { data } = await useApiFetch((api) =>
    //         api.lists.updateListMemberById({
    //           listListMemberId: updatedListMember.id,
    //           listListMemberInput: updatedListMember,
    //         })
    //       );

    //       if (!data.value || data.value?.success === false) {
    //         loading.value = false;
    //         error.value = true;
    //         errorMessage.value = 'failed';
    //         return null;
    //       }

    //       useListMember().setListMember(data.value.listListMember);

    //       // Set `updated` ref so update button can be disabled
    //       // forever once we've had a successful update.
    //       updated.value = true;
    //       loading.value = false;

    //       return data.value.listListMember.id;
    //     },
    //     updated,
    //     loading,
    //     error,
    //     errorMessage,
    //     reset() {
    //       updated.value = false;
    //     },
    //   };
    // },
    // useDeleteListMember: () => {
    //   const deleted = ref<boolean>(false);
    //   const loading = ref<boolean>(false);
    //   const error = ref<boolean>(false);
    //   const errorMessage = ref<string | undefined>(undefined);

    //   return {
    //     async deleteFn(deleteListMemberId: number): Promise<number | null> {
    //       loading.value = true;
    //       error.value = false;
    //       errorMessage.value = undefined;
    //       const { data } = await useApiFetch((api) =>
    //         api.lists.deleteListMemberById({
    //           listListMemberId: deleteListMemberId,
    //         })
    //       );

    //       if (!data.value || data.value.code !== 200) {
    //         loading.value = false;
    //         error.value = true;
    //         errorMessage.value = data.value?.message ?? '';
    //         return null;
    //       }

    //       useListMember().removeListMember(deleteListMemberId);

    //       // Set `deleted` ref so delete button can be disabled
    //       // forever once we've had a successful creation.
    //       deleted.value = true;
    //       loading.value = false;

    //       return deleteListMemberId;
    //     },
    //     deleted,
    //     loading,
    //     error,
    //     errorMessage,
    //     reset() {
    //       deleted.value = false;
    //     },
    //   };
    // },
  };
};
