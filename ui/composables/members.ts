import type { MemberData, MemberInput } from '~/server/types/member';
import { usePageControls } from './pageControls';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

interface FetchMemberComposable {
  member: ComputedRef<MemberData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchMemberComposable: Record<string, FetchMemberComposable> = {};

export const useMember = () => {
  const membersState = useState<Record<string, MemberData>>(
    'members',
    () => ({})
  );

  return {
    members: membersState,
    getMember(id: number): ComputedRef<MemberData | null> {
      return computed(() => membersState.value[String(id)] ?? null);
    },
    setMember(member: MemberData): void {
      membersState.value[String(member.id)] = member;
    },
    setMembers(members: MemberData[]): void {
      members.forEach(
        (member) => (membersState.value[String(member.id)] = member)
      );
    },
    removeMember(memberId: number): void {
      delete membersState.value[String(memberId)];
    },
    useFetchMember: (memberId: number | null): FetchMemberComposable => {
      if (memberId === null) {
        return {
          member: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchMemberComposable[memberId]) {
        return fetchMemberComposable[memberId];
      }

      const { data, status } = useApiFetch((api) =>
        api.members.getMemberById({ memberId: memberId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useMember().setMember(value.member);
      });

      fetchMemberComposable[memberId] = {
        member: useMember().getMember(memberId),
        status,
      };

      return fetchMemberComposable[memberId];
    },
    useListMembers: (hardFilters?: {
      role?: RoleData;
      section?: SectionData;
    }) => {
      const { currentPage, pageSize, apiSortBy, apiQuery, useUiPageControls } =
        usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        if (hardFilters?.role) {
          return api.roles.getMembersByRoleId({
            roleId: hardFilters.role.id,
            page: currentPage.value,
            pageSize: pageSize.value,
            sort: apiSortBy.value,
            query: apiQuery.value,
          });
        } else if (hardFilters?.section) {
          return api.sections.getMembersBySectionId({
            sectionId: hardFilters.section.id,
            page: currentPage.value,
            pageSize: pageSize.value,
            sort: apiSortBy.value,
            query: apiQuery.value,
          });
        }

        return api.members.getMembers({
          page: currentPage.value,
          pageSize: pageSize.value,
          sort: apiSortBy.value,
          query: apiQuery.value,
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
        useMember().setMembers([...value.members]);
      });

      return {
        displayMembers: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.members]
            .map(({ id: memberId }) => useMember().getMember(memberId).value)
            .filter((member): member is MemberData => member !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch member list';
        }),
      };
    },
    useListAllMembers: (hardFilters?: {
      role?: RoleData;
      section?: SectionData;
    }) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchMemberPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) => {
          if (hardFilters?.role) {
            return api.roles.getMembersByRoleId({
              roleId: hardFilters.role.id,
              page: page,
              pageSize: 50,
            });
          } else if (hardFilters?.section) {
            return api.sections.getMembersBySectionId({
              sectionId: hardFilters.section.id,
              page: page,
              pageSize: 50,
            });
          }

          return api.members.getMembers({
            page: page,
            pageSize: 50,
          });
        });

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const members = [...data.value.members];

        useMember().setMembers(members);

        const memberIds = members.map((member) => member.id);

        if (data.value.totalPages <= page) {
          return memberIds; // Member Ids from last page.
        }

        return [
          ...memberIds, // Member Ids from current page.
          ...(await fetchMemberPage(page + 1)), // Member Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      const promise = fetchMemberPage()
        .then(
          (
            memberIdsFetched
          ): { memberIdsFetched: number[]; members: MemberData[] } => {
            const { members, removeMember } = useMember();

            if (hardFilters?.role || hardFilters?.section) {
              // A filter was used.
              // Dont remove members from local cache if they were missing from this request.
            } else {
              const membersIdsNotFetched = Object.values(members.value)
                .filter((member) => !memberIdsFetched.includes(member.id))
                .map((member) => member.id);

              membersIdsNotFetched.forEach((memberId) =>
                removeMember(memberId)
              );
            }

            status.value = 'success';

            return {
              memberIdsFetched,
              members: memberIdsFetched
                .map(
                  (memberId) => useMember().getMember(Number(memberId)).value
                )
                .filter((member): member is MemberData => member !== null),
            };
          }
        )
        .catch((): never => {
          error.value = true;
          errorMessage.value = 'Something went wrong';
          status.value = 'error';
          throw new Error('Failed to fetch all members');
        });

      return {
        status,
        error,
        errorMessage,
        promise,
      };
    },
    useCreateMember: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newMember: MemberInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newMember)
          const { data, status } = await useApiFetch((api) =>
            api.members.createMember({ memberInput: newMember })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useMember().setMember(data.value.member);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.member.id;
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
    useUpdateMember: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedMember: MemberInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.members.updateMemberById({
              memberId: updatedMember.id,
              memberInput: updatedMember,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useMember().setMember(data.value.member);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.member.id;
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
    usePatchMember: () => {
      const patched = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async patch(
          patchedMember: Partial<MemberInput> & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.members.patchMemberById({
              memberId: patchedMember.id,
              memberInput: patchedMember,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useMember().setMember(data.value.member);

          // Set `patched` ref so patch button can be disabled
          // forever once we've had a successful patch.
          patched.value = true;
          loading.value = false;

          return data.value.member.id;
        },
        patched,
        loading,
        error,
        errorMessage,
        reset() {
          patched.value = false;
        },
      };
    },
    useDeleteMember: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteMemberId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.members.deleteMemberById({
              memberId: deleteMemberId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useMember().removeMember(deleteMemberId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteMemberId;
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
