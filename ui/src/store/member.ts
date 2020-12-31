import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import {
  GetMembersRequest,
  UpdateMemberByIdRequest,
  PatchMemberByIdRequest,
  CreateMemberRequest,
  AddMemberRoleByIdRequest,
  DeleteMemberByIdRequest,
  RemoveMemberRoleByIdRequest,
} from '@api/apis';
import {
  MemberData,
  MemberRoleData,
  Members,
  ModelApiResponse,
} from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'member';

export const state = () =>
  ({
    members: {},
    roleRelations: {},
  } as {
    members: Record<number, MemberData>;
    roleRelations: Record<string, MemberRoleData>;
  });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getMembers: (state): MemberData[] => {
    return Object.values(state.members);
  },
  getMemberById: (state) => (id: number): MemberData | null => {
    return state.members[id] || null;
  },
  getMembersByRoleId: (state) => (id: number): MemberData[] | null => {
    const memberIds: number[] = Object.values(state.roleRelations)
      .filter((role: MemberRoleData): boolean => role.role.id === id)
      .map((role: MemberRoleData): number => role.memberId);

    return Object.values(state.members).filter((member: MemberData): boolean =>
      memberIds.includes(member.id)
    );
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
  removeMemberById: (state, memberId: number) => {
    Vue.delete(state.members, memberId);
  },
  setMembers: (state, members: Array<MemberData>) => {
    members.forEach((member) => {
      Vue.set(state.members, member.id, member);
    });
  },
  setMemberRoles: (state, roles: MemberRoleData[]) => {
    roles.forEach((role) => {
      Vue.set(state.roleRelations, role.id, role);
    });
  },
  removeMemberRoleById: (state, memberRoleCompositeId: string) => {
    Vue.delete(state.roleRelations, memberRoleCompositeId);
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchMembers({ commit }, options: GetMembersRequest): Promise<Members> {
    const payload = await this.$api.members.getMembers(options);
    commit('setMembers', payload.members);
    return payload;
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
  async fetchMembersByRoleId({ commit }, roleId: number) {
    try {
      // const payload = await this.$api.members.getMembersByRoleId({
      //   roleId,
      // });
      // commit('setMembers', payload.members);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load members', e);
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
  async deleteMemberById(
    { commit },
    { memberId }: DeleteMemberByIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.members.deleteMemberById(
        { memberId }
      );
      commit('removeMemberById', memberId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to delete member', e);
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
  async removeRoleById(
    { commit },
    { memberId, roleId }: RemoveMemberRoleByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.members.removeMemberRoleById(
        {
          memberId,
          roleId,
        }
      );
      commit('removeMemberRoleById', `${memberId}-${roleId}`);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to delete member role',
        e
      );
    }
  },
};
