import { Plugin } from '@nuxt/types';
import createMutationsSharer, {
  LocalStorageStratery,
} from 'vuex-shared-mutations';

const mutationsToShare: string[] = [
  'auth/setAuthToken',
  'auth/removeAuthToken',
];

const vuexSharedMutationPlugin: Plugin = ({ store }) => {
  createMutationsSharer({
    predicate(mutation: { type: string; payload: any }): boolean {
      return mutationsToShare.includes(mutation.type);
    },
    strategy: new LocalStorageStratery(),
  })(store);
};

export default vuexSharedMutationPlugin;
