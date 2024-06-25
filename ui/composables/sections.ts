import type { SectionData, SectionInput } from '~/server/types/section';
import { usePageControls } from './pageControls';
import type { ScoutGroupData } from '~/server/types/scoutGroup';

interface FetchSectionComposable {
  section: ComputedRef<SectionData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchSectionComposable: Record<string, FetchSectionComposable> = {};

export const useSection = () => {
  const sectionsState = useState<Record<string, SectionData>>(
    'sections',
    () => ({})
  );

  return {
    sections: sectionsState,
    getSection(id: number): ComputedRef<SectionData | null> {
      return computed(() => sectionsState.value[String(id)] ?? null);
    },
    setSection(section: SectionData): void {
      sectionsState.value[String(section.id)] = section;
    },
    setSections(sections: SectionData[]): void {
      sections.forEach(
        (section) => (sectionsState.value[String(section.id)] = section)
      );
    },
    removeSection(sectionId: number): void {
      delete sectionsState.value[String(sectionId)];
    },
    useFetchSection: (sectionId: number | null): FetchSectionComposable => {
      if (sectionId === null) {
        return {
          section: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchSectionComposable[sectionId]) {
        return fetchSectionComposable[sectionId];
      }

      const { data, status } = useApiFetch((api) =>
        api.sections.getSectionById({ sectionId: sectionId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useSection().setSection(value.section);
      });

      fetchSectionComposable[sectionId] = {
        section: useSection().getSection(sectionId),
        status,
      };

      return fetchSectionComposable[sectionId];
    },
    useListSections: (
      search: Ref<string>,
      filters?: { scoutGroup?: ScoutGroupData }
    ) => {
      const { currentPage, pageSize, useUiPageControls } = usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        if (filters?.scoutGroup) {
          return api.scoutGroups.getScoutGroupSectionsByScoutGroupId({
            scoutGroupId: filters.scoutGroup.id,
            // page: currentPage.value,
            // pageSize: pageSize.value,
            // query: search.value,
          });
        }

        return api.sections.getSections({
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
        useSection().setSections([...value.sections]);
      });

      return {
        displaySections: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.sections]
            .map(
              ({ id: sectionId }) => useSection().getSection(sectionId).value
            )
            .filter((section): section is SectionData => section !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch section list';
        }),
      };
    },
    useListAllSections: () => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchSectionPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) =>
          api.sections.getSections({ page: page, pageSize: 50 })
        );

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const sections = [...data.value.sections];

        useSection().setSections(sections);

        const sectionIds = sections.map((section) => section.id);

        if (data.value.totalPages <= page) {
          return sectionIds; // Section Ids from last page.
        }

        return [
          ...sectionIds, // Section Ids from current page.
          ...(await fetchSectionPage(page + 1)), // Section Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      fetchSectionPage()
        .then((sectionIdsFetched) => {
          const { sections, removeSection } = useSection();

          const sectionsIdsNotFetched = Object.values(sections.value)
            .filter((section) => !sectionIdsFetched.includes(section.id))
            .map((section) => section.id);

          sectionsIdsNotFetched.forEach((sectionId) =>
            removeSection(sectionId)
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
    useCreateSection: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newSection: SectionInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newSection)
          const { data, status } = await useApiFetch((api) =>
            api.sections.createSection({ sectionInput: newSection })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useSection().setSection(data.value.section);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.section.id;
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
    useUpdateSection: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedSection: SectionInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.sections.updateSectionById({
              sectionId: updatedSection.id,
              sectionInput: updatedSection,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useSection().setSection(data.value.section);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.section.id;
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
    useDeleteSection: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteSectionId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.sections.deleteSectionById({
              sectionId: deleteSectionId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useSection().removeSection(deleteSectionId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteSectionId;
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
