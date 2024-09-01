import type { RoleData, RoleInput } from '~/server/types/role';
import { usePageControls } from './pageControls';
import type { SectionData } from '~/server/types/section';

interface FetchRoleComposable {
  role: ComputedRef<RoleData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchRoleComposable: Record<string, FetchRoleComposable> = {};

export const useRole = () => {
  const rolesState = useState<Record<string, RoleData>>('roles', () => ({}));

  return {
    roles: rolesState,
    getRole(id: number): ComputedRef<RoleData | null> {
      return computed(() => rolesState.value[String(id)] ?? null);
    },
    setRole(role: RoleData): void {
      rolesState.value[String(role.id)] = role;
    },
    setRoles(roles: RoleData[]): void {
      roles.forEach((role) => (rolesState.value[String(role.id)] = role));
    },
    removeRole(roleId: number): void {
      delete rolesState.value[String(roleId)];
    },
    useFetchRole: (roleId: number | null): FetchRoleComposable => {
      if (roleId === null) {
        return {
          role: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchRoleComposable[roleId]) {
        return fetchRoleComposable[roleId];
      }

      const { data, status } = useApiFetch((api) =>
        api.roles.getRoleById({ roleId: roleId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useRole().setRole(value.role);
      });

      fetchRoleComposable[roleId] = {
        role: useRole().getRole(roleId),
        status,
      };

      return fetchRoleComposable[roleId];
    },
    useListRoles: (
      hardFilters?: { section?: SectionData },
      trackParams: boolean = false
    ) => {
      const { currentPage, pageSize, apiSortBy, apiQuery, useUiPageControls } =
        usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        if (hardFilters?.section) {
          return api.sections.getSectionRolesBySectionId({
            sectionId: hardFilters.section.id,
            // page: currentPage.value,
            // pageSize: pageSize.value,
            // sort: apiSortBy.value,
            // query: apiQuery.value,
          });
        }

        return api.roles.getRoles({
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
        trackParams,
      });

      watch(data, (value) => {
        if (!value) {
          return;
        }
        useRole().setRoles([...value.roles]);
      });

      return {
        displayRoles: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.roles]
            .map(({ id: roleId }) => useRole().getRole(roleId).value)
            .filter((role): role is RoleData => role !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch role list';
        }),
      };
    },
    useListAllRoles: () => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchRolePage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.roles.getRoles({ page: page, pageSize: 50 })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const roles = [...data.value.roles];

        useRole().setRoles(roles);

        const roleIds = roles.map((role) => role.id);

        if (data.value.totalPages <= page) {
          return roleIds; // Role Ids from last page.
        }

        return [
          ...roleIds, // Role Ids from current page.
          ...(await fetchRolePage(page + 1)), // Role Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchRolePage()
        .then((roleIdsFetched) => {
          const { roles, removeRole } = useRole();

          const rolesIdsNotFetched = Object.values(roles.value)
            .filter((role) => !roleIdsFetched.includes(role.id))
            .map((role) => role.id);

          rolesIdsNotFetched.forEach((roleId) => removeRole(roleId));
          status.value = 'success';
        })
        .catch((e) => {
          console.log(e);
          error.value = true;
          errorMessage.value = 'Something went wrong1';
          status.value = 'error';
        });

      return {
        status,
        error,
        errorMessage,
      };
    },
    useCreateRole: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newRole: RoleInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newRole)
          const { data, status } = await useApiFetch((api) =>
            api.roles.createRole({ roleInput: newRole })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useRole().setRole(data.value.role);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.role.id;
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
    useUpdateRole: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedRole: RoleInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.roles.updateRoleById({
              roleId: updatedRole.id,
              roleInput: updatedRole,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useRole().setRole(data.value.role);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.role.id;
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
    useDeleteRole: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteRoleId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.roles.deleteRoleById({
              roleId: deleteRoleId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useRole().removeRole(deleteRoleId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteRoleId;
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
