import { Store } from 'vuex/types/index';

export interface AppAlertOptions {
  heading?: string;
  message: string;
  type?: 'error' | 'warning' | 'success' | 'info';
}

export class AppAlert {
  heading: string | null;
  message: string;
  type: string;
  uniq: string;
  constructor(msg: AppAlertOptions) {
    this.heading = msg.heading || null;
    this.message = msg.message;
    this.type = msg.type || 'info';
    this.uniq = new Date().toISOString();
  }
}

import * as ui from '~/store/ui';

export function createAlert(store: Store<any>, options: AppAlertOptions) {
  store.dispatch(`${ui.namespace}/addAlert`, new AppAlert(options), {
    root: true,
  });
}
