import Vue from 'vue';
import { Plugin } from '@nuxt/types';

import { Configuration } from '@api/runtime';
import {
  ContactsApi,
  ContactsApiInterface,
  GroupsApi,
  GroupsApiInterface,
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
  contacts: ContactsApiInterface;
  groups: GroupsApiInterface;
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
    apiKey: env.API_TOKEN,
  });

  const api: VueApiInterface = {
    contacts: new ContactsApi(configuration),
    groups: new GroupsApi(configuration),
    lists: new ListsApi(configuration),
    members: new MembersApi(configuration),
    roles: new RolesApi(configuration),
    sections: new SectionsApi(configuration),
  };

  inject('api', api);
};

export default apiPlugin;
