/* tslint:disable */
/* eslint-disable */
/**
 * Contact System API
 * This is the spec for the Constact system API
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: dirk@arends.com.au
 *
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


import * as runtime from '../runtime';
import {
    ListRules,
    ListRulesFromJSON,
    ListRulesToJSON,
    Members,
    MembersFromJSON,
    MembersToJSON,
    ModelApiResponse,
    ModelApiResponseFromJSON,
    ModelApiResponseToJSON,
    Roles,
    RolesFromJSON,
    RolesToJSON,
    SectionInput,
    SectionInputFromJSON,
    SectionInputToJSON,
    SectionResponse,
    SectionResponseFromJSON,
    SectionResponseToJSON,
    Sections,
    SectionsFromJSON,
    SectionsToJSON,
} from '../models';

export interface CreateSectionRequest {
    sectionInput?: SectionInput;
}

export interface DeleteSectionByIdRequest {
    sectionId: number;
}

export interface GetListRulesBySectionIdRequest {
    sectionId: number;
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface GetMembersBySectionIdRequest {
    sectionId: number;
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface GetSectionByIdRequest {
    sectionId: number;
}

export interface GetSectionRolesBySectionIdRequest {
    sectionId: number;
}

export interface GetSectionsRequest {
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface UpdateSectionByIdRequest {
    sectionId: number;
    sectionInput?: SectionInput;
}

/**
 * SectionsApi - interface
 * 
 * @export
 * @interface SectionsApiInterface
 */
export interface SectionsApiInterface {
    /**
     * Create Section
     * @summary Create Section
     * @param {SectionInput} [sectionInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    createSectionRaw(requestParameters: CreateSectionRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>>;

    /**
     * Create Section
     * Create Section
     */
    createSection(requestParameters: CreateSectionRequest, initOverrides?: RequestInit): Promise<SectionResponse>;

    /**
     * Delete Section
     * @summary Delete Section
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    deleteSectionByIdRaw(requestParameters: DeleteSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete Section
     * Delete Section
     */
    deleteSectionById(requestParameters: DeleteSectionByIdRequest, initOverrides?: RequestInit): Promise<ModelApiResponse>;

    /**
     * Get List Rules By Section ID
     * @summary Get List Rules By Section ID
     * @param {number} sectionId 
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getListRulesBySectionIdRaw(requestParameters: GetListRulesBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ListRules>>;

    /**
     * Get List Rules By Section ID
     * Get List Rules By Section ID
     */
    getListRulesBySectionId(requestParameters: GetListRulesBySectionIdRequest, initOverrides?: RequestInit): Promise<ListRules>;

    /**
     * List all members in this section
     * @summary List members by section
     * @param {number} sectionId 
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getMembersBySectionIdRaw(requestParameters: GetMembersBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Members>>;

    /**
     * List all members in this section
     * List members by section
     */
    getMembersBySectionId(requestParameters: GetMembersBySectionIdRequest, initOverrides?: RequestInit): Promise<Members>;

    /**
     * Get Section
     * @summary Get Section
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getSectionByIdRaw(requestParameters: GetSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>>;

    /**
     * Get Section
     * Get Section
     */
    getSectionById(requestParameters: GetSectionByIdRequest, initOverrides?: RequestInit): Promise<SectionResponse>;

    /**
     * List Section Roles By Section ID
     * @summary List Section Roles By Section ID
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getSectionRolesBySectionIdRaw(requestParameters: GetSectionRolesBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Roles>>;

    /**
     * List Section Roles By Section ID
     * List Section Roles By Section ID
     */
    getSectionRolesBySectionId(requestParameters: GetSectionRolesBySectionIdRequest, initOverrides?: RequestInit): Promise<Roles>;

    /**
     * Get Sections
     * @summary Get Sections
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getSectionsRaw(requestParameters: GetSectionsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Sections>>;

    /**
     * Get Sections
     * Get Sections
     */
    getSections(requestParameters: GetSectionsRequest, initOverrides?: RequestInit): Promise<Sections>;

    /**
     * Update Section
     * @summary Update Section
     * @param {number} sectionId 
     * @param {SectionInput} [sectionInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    updateSectionByIdRaw(requestParameters: UpdateSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>>;

    /**
     * Update Section
     * Update Section
     */
    updateSectionById(requestParameters: UpdateSectionByIdRequest, initOverrides?: RequestInit): Promise<SectionResponse>;

}

/**
 * 
 */
export class SectionsApi extends runtime.BaseAPI implements SectionsApiInterface {

    /**
     * Create Section
     * Create Section
     */
    async createSectionRaw(requestParameters: CreateSectionRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>> {
        const queryParameters: any = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections`,
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
            body: SectionInputToJSON(requestParameters.sectionInput),
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionResponseFromJSON(jsonValue));
    }

    /**
     * Create Section
     * Create Section
     */
    async createSection(requestParameters: CreateSectionRequest, initOverrides?: RequestInit): Promise<SectionResponse> {
        const response = await this.createSectionRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Delete Section
     * Delete Section
     */
    async deleteSectionByIdRaw(requestParameters: DeleteSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling deleteSectionById.');
        }

        const queryParameters: any = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete Section
     * Delete Section
     */
    async deleteSectionById(requestParameters: DeleteSectionByIdRequest, initOverrides?: RequestInit): Promise<ModelApiResponse> {
        const response = await this.deleteSectionByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get List Rules By Section ID
     * Get List Rules By Section ID
     */
    async getListRulesBySectionIdRaw(requestParameters: GetListRulesBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ListRules>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getListRulesBySectionId.');
        }

        const queryParameters: any = {};

        if (requestParameters.query !== undefined) {
            queryParameters['query'] = requestParameters.query;
        }

        if (requestParameters.sort !== undefined) {
            queryParameters['sort'] = requestParameters.sort;
        }

        if (requestParameters.pageSize !== undefined) {
            queryParameters['pageSize'] = requestParameters.pageSize;
        }

        if (requestParameters.page !== undefined) {
            queryParameters['page'] = requestParameters.page;
        }

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}/list-rules`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ListRulesFromJSON(jsonValue));
    }

    /**
     * Get List Rules By Section ID
     * Get List Rules By Section ID
     */
    async getListRulesBySectionId(requestParameters: GetListRulesBySectionIdRequest, initOverrides?: RequestInit): Promise<ListRules> {
        const response = await this.getListRulesBySectionIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * List all members in this section
     * List members by section
     */
    async getMembersBySectionIdRaw(requestParameters: GetMembersBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Members>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getMembersBySectionId.');
        }

        const queryParameters: any = {};

        if (requestParameters.query !== undefined) {
            queryParameters['query'] = requestParameters.query;
        }

        if (requestParameters.sort !== undefined) {
            queryParameters['sort'] = requestParameters.sort;
        }

        if (requestParameters.pageSize !== undefined) {
            queryParameters['pageSize'] = requestParameters.pageSize;
        }

        if (requestParameters.page !== undefined) {
            queryParameters['page'] = requestParameters.page;
        }

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}/members`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => MembersFromJSON(jsonValue));
    }

    /**
     * List all members in this section
     * List members by section
     */
    async getMembersBySectionId(requestParameters: GetMembersBySectionIdRequest, initOverrides?: RequestInit): Promise<Members> {
        const response = await this.getMembersBySectionIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get Section
     * Get Section
     */
    async getSectionByIdRaw(requestParameters: GetSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getSectionById.');
        }

        const queryParameters: any = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionResponseFromJSON(jsonValue));
    }

    /**
     * Get Section
     * Get Section
     */
    async getSectionById(requestParameters: GetSectionByIdRequest, initOverrides?: RequestInit): Promise<SectionResponse> {
        const response = await this.getSectionByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * List Section Roles By Section ID
     * List Section Roles By Section ID
     */
    async getSectionRolesBySectionIdRaw(requestParameters: GetSectionRolesBySectionIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Roles>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getSectionRolesBySectionId.');
        }

        const queryParameters: any = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}/roles`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => RolesFromJSON(jsonValue));
    }

    /**
     * List Section Roles By Section ID
     * List Section Roles By Section ID
     */
    async getSectionRolesBySectionId(requestParameters: GetSectionRolesBySectionIdRequest, initOverrides?: RequestInit): Promise<Roles> {
        const response = await this.getSectionRolesBySectionIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get Sections
     * Get Sections
     */
    async getSectionsRaw(requestParameters: GetSectionsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Sections>> {
        const queryParameters: any = {};

        if (requestParameters.query !== undefined) {
            queryParameters['query'] = requestParameters.query;
        }

        if (requestParameters.sort !== undefined) {
            queryParameters['sort'] = requestParameters.sort;
        }

        if (requestParameters.pageSize !== undefined) {
            queryParameters['pageSize'] = requestParameters.pageSize;
        }

        if (requestParameters.page !== undefined) {
            queryParameters['page'] = requestParameters.page;
        }

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionsFromJSON(jsonValue));
    }

    /**
     * Get Sections
     * Get Sections
     */
    async getSections(requestParameters: GetSectionsRequest, initOverrides?: RequestInit): Promise<Sections> {
        const response = await this.getSectionsRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Update Section
     * Update Section
     */
    async updateSectionByIdRaw(requestParameters: UpdateSectionByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<SectionResponse>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling updateSectionById.');
        }

        const queryParameters: any = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = await token("jwt_auth", []);

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: SectionInputToJSON(requestParameters.sectionInput),
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionResponseFromJSON(jsonValue));
    }

    /**
     * Update Section
     * Update Section
     */
    async updateSectionById(requestParameters: UpdateSectionByIdRequest, initOverrides?: RequestInit): Promise<SectionResponse> {
        const response = await this.updateSectionByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

}
