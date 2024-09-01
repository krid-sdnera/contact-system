import type { ContactData, ContactInput } from '~/server/types/contact';
import { usePageControls } from './pageControls';
import type { MemberData } from '~/server/types/member';

interface FetchContactComposable {
  contact: ComputedRef<ContactData | null>;
  status: Ref<AsyncDataRequestStatus>;
}

// This is not good practice and you should never store state outside
// the composable constructor function. I havent been able to work out
// how to better define per entity composable fns.
const fetchContactComposable: Record<string, FetchContactComposable> = {};

export const useContact = () => {
  const contactsState = useState<Record<string, ContactData>>(
    'contacts',
    () => ({})
  );

  return {
    contacts: contactsState,
    getContact(id: number): ComputedRef<ContactData | null> {
      return computed(() => contactsState.value[String(id)] ?? null);
    },
    setContact(contact: ContactData): void {
      contactsState.value[String(contact.id)] = contact;
    },
    setContacts(contacts: ContactData[]): void {
      contacts.forEach(
        (contact) => (contactsState.value[String(contact.id)] = contact)
      );
    },
    removeContact(contactId: number): void {
      delete contactsState.value[String(contactId)];
    },
    useFetchContact: (contactId: number | null): FetchContactComposable => {
      if (contactId === null) {
        return {
          contact: computed(() => null),
          status: ref('error'),
        };
      }

      if (fetchContactComposable[contactId]) {
        return fetchContactComposable[contactId];
      }

      const { data, status } = useApiFetch((api) =>
        api.contacts.getContactById({ contactId: contactId })
      );

      watch(data, (value) => {
        if (!value?.success) {
          return;
        }
        useContact().setContact(value.contact);
      });

      fetchContactComposable[contactId] = {
        contact: useContact().getContact(contactId),
        status,
      };

      return fetchContactComposable[contactId];
    },
    useListContacts: (
      hardFilters?: { member?: MemberData },
      trackParams: boolean = false
    ) => {
      const { currentPage, pageSize, apiSortBy, apiQuery, useUiPageControls } =
        usePageControls();

      const { data, refresh, status } = useApiFetch((api) => {
        if (hardFilters?.member) {
          return api.members.getMemberContactsById({
            memberId: hardFilters.member.id,
            page: currentPage.value,
            pageSize: pageSize.value,
            sort: apiSortBy.value,
            // query: apiQuery.value,
          });
        }

        return api.contacts.getContacts({
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
        useContact().setContacts([...value.contacts]);
      });

      return {
        displayContacts: computed(() => {
          if (!data.value) {
            return [];
          }

          return [...data.value?.contacts]
            .map(
              ({ id: contactId }) => useContact().getContact(contactId).value
            )
            .filter((contact): contact is ContactData => contact !== null);
        }),
        uiPageControls,
        refresh,
        loading: computed(() => status.value === 'pending'),
        error: computed(() => status.value === 'error'),
        errorMessage: computed(() => {
          return 'Unable to fetch contact list';
        }),
      };
    },
    useListAllContacts: (hardFilters?: { member?: MemberData }) => {
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      async function fetchContactPage(page: number = 1): Promise<number[]> {
        const { data } = await useApiFetch((api) => {
          if (hardFilters?.member) {
            return api.members.getMemberContactsById({
              memberId: hardFilters.member.id,
              page: page,
              pageSize: 50,
            });
          }

          return api.contacts.getContacts({ page: page });
        });

        if (!data.value) {
          error.value = true;
          errorMessage.value = '';
          return [];
        }

        const contacts = [...data.value.contacts];

        useContact().setContacts(contacts);

        const contactIds = contacts.map((contact) => contact.id);

        if (data.value.totalPages <= page) {
          return contactIds; // Contact Ids from last page.
        }

        return [
          ...contactIds, // Contact Ids from current page.
          ...(await fetchContactPage(page + 1)), // Contact Ids from future pages.
        ];
      }

      const status = ref<AsyncDataRequestStatus>('pending');

      const promise = fetchContactPage()
        .then(
          (
            contactIdsFetched
          ): { contactIdsFetched: number[]; contacts: ContactData[] } => {
            const { contacts, removeContact } = useContact();

            if (filters?.member) {
              // A filter was used.
              // Dont remove members from local cache if they were missing from this request.
            } else {
              const contactsIdsNotFetched = Object.values(contacts.value)
                .filter((contact) => !contactIdsFetched.includes(contact.id))
                .map((contact) => contact.id);

              contactsIdsNotFetched.forEach((contactId) =>
                removeContact(contactId)
              );
            }

            status.value = 'success';

            return {
              contactIdsFetched,
              contacts: contactIdsFetched
                .map(
                  (contactId) =>
                    useContact().getContact(Number(contactId)).value
                )
                .filter((contact): contact is ContactData => contact !== null),
            };
          }
        )
        .catch((): never => {
          error.value = true;
          errorMessage.value = 'Something went wrong';
          status.value = 'error';
          throw new Error('Failed to fetch all contacts');
        });

      return {
        status,
        error,
        errorMessage,
        promise,
      };
    },
    useCreateContact: () => {
      const created = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async create(newContact: ContactInput): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          // console.log(newContact)
          const { data, status } = await useApiFetch((api) =>
            api.contacts.createContact({ contactInput: newContact })
          );

          if (!data.value || data.value.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'Failed';
            return null;
          }

          useContact().setContact(data.value.contact);

          // Set `created` ref so create button can be disabled
          // forever once we've had a successful creation.
          created.value = true;
          loading.value = false;

          return data.value.contact.id;
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
    useUpdateContact: () => {
      const updated = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async update(
          updatedContact: ContactInput & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.contacts.updateContactById({
              contactId: updatedContact.id,
              contactInput: updatedContact,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useContact().setContact(data.value.contact);

          // Set `updated` ref so update button can be disabled
          // forever once we've had a successful update.
          updated.value = true;
          loading.value = false;

          return data.value.contact.id;
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
    usePatchContact: () => {
      const patched = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async patch(
          patchedContact: Partial<ContactInput> & { id: number }
        ): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;

          const { data } = await useApiFetch((api) =>
            api.contacts.patchContactById({
              contactId: patchedContact.id,
              contactInput: patchedContact,
            })
          );

          if (!data.value || data.value?.success === false) {
            loading.value = false;
            error.value = true;
            errorMessage.value = 'failed';
            return null;
          }

          useContact().setContact(data.value.contact);

          // Set `patched` ref so patch button can be disabled
          // forever once we've had a successful patch.
          patched.value = true;
          loading.value = false;

          return data.value.contact.id;
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
    useDeleteContact: () => {
      const deleted = ref<boolean>(false);
      const loading = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string | undefined>(undefined);

      return {
        async deleteFn(deleteContactId: number): Promise<number | null> {
          loading.value = true;
          error.value = false;
          errorMessage.value = undefined;
          const { data } = await useApiFetch((api) =>
            api.contacts.deleteContactById({
              contactId: deleteContactId,
            })
          );

          if (!data.value || data.value.code !== 200) {
            loading.value = false;
            error.value = true;
            errorMessage.value = data.value?.message ?? '';
            return null;
          }

          useContact().removeContact(deleteContactId);

          // Set `deleted` ref so delete button can be disabled
          // forever once we've had a successful creation.
          deleted.value = true;
          loading.value = false;

          return deleteContactId;
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
