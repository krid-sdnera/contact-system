import {
  DeleteSectionByIdRequest,
  GetScoutGroupSectionsByIdRequest,
  GetSectionsRequest,
  UpdateSectionByIdRequest,
} from '@api/apis';
import { ModelApiResponse, SectionData, Sections } from '@api/models';
import Vue from 'vue';
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import { AppError, ErrorCode } from '~/common/app-error';
import { fetchAllHelper } from '~/common/store-helpers';

export const namespace = 'section';

export const state = () =>
  ({
    sections: {},
  } as { sections: Record<number, SectionData> });

export type RootState = ReturnType<typeof state>;

export const getters: GetterTree<RootState, RootState> = {
  getSections: (state): SectionData[] => {
    return Object.values(state.sections);
  },
  getSectionById: (state) => (id: number): SectionData | null => {
    return state.sections[id] || null;
  },
  removeSectionById: (state, sectionId: number) => {
    Vue.delete(state.sections, sectionId);
  },
  getSectionsByScoutGroupId: (state) => (id: number): SectionData[] => {
    return Object.values(state.sections).filter(
      (section: SectionData): boolean => section.scoutGroup.id === id
    );
  },
};

export const mutations: MutationTree<RootState> = {
  setSectionById: (state, section: SectionData) => {
    Vue.set(state.sections, section.id, section);
  },
  setSections: (state, sections: Array<SectionData>) => {
    sections.forEach((section) => {
      Vue.set(state.sections, section.id, section);
    });
  },
};

export const actions: ActionTree<RootState, RootState> = {
  async fetchSections({ commit }, options: GetSectionsRequest) {
    const payload = await this.$api.sections.getSections(options);
    commit('setSections', payload.sections);
    return payload;
  },
  async fetchAllSections({ dispatch }, options: GetSectionsRequest) {
    return await fetchAllHelper<GetSectionsRequest, Sections>(
      async (o: GetSectionsRequest) => dispatch(`fetchSections`, o),
      (pld: Sections) => pld.sections.map((x: SectionData): number => x.id),
      options
    );
  },
  async fetchSectionById({ commit }, sectionId: number) {
    try {
      const payload = await this.$api.sections.getSectionById({ sectionId });
      commit('setSectionById', payload);
    } catch (e) {
      if (e.status === 404) {
        throw new AppError(ErrorCode.EntityNotFound, `Section not found`, e);
      } else {
        throw new AppError(
          ErrorCode.InternalError,
          `Unable to load section: ${e.statusText}`,
          e
        );
      }
    }
  },
  async fetchSectionsByScoutGroupId(
    { commit },
    options: GetScoutGroupSectionsByIdRequest
  ) {
    try {
      const payload = await this.$api.scoutGroups.getScoutGroupSectionsById(
        options
      );
      commit('setSections', payload.sections);
      return payload;
    } catch (e) {
      throw new AppError(ErrorCode.InternalError, 'Unable to load sections', e);
    }
  },
  async updateSectionById(
    { commit },
    { sectionId, sectionInput }: UpdateSectionByIdRequest
  ) {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: SectionData = await this.$api.sections.updateSectionById({
        sectionId,
        sectionInput,
      });
      commit('setSectionById', payload);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to update section',
        e
      );
    }
  },
  async deleteSectionById(
    { commit },
    { sectionId }: DeleteSectionByIdRequest
  ): Promise<ModelApiResponse> {
    try {
      commit('ui/startUpdateApiRequestInProgress', null, { root: true });
      const payload: ModelApiResponse = await this.$api.sections.deleteSectionById(
        { sectionId }
      );
      commit('removeSectionById', sectionId);
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      return payload;
    } catch (e) {
      commit('ui/stopUpdateApiRequestInProgress', null, { root: true });
      throw new AppError(
        ErrorCode.InternalError,
        'Unable to delete section',
        e
      );
    }
  },
};
