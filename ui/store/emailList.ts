import {
  CreateListRequest,
  CreateListRuleByListIdRequest,
  DeleteListByIdRequest,
  DeleteListRuleByListIdRequest,
  GetListRecipientsByListIdRequest,
  GetListRuleByListIdRequest,
  GetListRulesByContactIdRequest,
  GetListRulesByListIdRequest,
  GetListRulesByMemberIdRequest,
  GetListRulesByRoleIdRequest,
  GetListRulesByScoutGroupIdRequest,
  GetListRulesBySectionIdRequest,
  GetListsRequest,
  UpdateListByIdRequest,
  UpdateListRuleByListIdRequest,
} from '@api/apis';
import {
  ListData,
  ListRuleData,
  ListRules,
  Lists,
  ModelApiResponse,
  RecipientData,
  Recipients,
} from '@api/models';
import Vue from 'vue';
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import { AppError, ErrorCode } from '~/common/app-error';
import { fetchAllHelper } from '~/common/store-helpers';

export const namespace = 'emailList';

export const state = () =>
  ({
    emailLists: {},
    rules: {},
    recipients: {},
  } as {
    emailLists: Record<number, ListData>;
    rules: Record<number, ListRuleData>;
    recipients: Record<number, RecipientData>;
  });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getEmailLists: (state): ListData[] => {
    return Object.values(state.emailLists);
  },
  getEmailListById: (state) => (id: number): ListData | null => {
    return state.emailLists[id] || null;
  },
  getEmailListByAddress: (state) => (address: string): ListData | null => {
    const emailList = Object.values(state.emailLists).find(
      (emailList) => emailList.address === address
    );

    return emailList || null;
  },
  getRecipients: (state): RecipientData[] => {
    return Object.values(state.recipients);
  },
  getRecipientsByListId: (state) => (listId: number): RecipientData[] => {
    return Object.values(state.recipients).filter(
      (recipient): boolean => recipient.listId === listId
    );
  },
  getRules: (state): ListRuleData[] => {
    return Object.values(state.rules);
  },
  getRuleById: (state) => (ruleId: number): ListRuleData => {
    return state.rules[ruleId] || null;
  },
  getRulesByListId: (state) => (listId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean => rule.listId === listId
    );
  },
  getRulesByContactId: (state) => (contactId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean =>
        rule.relationType === 'Contact' && rule.relationId === contactId
    );
  },
  getRulesByMemberId: (state) => (memberId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean =>
        rule.relationType === 'Member' && rule.relationId === memberId
    );
  },
  getRulesByRoleId: (state) => (roleId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean =>
        rule.relationType === 'Role' && rule.relationId === roleId
    );
  },
  getRulesBySectionId: (state) => (sectionId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean =>
        rule.relationType === 'Section' && rule.relationId === sectionId
    );
  },
  getRulesByScoutGroupId: (state) => (scoutGroupId: number): ListRuleData[] => {
    return Object.values(state.rules).filter(
      (rule): boolean =>
        rule.relationType === 'ScoutGroup' && rule.relationId === scoutGroupId
    );
  },
};

export const mutations: MutationTree<RootState> = {
  setEmailListById: (state, emailList: ListData) => {
    Vue.set(state.emailLists, emailList.id, emailList);
  },
  removeEmailListById: (state, listId: number) => {
    Vue.delete(state.emailLists, listId);
  },
  setLists: (state, emailLists: Array<ListData>) => {
    emailLists.forEach((emailList) => {
      Vue.set(state.emailLists, emailList.id, emailList);
    });
  },
  setEmailListRuleById: (state, rule: ListRuleData) => {
    Vue.set(state.rules, rule.id, rule);
  },
  removeEmailListRuleById: (state, ruleId: number) => {
    Vue.delete(state.rules, ruleId);
  },
  setListRules: (state, rules: Array<ListRuleData>) => {
    rules.forEach((rule) => {
      Vue.set(state.rules, rule.id, rule);
    });
  },
  setRecipientsById: (state, recipient: RecipientData) => {
    Vue.set(state.recipients, recipient.rowId, recipient);
  },
  removeRecipientsById: (state, recipientRowId: number) => {
    Vue.delete(state.recipients, recipientRowId);
  },
  setRecipients: (state, recipients: Array<RecipientData>) => {
    recipients.forEach((recipient) => {
      Vue.set(state.recipients, recipient.rowId, recipient);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchLists({ commit }, options: GetListsRequest): Promise<Lists> {
    const payload = await this.$api.lists.getLists(options);
    commit('setLists', payload.lists);
    return payload;
  },
  async fetchAllLists({ dispatch }, options: GetListsRequest) {
    return await fetchAllHelper<GetListsRequest, Lists>(
      async (o: GetListsRequest) => dispatch(`fetchLists`, o),
      (pld: Lists) => Array.from(pld.lists).map((x: ListData): number => x.id),
      options
    );
  },
  async fetchEmailListById({ commit }, listId: number) {
    try {
      const payload = await this.$api.lists.getListById({
        listId,
      });
      commit('setEmailListById', payload);
    } catch (e) {
      if (e.status === 404) {
        throw new AppError(ErrorCode.EntityNotFound, `Email list not found`, e);
      } else {
        throw new AppError(
          ErrorCode.InternalError,
          `Unable to load email list: ${e.statusText}`,
          e
        );
      }
    }
  },
  async fetchEmailListByAddress({ commit }, listAddress: string) {
    try {
      const payload = await this.$api.lists.getListByAddress({
        listAddress,
      });
      commit('setEmailListById', payload);
    } catch (e) {
      if (e.status === 404) {
        throw new AppError(ErrorCode.EntityNotFound, `Email list not found`, e);
      } else {
        throw new AppError(
          ErrorCode.InternalError,
          `Unable to load email list: ${e.statusText}`,
          e
        );
      }
    }
  },
  async createEmailList({ commit }, { listInput }: CreateListRequest) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ListData = await this.$api.lists.createList({
        listInput,
      });
      commit('setEmailListById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to create emailList',
        e
      );
    }
  },
  async updateEmailListById(
    { commit },
    { listId, listInput }: UpdateListByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ListData = await this.$api.lists.updateListById({
        listId,
        listInput,
      });
      commit('setEmailListById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to update emailList',
        e
      );
    }
  },
  async deleteEmailListById(
    { commit },
    { listId }: DeleteListByIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.lists.deleteListById({
        listId,
      });
      commit('removeEmailListById', listId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to delete emailList',
        e
      );
    }
  },
  async fetchListRecipientsById(
    { commit },
    options: GetListRecipientsByListIdRequest
  ): Promise<Recipients> {
    const payload = await this.$api.lists.getListRecipientsByListId(options);
    commit('setRecipients', payload.recipients);
    return payload;
  },
  async fetchListRulesByListId(
    { commit },
    options: GetListRulesByListIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.lists.getListRulesByListId(options);
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchListRulesByContactId(
    { commit },
    options: GetListRulesByContactIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.contacts.getListRulesByContactId(options);
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchListRulesByMemberId(
    { commit },
    options: GetListRulesByMemberIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.members.getListRulesByMemberId(options);
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchListRulesByRoleId(
    { commit },
    options: GetListRulesByRoleIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.roles.getListRulesByRoleId(options);
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchListRulesBySectionId(
    { commit },
    options: GetListRulesBySectionIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.sections.getListRulesBySectionId(options);
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchListRulesByScoutGroupId(
    { commit },
    options: GetListRulesByScoutGroupIdRequest
  ): Promise<ListRules> {
    const payload = await this.$api.scoutGroups.getListRulesByScoutGroupId(
      options
    );
    commit('setListRules', payload.rules);
    return payload;
  },
  async fetchEmailListRuleById(
    { commit },
    options: GetListRuleByListIdRequest
  ) {
    try {
      const payload = await this.$api.lists.getListRuleByListId(options);
      commit('setEmailListRuleById', payload);
    } catch (e) {
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to load emailListRule',
        e
      );
    }
  },
  async createEmailListRuleById(
    { commit },
    options: CreateListRuleByListIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ListRuleData = await this.$api.lists.createListRuleByListId(
        options
      );
      commit('setEmailListRuleById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to create emailListRule',
        e
      );
    }
  },
  async updateEmailListRuleById(
    { commit },
    options: UpdateListRuleByListIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ListRuleData = await this.$api.lists.updateListRuleByListId(
        options
      );
      commit('setEmailListRuleById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to update emailListRule',
        e
      );
    }
  },
  async deleteEmailListRuleById(
    { commit },
    options: DeleteListRuleByListIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.lists.deleteListRuleByListId(
        options
      );
      commit('removeEmailListRuleById', options.ruleId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to delete emailListRule',
        e
      );
    }
  },
};
