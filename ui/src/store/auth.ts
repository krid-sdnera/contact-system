import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import {
  GetContactsRequest,
  UpdateContactByIdRequest,
  PatchContactByIdRequest,
  CreateContactRequest,
  GetJWTRequest,
} from '@api/apis';
import { JwtData, JwtInput, JwtRefreshInput } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'auth';

export const state = () =>
  ({
    authToken: null,
    refreshToken: null,
  } as { authToken: string | null; refreshToken: string | null });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {};

export const mutations: MutationTree<RootState> = {
  setAuthToken: (state, data: JwtData) => {
    state.authToken = data.token;
    state.refreshToken = data.refreshToken;
    localStorage.setItem('user', JSON.stringify(data));
  },
  removeAuthToken: (state) => {
    state.authToken = null;
    state.refreshToken = null;
    // localStorage.removeItem('user');
    localStorage.setItem(
      'user',
      JSON.stringify({ token: '', refreshToken: '' })
    );
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async loadToken({ commit }) {
    const data = localStorage.getItem('user');
    console.log(data);
    if (!data) {
      return;
    }

    const tokens = JSON.parse(data) as JwtData;
    console.log(tokens);
    commit('setAuthToken', tokens);
  },
  async login({ commit }, options: { username: string; password: string }) {
    console.log(options);
    const payload = await this.$api.auth.getJWT({
      jwtInput: { username: options.username, password: options.password },
    });
    commit('setAuthToken', payload);
  },
  async refreshToken({ commit, state }) {
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
