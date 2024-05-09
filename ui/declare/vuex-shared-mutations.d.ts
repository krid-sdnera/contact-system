declare module 'vuex-shared-mutations' {
  import { Store } from 'vuex/types/index';

  export default function createMutationsSharer(options: {
    predicate?:
      | string[]
      | ((mutation: { type: string; payload: any }) => boolean);
    strategy?: any;
    // ...rest
  }): (store: Store<any>) => void;

  export class LocalStorageStratery {}
}
