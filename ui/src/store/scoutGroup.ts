import {
  DeleteScoutGroupByIdRequest,
  GetScoutGroupsRequest,
  UpdateScoutGroupByIdRequest,
} from '@api/apis';
import { ModelApiResponse, ScoutGroupData, ScoutGroups } from '@api/models';
import Vue from 'vue';
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import { AppError, ErrorCode } from '~/common/app-error';
import { fetchAllHelper } from '~/common/store-helpers';

export const namespace = 'scoutGroup';

export const state = () =>
  ({
    scoutGroups: {},
  } as { scoutGroups: Record<number, ScoutGroupData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getScoutGroups: (state): ScoutGroupData[] => {
    return Object.values(state.scoutGroups);
  },
  getScoutGroupById: (state) => (id: number): ScoutGroupData | null => {
    return state.scoutGroups[id] || null;
  },
};

export const mutations: MutationTree<RootState> = {
  setScoutGroupById: (state, scoutGroup: ScoutGroupData) => {
    Vue.set(state.scoutGroups, scoutGroup.id, scoutGroup);
  },
  removeScoutGroupById: (state, scoutGroupId: number) => {
    Vue.delete(state.scoutGroups, scoutGroupId);
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
    return payload;
  },
  async fetchAllScoutGroups({ dispatch }, options: GetScoutGroupsRequest) {
    return await fetchAllHelper<GetScoutGroupsRequest, ScoutGroups>(
      async (o: GetScoutGroupsRequest) => dispatch(`fetchScoutGroups`, o),
      (pld: ScoutGroups) =>
        Array.from(pld.scoutGroups).map((x: ScoutGroupData): number => x.id),
      options
    );
  },
  async fetchScoutGroupById({ commit }, scoutGroupId: number) {
    try {
      const payload = await this.$api.scoutGroups.getScoutGroupById({
        scoutGroupId,
      });
      commit('setScoutGroupById', payload);
    } catch (e) {
      if (e.status === 404) {
        throw new AppError(ErrorCode.EntityNotFound, `Group not found`, e);
      } else {
        throw new AppError(
          ErrorCode.InternalError,
          `Unable to load group: ${e.statusText}`,
          e
        );
      }
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
  async deletescoutGroupById(
    { commit },
    { scoutGroupId }: DeleteScoutGroupByIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.scoutGroups.deleteScoutGroupById(
        { scoutGroupId }
      );
      commit('removeScoutGroupById', scoutGroupId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to delete scoutGroup',
        e
      );
    }
  },
};
