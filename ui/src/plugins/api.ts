import { Plugin } from '@nuxt/types';
import * as auth from '~/store/auth';

import { Configuration, ResponseContext } from '@api/runtime';
import {
  AuthApi,
  AuthApiInterface,
  ContactsApi,
  ContactsApiInterface,
  ScoutGroupsApi,
  ScoutGroupsApiInterface,
  ListsApi,
  ListsApiInterface,
  MembersApi,
  MembersApiInterface,
  RolesApi,
  RolesApiInterface,
  SectionsApi,
  SectionsApiInterface,
} from '@api/apis';
import { ErrorCode } from '~/common/app-error';

export interface VueApiInterface {
  auth: AuthApiInterface;
  contacts: ContactsApiInterface;
  scoutGroups: ScoutGroupsApiInterface;
  lists: ListsApiInterface;
  members: MembersApiInterface;
  roles: RolesApiInterface;
  sections: SectionsApiInterface;
}

declare module 'vue/types/vue' {
  interface Vue {
    $api: VueApiInterface;
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $api: VueApiInterface;
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    $api: VueApiInterface;
  }
}

const apiPlugin: Plugin = ({ app, store, env, redirect }, inject) => {
  const configuration = new Configuration({
    basePath: env.API_BASE,
    accessToken: function (name?: string, _scopes?: string[]): string {
      if (name !== 'jwt_auth') {
        console.warn(`Unsupported accessToken type: "${name}"`);
        return '';
      }

      const token = store.state[auth.namespace].authToken || '';

      console.debug(`token:${token}`);
      return token;
    },
    middleware: [
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
            await store.dispatch(`${auth.namespace}/refreshToken`);
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

  const api: VueApiInterface = {
    auth: new AuthApi(configuration),
    contacts: new ContactsApi(configuration),
    scoutGroups: new ScoutGroupsApi(configuration),
    lists: new ListsApi(configuration),
    members: new MembersApi(configuration),
    roles: new RolesApi(configuration),
    sections: new SectionsApi(configuration),
  };

  inject('api', api);
};

export default apiPlugin;
