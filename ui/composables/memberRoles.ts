import type {
  MemberRoleData,
  MemberRoleInput,
} from '~/server/types/memberRole';
import { usePageControls } from './pageControls';
import type { MemberData } from '~/server/types/member';

interface FetchMemberRoleComposable {
  memberRole: ComputedRef<MemberRoleData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchMemberRoleComposable: Record<string, FetchMemberRoleComposable> = {};

export const useMemberRole = () => {
  const memberRolesState = useState<Record<string, MemberRoleData>>(
    'memberRoles',
    () => ({})
  );

  return {
    memberRoles: memberRolesState,
    getMemberRole(id: string): ComputedRef<MemberRoleData | null> {
      return computed(() => memberRolesState.value[String(id)] ?? null);
    },
    setMemberRole(memberRole: MemberRoleData): void {
      memberRolesState.value[String(memberRole.id)] = memberRole;
    },
    setMemberRoles(memberRoles: MemberRoleData[]): void {
      memberRoles.forEach(
        (memberRole) =>
          (memberRolesState.value[String(memberRole.id)] = memberRole)
      );
    },
    removeMemberRole(memberRoleId: string): void {
      delete memberRolesState.value[memberRoleId];
    },
    // useFetchMemberRole: (
    //   memberRoleId: number | null
    // ): FetchMemberRoleComposable => {
    //   if (memberRoleId === null) {
    //     return {
    //       memberRole: computed(() => null),
    //       status: ref('error'),
    //     };
    //   }

    //   if (fetchMemberRoleComposable[memberRoleId]) {
    //     return fetchMemberRoleComposable[memberRoleId];
    //   }

    //   const { data, status } = useApiFetch((api) =>
    //     api.members.getMemberRolesById({ memberRoleId: memberRoleId })
    //   );

    //   watch(data, (value) => {
    //     if (!value?.success) {
    //       return;
    //     }
    //     useMemberRole().setMemberRole(value.memberRole);
    //   });

    //   fetchMemberRoleComposable[memberRoleId] = {
    //     memberRole: useMemberRole().getMemberRole(memberRoleId),
    //     status,
    //   };

    //   return fetchMemberRoleComposable[memberRoleId];
    // },
    useListMemberRoles: (
      search: Ref<string>,
      filters: { member: MemberData }
    ) => {
      const { currentPage, pageSize, useUiPageControls } = usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        return api.members.getMemberRolesById({
          page: currentPage.value,
          pageSize: pageSize.value,
          memberId: filters.member.id,
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
        useMemberRole().setMemberRoles([...value.roles]);
      });

      return {
        displayMemberRoles: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.roles]
            .map(
              ({ id: memberRoleId }) =>
                useMemberRole().getMemberRole(memberRoleId).value
            )
            .filter(
              (memberRole): memberRole is MemberRoleData => memberRole !== null
            );
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch memberRole list';
        }),
      };
    },
    useListAllMemberRoles: (filters: { member: MemberData }) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchMemberRolePage(page: number = 1): Promise<string[]> {
        const { data } = await useApiFetch((api) =>
          api.members.getMemberRolesById({
            memberId: filters.member.id,
            page: page,
            pageSize: 50,
          })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const memberRoles = [...data.value.roles];

        useMemberRole().setMemberRoles(memberRoles);

        const memberRoleIds = memberRoles.map((memberRole) => memberRole.id);

        if (data.value.totalPages <= page) {
          return memberRoleIds; // MemberRole Ids from last page.
        }

        return [
          ...memberRoleIds, // MemberRole Ids from current page.
          ...(await fetchMemberRolePage(page + 1)), // MemberRole Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchMemberRolePage()
        .then((memberRoleIdsFetched) => {
          const { memberRoles, removeMemberRole } = useMemberRole();

          const memberRolesIdsNotFetched = Object.values(memberRoles.value)
            .filter(
              (memberRole) => !memberRoleIdsFetched.includes(memberRole.id)
            )
            .map((memberRole) => memberRole.id);

          memberRolesIdsNotFetched.forEach((memberRoleId) =>
            removeMemberRole(memberRoleId)
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
    useCreateMemberRole: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(
          memberId: number,
          roleId: number,
          newMemberRole: MemberRoleInput
        ): Promise<string | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newMemberRole)
          const { data, status } = await useApiFetch((api) =>
            api.members.addMemberRoleById({
              memberId,
              roleId,
              memberRoleInput: newMemberRole,
            })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useMemberRole().setMemberRole(data.value.memberRole);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.memberRole.id;
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
    useUpdateMemberRole: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedMemberRole: MemberRoleInput & {
            memberId: number;
            roleId: number;
          }
        ): Promise<string | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // I'm not really happy with deleting the existing role link before adding the new one.
          // For now, the UI will display this action as duplicating the role link.
          // TODO: implement a replace role api handler?
          const { data } = await useApiFetch((api) =>
            api.members.addMemberRoleById({
              memberId: updatedMemberRole.memberId,
              roleId: updatedMemberRole.roleId,
              memberRoleInput: updatedMemberRole,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useMemberRole().setMemberRole(data.value.memberRole);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.memberRole.id;
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
    useDeleteMemberRole: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(
          deleteMemberRole: MemberRoleData
        ): Promise<string | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.members.removeMemberRoleById({
              memberId: deleteMemberRole.memberId,
              roleId: deleteMemberRole.role.id,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useMemberRole().removeMemberRole(deleteMemberRole.id);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteMemberRole.id;
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
