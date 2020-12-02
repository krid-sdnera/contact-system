import Vue from 'vue';
import { Plugin } from '@nuxt/types';

import { Configuration } from '@api/runtime';
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

const apiPlugin: Plugin = ({ env }, inject) => {
  const configuration = new Configuration({
    basePath: env.API_BASE,
    accessToken: function (name?: string, scopes?: string[]): string {
      return '';
    },
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
