import Vue from 'vue';
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
import { AppError, ErrorCode } from '~/common/app-error';

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

const apiPlugin: Plugin = ({ store, env, redirect }, inject) => {
  const configuration = new Configuration({
    basePath: env.API_BASE,
    accessToken: function (name?: string, scopes?: string[]): string {
      if (name !== 'jwt_auth') {
        return '';
      }

      console.log('accessToken', store.state[auth.namespace].authToken);
      if (store.state[auth.namespace].authToken) {
        return store.state[auth.namespace].authToken;
      } else {
        return '';
      }
    },
    middleware: [
      {
        pre: async function () {
          return store.dispatch(`${auth.namespace}/loadToken`);
        },
        post: async function (
          context: ResponseContext
        ): Promise<Response | void> {
          console.log(context.response.status);
          if (200 <= context.response.status && context.response.status < 400) {
            return context.response;
          }
          try {
            await store.dispatch(`${auth.namespace}/refreshToken`);
          } catch (e) {
            if (e.code === ErrorCode.AuthRefreshTokenInvalid) {
              redirect(401, '/login');
            }
            return context.response;
          }

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
