import type {
  ListRuleData,
  ListRuleInput,
  ListRules,
} from '~/server/types/listRule';
import { usePageControls } from './pageControls';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';
import type { ListData } from '~/server/types/list';
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';
import type { RuleRelationProp } from './ruleRelation';

interface FetchListRuleComposable {
  listRule: ComputedRef<ListRuleData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchListRuleComposable: Record<string, FetchListRuleComposable> = {};

export const useListRule = () => {
  const listRulesState = useState<Record<string, ListRuleData>>(
    'listRules',
    () => ({})
  );

  return {
    listRules: listRulesState,
    getListRule(id: number): ComputedRef<ListRuleData | null> {
      return computed(() => listRulesState.value[String(id)] ?? null);
    },
    setListRule(listRule: ListRuleData): void {
      listRulesState.value[String(listRule.id)] = listRule;
    },
    setListRules(listRules: ListRuleData[]): void {
      listRules.forEach(
        (listRule) => (listRulesState.value[String(listRule.id)] = listRule)
      );
    },
    removeListRule(listRuleId: number): void {
      delete listRulesState.value[String(listRuleId)];
    },
    useFetchListRule: (
      listId: number | null,
      ruleId: number | null
    ): FetchListRuleComposable => {
      if (listId === null || ruleId === null) {
        return {
          listRule: computed(() => null),
          status: ref('error'),
        };
      }

      const listRuleId = ruleId;

      if (fetchListRuleComposable[listRuleId]) {
        return fetchListRuleComposable[listRuleId];
      }

      const { data, status } = useApiFetch((api) =>
        api.lists.getListRuleByListId({ listId: listId, ruleId: ruleId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useListRule().setListRule(value.listRule);
      });

      fetchListRuleComposable[listRuleId] = {
        listRule: useListRule().getListRule(listRuleId),
        status,
      };

      return fetchListRuleComposable[listRuleId];
    },
    useListListRules: (
      search: Ref<string>,
      filters:
        | {
            list: ListData;
          }
        | { relation: RuleRelationProp }
    ) => {
      const { currentPage, pageSize, useUiPageControls } = usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        if ('relation' in filters) {
          const relation = filters.relation;
          if (relation?.member) {
            return api.members.getListRulesByMemberId({
              memberId: relation.member.id,
              page: currentPage.value,
              pageSize: pageSize.value,
              query: search.value,
            });
          } else if (relation?.contact) {
            return api.contacts.getListRulesByContactId({
              contactId: relation.contact.id,
              page: currentPage.value,
              pageSize: pageSize.value,
              query: search.value,
            });
          } else if (relation?.role) {
            return api.roles.getListRulesByRoleId({
              roleId: relation.role.id,
              page: currentPage.value,
              pageSize: pageSize.value,
              query: search.value,
            });
          } else if (relation?.section) {
            return api.sections.getListRulesBySectionId({
              sectionId: relation.section.id,
              page: currentPage.value,
              pageSize: pageSize.value,
              query: search.value,
            });
          } else if (relation?.scoutGroup) {
            return api.scoutGroups.getListRulesByScoutGroupId({
              scoutGroupId: relation.scoutGroup.id,
              page: currentPage.value,
              pageSize: pageSize.value,
              query: search.value,
            });
          }
        }

        return api.lists.getListRulesByListId({
          listId: filters.list.id,
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
        useListRule().setListRules([...value.rules]);
      });

      return {
        displayListRules: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.rules]
            .map(
              ({ id: listRuleId }) =>
                useListRule().getListRule(listRuleId).value
            )
            .filter((listRule): listRule is ListRuleData => listRule !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch listRule list';
        }),
      };
    },
    useListAllListRules: (filters: { list: ListData }) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchListRulePage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.lists.getListRulesByListId({
            listId: filters.list.id,
            page: page,
            pageSize: 50,
          })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const listRules = [...data.value.rules];

        useListRule().setListRules(listRules);

        const listRuleIds = listRules.map((listRule) => listRule.id);

        if (data.value.totalPages <= page) {
          return listRuleIds; // ListRule Ids from last page.
        }

        return [
          ...listRuleIds, // ListRule Ids from current page.
          ...(await fetchListRulePage(page + 1)), // ListRule Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchListRulePage()
        .then((listRuleIdsFetched) => {
          const { listRules, removeListRule } = useListRule();

          const listRulesIdsNotFetched = Object.values(listRules.value)
            .filter((listRule) => !listRuleIdsFetched.includes(listRule.id))
            .map((listRule) => listRule.id);

          listRulesIdsNotFetched.forEach((listRuleId) =>
            removeListRule(listRuleId)
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
    useCreateListRule: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(
          listId: number,
          newListRule: ListRuleInput
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newListRule)
          const { data, status } = await useApiFetch((api) =>
            api.lists.createListRuleByListId({
              listId,
              listRuleInput: newListRule,
            })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useListRule().setListRule(data.value.listRule);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.listRule.id;
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
    useUpdateListRule: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedListRule: ListRuleInput & { id: number; listId: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.lists.updateListRuleByListId({
              listId: updatedListRule.listId,
              ruleId: updatedListRule.id,
              listRuleInput: updatedListRule,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useListRule().setListRule(data.value.listRule);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.listRule.id;
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
    useDeleteListRule: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteListRule: ListRuleData): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.lists.deleteListRuleByListId({
              listId: deleteListRule.listId,
              ruleId: deleteListRule.id,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useListRule().removeListRule(deleteListRule.id);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteListRuleId;
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
