import {
  Configuration,
  type ResponseContext,
} from '~/lib/ContactSystem/Client/src/runtime';
import {
  AuthApi,
  type AuthApiInterface,
  ContactsApi,
  type ContactsApiInterface,
  ScoutGroupsApi,
  type ScoutGroupsApiInterface,
  ListsApi,
  type ListsApiInterface,
  MembersApi,
  type MembersApiInterface,
  RolesApi,
  type RolesApiInterface,
  SectionsApi,
  type SectionsApiInterface,
} from '~/lib/ContactSystem/Client/src/apis';

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

          const response = await configuration.fetchApi(
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
