import { Plugin } from '@nuxt/types';
import VuexPersistence from 'vuex-persist';
import { RootState } from '~/store';

const vuexPesistPlugin: Plugin = ({ store }) => {
  new VuexPersistence<RootState>({
    storage: window.localStorage,
    modules: ['auth'],
  }).plugin(store);
};

export default vuexPesistPlugin;
