import type { AuditData } from '~/server/types/audit';
import { usePageControls } from './pageControls';
import type { MemberData } from '~/server/types/member';

interface FetchAuditComposable {
  audit: ComputedRef<AuditData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchAuditComposable: Record<string, FetchAuditComposable> = {};

export const useAudit = () => {
  const auditsState = useState<Record<string, AuditData>>('audits', () => ({}));

  return {
    audits: auditsState,
    getAudit(id: number): ComputedRef<AuditData | null> {
      return computed(() => auditsState.value[String(id)] ?? null);
    },
    setAudit(audit: AuditData): void {
      auditsState.value[String(audit.id)] = audit;
    },
    setAudits(audits: AuditData[]): void {
      audits.forEach((audit) => (auditsState.value[String(audit.id)] = audit));
    },
    removeAudit(auditId: number): void {
      delete auditsState.value[String(auditId)];
    },
    useListAudits: (search: Ref<string>, filters?: { member?: MemberData }) => {
      const { currentPage, apiSortBy, pageSize, useUiPageControls } =
        usePageControls({ sortBy: [{ key: 'createdAt', order: 'desc' }] });

      const { data, refresh, status } = useApiFetch((api) => {
        if (filters?.member) {
          // TODO: Build search param.
        }

        return api.audits.getAudits({
          page: currentPage.value,
          pageSize: pageSize.value,
          query: search.value,
          sort: apiSortBy.value,
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
        useAudit().setAudits([...value.audits]);
      });

      return {
        displayAudits: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.audits]
            .map(({ id: auditId }) => useAudit().getAudit(auditId).value)
            .filter((audit): audit is AuditData => audit !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch audit list';
        }),
      };
    },
    useListAllAudits: (filters?: { member?: MemberData }) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchAuditPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) => {
          if (filters?.member) {
            // TODO: Build search param.
          }

          return api.audits.getAudits({ page: page });
        });

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const audits = [...data.value.audits];

        useAudit().setAudits(audits);

        const auditIds = audits.map((audit) => audit.id);

        if (data.value.totalPages <= page) {
          return auditIds; // Audit Ids from last page.
        }

        return [
          ...auditIds, // Audit Ids from current page.
          ...(await fetchAuditPage(page + 1)), // Audit Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      const promise = fetchAuditPage()
        .then(
          (
            auditIdsFetched
          ): { auditIdsFetched: number[]; audits: AuditData[] } => {
            const { audits, removeAudit } = useAudit();

            if (filters?.member) {
              // A filter was used.
              // Dont remove members from local cache if they were missing from this request.
            } else {
              const auditsIdsNotFetched = Object.values(audits.value)
                .filter((audit) => !auditIdsFetched.includes(audit.id))
                .map((audit) => audit.id);

              auditsIdsNotFetched.forEach((auditId) => removeAudit(auditId));
            }

            status.value = 'success';

            return {
              auditIdsFetched,
              audits: auditIdsFetched
                .map((auditId) => useAudit().getAudit(Number(auditId)).value)
                .filter((audit): audit is AuditData => audit !== null),
            };
          }
        )
        .catch((): never => {
          error.value = true;
          errorMessage.value = 'Something went wrong';
          status.value = 'error';
          throw new Error('Failed to fetch all audits');
        });

      return {
        status,
        error,
        errorMessage,
        promise,
      };
    },
  };
};
