import { GetterTree, ActionTree, MutationTree } from 'vuex';
import { GetMembersRequest } from '@api/apis';
import { MemberData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'member';

export const state = () =>
  ({
    members: {},
  } as { members: Record<number, MemberData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getMemberById: (state) => (id: number): MemberData | null => {
    if (state.members[id]) {
      return state.members[id];
    }
    return null;
  },
};

export const mutations: MutationTree<RootState> = {
  setMemberById: (state, member: MemberData) => {
    // TODO Remove Number
    state.members[Number(member.id)] = member;
  },
  setMembers: (state, members: Array<MemberData>) => {
    members.forEach((member) => {
      // TODO Remove Number
      state.members[Number(member.id)] = member;
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchMembers({ commit }, options: GetMembersRequest) {
    const payload = await this.$api.members.getMembers(options);
    commit('setMembers', payload.members);
  },
  async fetchMemberById({ commit }, memberId: number) {
    try {
      const payload = await this.$api.members.getMemberById({ memberId });
      commit('setMemberById', payload);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load member');
    }
  },
};
