import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';

export const namespace = 'ui';

export const state = () =>
  ({
    updateApiRequestInProgress: false,
  } as { updateApiRequestInProgress: boolean });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  isAppUpdating: (state): boolean => {
    return state.updateApiRequestInProgress;
  },
  isUpdateApiRequestInProgress: (state): boolean => {
    return state.updateApiRequestInProgress;
  },
};

export const mutations: MutationTree<RootState> = {
  startUpdateApiRequestInProgress: (state) => {
    Vue.set(state, 'updateApiRequestInProgress', true);
  },
  stopUpdateApiRequestInProgress: (state) => {
    Vue.set(state, 'updateApiRequestInProgress', false);
  },
};

export const actions: ActionTree<RootState, RootState> = {};
