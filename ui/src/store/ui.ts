import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import { AppAlert } from '~/common/alert';

export const namespace = 'ui';

export const state = () =>
  ({
    updateApiRequestInProgress: false,
    alerts: [],
  } as { updateApiRequestInProgress: boolean; alerts: AppAlert[] });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  isAppUpdating: (state): boolean => {
    return state.updateApiRequestInProgress;
  },
  isUpdateApiRequestInProgress: (state): boolean => {
    return state.updateApiRequestInProgress;
  },
  alerts: (state): AppAlert[] => {
    return state.alerts;
  },
};

export const mutations: MutationTree<RootState> = {
  startUpdateApiRequestInProgress: (state) => {
    Vue.set(state, 'updateApiRequestInProgress', true);
  },
  stopUpdateApiRequestInProgress: (state) => {
    Vue.set(state, 'updateApiRequestInProgress', false);
  },
  addAlert: (state, appAlert) => {
    Vue.set(state.alerts, state.alerts.length, appAlert);
  },
  removeAlert: (state, appAlert) => {
    state.alerts.splice(state.alerts.indexOf(appAlert), 1);
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async addAlert({ commit, getters }, appAlert: AppAlert) {
    if (
      appAlert.deduplicate &&
      getters.alerts.find((alert: AppAlert) => alert.equals(appAlert))
    ) {
      // This message is already in the active alert list.
      // TODO: maybe reset the timer, that that would be more involved.
      return;
    }
    commit('addAlert', appAlert);
  },
  async expireAlert({ commit }, appAlert: AppAlert) {
    commit('removeAlert', appAlert);
  },
};
