import type { AsyncDataRequestStatus } from '#app';
import type { ModelApiResponse } from '~/lib/ContactSystem/Client/src';
import {
  AuthApi,
  ContactsApi,
  ListsApi,
  MembersApi,
  RolesApi,
  ScoutGroupsApi,
  SectionsApi,
  type AuthApiInterface,
  type ContactsApiInterface,
  type ListsApiInterface,
  type MembersApiInterface,
  type RolesApiInterface,
  type ScoutGroupsApiInterface,
  type SectionsApiInterface,
} from '~/lib/ContactSystem/Client/src/apis';
import {
  Configuration,
  type ResponseContext,
} from '~/lib/ContactSystem/Client/src/runtime';

const { tokens, refreshToken } = useAuth();

const globalPending = ref<boolean>(false);
const globalError = ref<boolean>(false);

export function useApi(): AllApiInterface {
  const configuration = new Configuration({
    basePath: useRuntimeConfig().public.baseApiUrl,
    accessToken: function (name?: string, _scopes?: string[]): string {
      if (name !== 'jwt_auth') {
        console.warn(`Unsupported accessToken type: "${name}"`);
        return '';
      }

      const token = tokens.value.auth || '';

      console.debug(`token:${token}`);
      return token;
    },
    middleware: [
      {
        pre: async (context: ResponseContext) => {
          globalPending.value = true;
          globalError.value = false;
        },
      },
      {
        post: async (context: ResponseContext) => {
          globalPending.value = false;
          if (context.response.status !== 200) {
            globalError.value = true;
            setTimeout(() => {
              globalError.value = false;
            }, 1000);
          }
        },
      },
      {
        post: async function (
          context: ResponseContext
        ): Promise<Response | void> {
          if (context.url.match('auth/token')) {
            // Performing a token action, do not try refresh the token if it failed.
            return context.response;
          }
          if (context.response.status !== 401) {
            return context.response;
          }

          try {
            await refreshToken();
          } catch (e) {
            return context.response;
          }

          // `configuration.fetchApi()` does not re-compute the headers
          //  for the request, instead we need to inject the new token
          //  in to these reqests.
          context.init.headers = {
            ...context.init.headers,
            Authorization: `Bearer ${
              configuration.accessToken
                ? configuration.accessToken('jwt_auth')
                : ''
            }`,
          };

          const response = await (configuration.fetchApi || fetch)(
            context.url,
            context.init
          );

          return response || context.response;
        },
      },
    ],
  });

  return {
    globalPending,
    globalError,
    auth: new AuthApi(configuration),
    contacts: new ContactsApi(configuration),
    scoutGroups: new ScoutGroupsApi(configuration),
    lists: new ListsApi(configuration),
    members: new MembersApi(configuration),
    roles: new RolesApi(configuration),
    sections: new SectionsApi(configuration),
  };
}

export interface AllApiInterface {
  globalPending: Ref<boolean>;
  globalError: Ref<boolean>;
  auth: AuthApiInterface;
  contacts: ContactsApiInterface;
  scoutGroups: ScoutGroupsApiInterface;
  lists: ListsApiInterface;
  members: MembersApiInterface;
  roles: RolesApiInterface;
  sections: SectionsApiInterface;
}

interface UseApiFetchOptions {
  immediate: boolean;
}

export interface _AsyncData<DataT, ErrorT> {
  data: Ref<DataT>;
  /**
   * @deprecated Use `status` instead. This may be removed in a future major version.
   */
  pending: Ref<boolean>;
  refresh: () => Promise<void>;
  execute: () => Promise<void>;
  clear: () => void;
  error: Ref<ErrorT | null>;
  status: Ref<AsyncDataRequestStatus>;
}

export type AsyncData<Data, Error> = _AsyncData<Data, Error> &
  Promise<_AsyncData<Data, Error>>;

export type { AsyncDataRequestStatus };

export function useApiFetch<DataT extends Record<string, any>>(
  fetchCB: (api: ReturnType<typeof useApi>) => Promise<DataT>,
  opts?: Partial<UseApiFetchOptions>
): AsyncData<DataT | undefined, Error> {
  const data = ref<DataT>();
  const pending = ref<boolean>(false);
  const error = ref<Error | null>(null);
  const status = ref<AsyncDataRequestStatus>('idle');

  const api = useApi();

  let returnPromiseResolve:
    | ((
        value:
          | _AsyncData<DataT | undefined, Error>
          | PromiseLike<_AsyncData<DataT | undefined, Error>>
      ) => void)
    | null = null;
  let returnPromiseReject: ((reason?: any) => void) | null = null;

  async function makeCall(): Promise<void> {
    status.value = 'pending';
    const fetchPromise = fetchCB(api)
      .then((res) => {
        data.value = res;
        status.value = 'success';

        returnPromiseResolve?.(asyncData);
      })
      .catch((err) => {
        error.value = err;
        status.value = 'error';

        returnPromiseReject?.(err);
      })
      .finally(() => {
        pending.value = false;
      });

    return fetchPromise;
  }

  if (opts?.immediate !== false) {
    makeCall();
  }

  const asyncData: _AsyncData<DataT | undefined, Error> = {
    data: data,
    pending: pending,
    refresh: makeCall,
    execute: makeCall,
    clear() {
      status.value = 'idle';
      error.value = null;
    },
    error: error,
    status: status,
  };

  const returnPromise = new Promise<_AsyncData<DataT | undefined, Error>>(
    (resolve, reject) => {
      returnPromiseResolve = resolve;
      returnPromiseReject = reject;
    }
  );

  // return {
  //   ...asyncData,
  //   ...returnPromise,
  // };

  // Allow directly awaiting on asyncData.
  // https://github.com/nuxt/nuxt/blob/main/packages/nuxt/src/app/composables/asyncData.ts#L396
  const asyncDataPromise = Promise.resolve(returnPromise).then(
    () => asyncData
  ) as AsyncData<DataT, Error>;
  Object.assign(asyncDataPromise, asyncData);

  return asyncDataPromise as AsyncData<DataT, Error>;
}
