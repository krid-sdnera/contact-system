import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import { GetScoutGroupsRequest, UpdateScoutGroupByIdRequest } from '@api/apis';
import { ScoutGroupData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'scoutGroup';

export const state = () =>
  ({
    scoutGroups: {},
  } as { scoutGroups: Record<number, ScoutGroupData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getScoutGroupById: (state) => (id: number): ScoutGroupData | null => {
    return state.scoutGroups[id] || null;
  },
};

export const mutations: MutationTree<RootState> = {
  setScoutGroupById: (state, scoutGroup: ScoutGroupData) => {
    Vue.set(state.scoutGroups, scoutGroup.id, scoutGroup);
  },
  setScoutGroups: (state, scoutGroups: Array<ScoutGroupData>) => {
    scoutGroups.forEach((scoutGroup) => {
      Vue.set(state.scoutGroups, scoutGroup.id, scoutGroup);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchScoutGroups({ commit }, options: GetScoutGroupsRequest) {
    const payload = await this.$api.scoutGroups.getScoutGroups(options);
    commit('setScoutGroups', payload.scoutGroups);
  },
  async fetchScoutGroupById({ commit }, scoutGroupId: number) {
    try {
      const payload = await this.$api.scoutGroups.getScoutGroupById({
        scoutGroupId,
      });
      commit('setScoutGroupById', payload);
    } catch (e) {
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to load scout group',
        e
      );
    }
  },
  async updateScoutGroupById(
    { commit },
    { scoutGroupId, scoutGroupInput }: UpdateScoutGroupByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ScoutGroupData = await this.$api.scoutGroups.updateScoutGroupById(
        {
          scoutGroupId,
          scoutGroupInput,
        }
      );
      commit('setScoutGroupById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to update scoutGroup',
        e
      );
    }
  },
};
