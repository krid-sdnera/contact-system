import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import {
  GetMembersRequest,
  UpdateMemberByIdRequest,
  PatchMemberByIdRequest,
  CreateMemberRequest,
  AddMemberRoleByIdRequest,
} from '@api/apis';
import { MemberData, MemberRoleData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'member';

export const state = () =>
  ({
    members: {},
    roleRelations: {},
  } as {
    members: Record<number, MemberData>;
    roleRelations: Record<number, MemberRoleData>;
  });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getMembers: (state): MemberData[] => {
    return Object.values(state.members);
  },
  getMemberById: (state) => (id: number): MemberData | null => {
    return state.members[id] || null;
  },
  getRolesByMemberId: (state) => (id: number): MemberRoleData[] => {
    return Object.values(state.roleRelations).filter(
      (role: MemberRoleData): boolean => role.memberId === id
    );
  },
};

export const mutations: MutationTree<RootState> = {
  setMemberById: (state, member: MemberData) => {
    Vue.set(state.members, member.id, member);
  },
  setMembers: (state, members: Array<MemberData>) => {
    members.forEach((member) => {
      Vue.set(state.members, member.id, member);
    });
  },
  setMemberRoles: (state, roles: MemberRoleData[]) => {
    roles.forEach((role) => {
      Vue.set(state.roleRelations, role.memberId + role.role.id, role);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchMembers(
    { commit },
    options: GetMembersRequest
  ): Promise<number[]> {
    const payload = await this.$api.members.getMembers(options);
    commit('setMembers', payload.members);
    return payload.members.map((member: MemberData) => member.id);
  },
  async fetchMemberById({ commit }, memberId: number) {
    try {
      const payload = await this.$api.members.getMemberById({ memberId });
      commit('setMemberById', payload);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load member', e);
    }
  },
  async fetchRolesByMemberId({ commit }, memberId: number) {
    try {
      const payload = await this.$api.members.getMemberRolesById({
        memberId,
      });
      commit('setMemberRoles', payload.roles);
    } catch (e) {
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to load member roles',
        e
      );
    }
  },
  async createMember({ commit }, { memberInput }: CreateMemberRequest) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: MemberData = await this.$api.members.createMember({
        memberInput,
      });
      commit('setMemberById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to create member', e);
    }
  },
  async updateMemberById(
    { commit },
    { memberId, memberInput }: UpdateMemberByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: MemberData = await this.$api.members.updateMemberById({
        memberId,
        memberInput,
      });
      commit('setMemberById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to update member', e);
    }
  },
  async patchMemberById(
    { commit },
    { memberId, memberInput }: PatchMemberByIdRequest
  ): Promise<MemberData> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: MemberData = await this.$api.members.patchMemberById({
        memberId,
        memberInput,
      });
      commit('setMemberById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to patch member', e);
    }
  },

  async addMemberRole(
    { commit },
    { memberId, roleId, memberRoleInput }: AddMemberRoleByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: MemberRoleData = await this.$api.members.addMemberRoleById(
        {
          memberId,
          roleId,
          memberRoleInput,
        }
      );
      commit('setMemberRoles', [payload]);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to create member role',
        e
      );
    }
  },
};
