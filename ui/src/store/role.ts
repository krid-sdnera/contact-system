import {
  DeleteRoleByIdRequest,
  GetRolesRequest,
  GetSectionRolesBySectionIdRequest,
  UpdateRoleByIdRequest,
} from '@api/apis';
import { ModelApiResponse, RoleData, Roles } from '@api/models';
import Vue from 'vue';
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import { AppError, ErrorCode } from '~/common/app-error';
import { fetchAllHelper } from '~/common/store-helpers';

export const namespace = 'role';

export const state = () =>
  ({
    roles: {},
  } as { roles: Record<number, RoleData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getRoles: (state): RoleData[] => {
    return Object.values(state.roles);
  },
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
  removeRoleById: (state, roleId: number) => {
    Vue.delete(state.roles, roleId);
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchRoles({ commit }, options: GetRolesRequest) {
    const payload = await this.$api.roles.getRoles(options ?? {});
    commit('setRoles', payload.roles);
    return payload;
  },
  async fetchAllRoles({ dispatch }, options: GetRolesRequest) {
    return await fetchAllHelper<GetRolesRequest, Roles>(
      async (o: GetRolesRequest) => dispatch(`fetchRoles`, o),
      (pld: Roles) => pld.roles.map((x: RoleData): number => x.id),
      options
    );
  },
  async fetchRoleById({ commit }, roleId: number) {
    try {
      const payload = await this.$api.roles.getRoleById({ roleId });
      commit('setRoleById', payload);
    } catch (e) {
      if (e.status === 404) {
        throw new AppError(ErrorCode.EntityNotFound, `Role not found`, e);
      } else {
        throw new AppError(
          ErrorCode.InternalError,
          `Unable to load role: ${e.statusText}`,
          e
        );
      }
    }
  },
  async fetchRolesBySectionId(
    { commit },
    options: GetSectionRolesBySectionIdRequest
  ) {
    try {
      const payload = await this.$api.sections.getSectionRolesBySectionId(
        options
      );
      commit('setRoles', payload.roles);
      return payload;
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load roles', e);
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
  async deleteroleById(
    { commit },
    { roleId }: DeleteRoleByIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.roles.deleteRoleById({
        roleId,
      });
      commit('removeRoleById', roleId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to delete role', e);
    }
  },
};
