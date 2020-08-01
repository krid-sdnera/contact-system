import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import { GetRolesRequest, UpdateRoleByIdRequest } from '@api/apis';
import { RoleData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'role';

export const state = () =>
  ({
    roles: {},
  } as { roles: Record<number, RoleData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getRoleById: (state) => (id: number): RoleData | null => {
    return state.roles[id] || null;
  },
  getRolesBySectionId: (state) => (id: number): RoleData[] => {
    return Object.values(state.roles).filter(
      (role: RoleData): boolean => role.section.id === id
    );
  },
};

export const mutations: MutationTree<RootState> = {
  setRoleById: (state, role: RoleData) => {
    Vue.set(state.roles, role.id, role);
  },
  setRoles: (state, roles: Array<RoleData>) => {
    roles.forEach((role) => {
      Vue.set(state.roles, role.id, role);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchRoles({ commit }, options: GetRolesRequest) {
    const payload = await this.$api.roles.getRoles(options);
    commit('setRoles', payload.roles);
  },
  async fetchRoleById({ commit }, roleId: number) {
    try {
      const payload = await this.$api.roles.getRoleById({ roleId });
      commit('setRoleById', payload);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load role', e);
    }
  },
  async fetchRolesBySectionId({ commit }, sectionId: number) {
    try {
      const payload = await this.$api.sections.getSectionRolesById({
        sectionId,
      });
      commit('setRoles', payload.roles);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load sections', e);
    }
  },
  async updateRoleById(
    { commit },
    { roleId, roleInput }: UpdateRoleByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: RoleData = await this.$api.roles.updateRoleById({
        roleId,
        roleInput,
      });
      commit('setRoleById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to update role', e);
    }
  },
};
