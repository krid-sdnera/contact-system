import { Plugin } from '@nuxt/types';
import { createAlert } from '~/common/alert';
import * as auth from '~/store/auth';

const routerAuth: Plugin = ({ app, store }) => {
  app.router!.beforeEach((to, from, next) => {
    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = store.getters[`${auth.namespace}/isLoggedIn`];

    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn) {
      createAlert(store, {
        message: 'Session expired. Please login again',
        type: 'error',
        deduplicate: true,
      });

      next('/login');
    } else {
      next();
    }
  });
};

export default routerAuth;
