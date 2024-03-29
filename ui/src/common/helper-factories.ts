import { Store } from 'vuex/types/index';
import { AppAlert, AppAlertOptions } from './alert';
import { AppBreadcrumb, AppBreadcrumbOptions } from './breadcrumb';
import * as ui from '~/store/ui';

export { AppAlertOptions };
export { AppBreadcrumbOptions };
export function createAlert(store: Store<any>, options: AppAlertOptions) {
  store.dispatch(`${ui.namespace}/addAlert`, new AppAlert(options), {
    root: true,
  });
}

export async function setBreadcrumbs(
  store: Store<any>,
  crumbOptions: AppBreadcrumbOptions[]
) {
  return store.dispatch(
    `${ui.namespace}/setBreadcrumbs`,
    crumbOptions.map((crumb) => new AppBreadcrumb(crumb)),
    { root: true }
  );
}

export function apiStatus(store: Store<any>, status: string) {
  store.dispatch(`${ui.namespace}/apiStatusStart`, status, {
    root: true,
  });
  console.time(status);
}
export function apiStatusEnd(store: Store<any>, status: string) {
  store.dispatch(`${ui.namespace}/apiStatusEnd`, status, {
    root: true,
  });
  console.timeEnd(status);
}
