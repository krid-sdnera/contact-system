import { JwtData } from '@api/models';
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import { createAlert } from '~/common/alert';

export const namespace = 'auth';

export const state = () =>
  ({
    authToken: null,
    refreshToken: null,
  } as { authToken: string | null; refreshToken: string | null });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  isLoggedIn: (state): boolean => {
    return state.authToken !== null;
  },
};

export const mutations: MutationTree<RootState> = {
  setAuthToken: (state, data: JwtData) => {
    console.log('Storing Token');
    if ('token' in data && 'refreshToken' in data) {
      state.authToken = data.token;
      state.refreshToken = data.refreshToken;
      return;
    }
    throw new Error('Invalid token shape');
  },
  removeAuthToken: (state) => {
    console.log('Deleting Token');
    state.authToken = null;
    state.refreshToken = null;
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async login({ commit }, options: { username: string; password: string }) {
    try {
      const payload = await this.$api.auth.getJWT({
        jwtInput: { username: options.username, password: options.password },
      });
      commit('setAuthToken', payload);
      createAlert(this, {
        message: 'Login successful',
        type: 'success',
      });
    } catch (e) {
      if (e.status === 401) {
        createAlert(this, {
          message: 'Username and password are incorrect.',
          type: 'warning',
        });
      }
    }
  },
  async refreshToken({ commit, state }) {
    const failureFn = () => {
      commit('removeAuthToken');

      this.$router.push('/login');

      createAlert(this, {
        message: 'Session expired. Please login again.',
        type: 'error',
        deduplicate: true,
      });
    };

    console.log('Refreshing Token');
    if (!state.refreshToken) {
      failureFn();
      return;
    }

    try {
      const payload = await this.$api.auth.refreshJWT({
        refreshToken: state.refreshToken,
      });
      commit('setAuthToken', payload);

      // Don't tell the user that we refreshed their token.
      // It should be transparent to them.
    } catch (e) {
      // Tell user that we could not refresh the token.
      failureFn();
    }
  },
  async logout({ commit }) {
    commit('removeAuthToken');

    this.$router.push('/login');

    // Tell user they are logged out
    createAlert(this, {
      message: 'Logout successful',
      type: 'success',
    });
  },
};
