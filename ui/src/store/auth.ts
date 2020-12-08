import { GetterTree, ActionTree, MutationTree } from 'vuex';
import { JwtData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

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
    state.authToken = data.token;
    state.refreshToken = data.refreshToken;
  },
  removeAuthToken: (state) => {
    console.log('Deleting Token');
    state.authToken = null;
    state.refreshToken = null;
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async login({ commit }, options: { username: string; password: string }) {
    const payload = await this.$api.auth.getJWT({
      jwtInput: { username: options.username, password: options.password },
    });
    commit('setAuthToken', payload);
  },
  async refreshToken({ commit, state }) {
    console.log('Refreshing Token');
    if (state.refreshToken) {
      const payload = await this.$api.auth.refreshJWT({
        refreshToken: state.refreshToken,
      });
      commit('setAuthToken', payload);
    } else {
      throw new AppError(
        ErrorCode.AuthRefreshTokenInvalid,
        'Unable to refresh token. Login required.'
      );
    }
  },
  async logout({ commit }) {
    commit('removeAuthToken');
  },
};
