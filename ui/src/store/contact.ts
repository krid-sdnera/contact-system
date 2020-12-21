import Vue from 'vue';
import { GetterTree, ActionTree, MutationTree } from 'vuex';
import {
  GetContactsRequest,
  UpdateContactByIdRequest,
  PatchContactByIdRequest,
  CreateContactRequest,
} from '@api/apis';
import { ContactData } from '@api/models';
import { AppError, ErrorCode } from '~/common/app-error';

export const namespace = 'contact';

export const state = () =>
  ({
    contacts: {},
  } as { contacts: Record<number, ContactData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getContacts: (state): ContactData[] => {
    return Object.values(state.contacts);
  },
  getContactById: (state) => (id: number): ContactData | null => {
    return state.contacts[id] || null;
  },
  getContactsByMemberId: (state) => (id: number): ContactData[] => {
    return Object.values(state.contacts).filter(
      (contact: ContactData): boolean => contact.memberId === id
    );
  },
};

export const mutations: MutationTree<RootState> = {
  setContactById: (state, contact: ContactData) => {
    Vue.set(state.contacts, contact.id, contact);
  },
  setContacts: (state, contacts: Array<ContactData>) => {
    contacts.forEach((contact) => {
      Vue.set(state.contacts, contact.id, contact);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchContacts({ commit }, options: GetContactsRequest) {
    const payload = await this.$api.contacts.getContacts(options);
    commit('setContacts', payload.contacts);
    return payload;
  },
  async fetchContactById({ commit }, contactId: number) {
    try {
      const payload = await this.$api.contacts.getContactById({ contactId });
      commit('setContactById', payload);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load contact', e);
    }
  },
  async fetchContactsByMemberId({ commit }, memberId: number) {
    try {
      const payload = await this.$api.members.getMemberContactsById({
        memberId,
      });
      commit('setContacts', payload.contacts);
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load contacts', e);
    }
  },
  async createContact({ commit }, { contactInput }: CreateContactRequest) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ContactData = await this.$api.contacts.createContact({
        contactInput,
      });
      commit('setContactById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to create contact',
        e
      );
    }
  },
  async updateContactById(
    { commit },
    { contactId, contactInput }: UpdateContactByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ContactData = await this.$api.contacts.updateContactById({
        contactId,
        contactInput,
      });
      commit('setContactById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to update contact',
        e
      );
    }
  },
  async patchContactById(
    { commit },
    { contactId, contactInput }: PatchContactByIdRequest
  ): Promise<ContactData> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ContactData = await this.$api.contacts.patchContactById({
        contactId,
        contactInput,
      });
      commit('setContactById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(ErrorCode.InternalError, 'Unable to patch contact', e);
    }
  },
};
