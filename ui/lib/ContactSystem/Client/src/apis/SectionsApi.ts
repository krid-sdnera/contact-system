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
    Members,
    MembersFromJSON,
    MembersToJSON,
    ModelApiResponse,
    ModelApiResponseFromJSON,
    ModelApiResponseToJSON,
    Roles,
    RolesFromJSON,
    RolesToJSON,
    SectionData,
    SectionDataFromJSON,
    SectionDataToJSON,
    SectionInput,
    SectionInputFromJSON,
    SectionInputToJSON,
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

export interface GetSectionRolesByIdRequest {
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
    createSectionRaw(requestParameters: CreateSectionRequest): Promise<runtime.ApiResponse<SectionData>>;

    /**
     * Create Section
     * Create Section
     */
    createSection(requestParameters: CreateSectionRequest): Promise<SectionData>;

    /**
     * Delete Section
     * @summary Delete Section
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    deleteSectionByIdRaw(requestParameters: DeleteSectionByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete Section
     * Delete Section
     */
    deleteSectionById(requestParameters: DeleteSectionByIdRequest): Promise<ModelApiResponse>;

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
    getMembersBySectionIdRaw(requestParameters: GetMembersBySectionIdRequest): Promise<runtime.ApiResponse<Members>>;

    /**
     * List all members in this section
     * List members by section
     */
    getMembersBySectionId(requestParameters: GetMembersBySectionIdRequest): Promise<Members>;

    /**
     * Get Section
     * @summary Get Section
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getSectionByIdRaw(requestParameters: GetSectionByIdRequest): Promise<runtime.ApiResponse<SectionData>>;

    /**
     * Get Section
     * Get Section
     */
    getSectionById(requestParameters: GetSectionByIdRequest): Promise<SectionData>;

    /**
     * Your GET endpoint
     * @summary Your GET endpoint
     * @param {number} sectionId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    getSectionRolesByIdRaw(requestParameters: GetSectionRolesByIdRequest): Promise<runtime.ApiResponse<Roles>>;

    /**
     * Your GET endpoint
     * Your GET endpoint
     */
    getSectionRolesById(requestParameters: GetSectionRolesByIdRequest): Promise<Roles>;

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
    getSectionsRaw(requestParameters: GetSectionsRequest): Promise<runtime.ApiResponse<Sections>>;

    /**
     * Get Sections
     * Get Sections
     */
    getSections(requestParameters: GetSectionsRequest): Promise<Sections>;

    /**
     * Update Section
     * @summary Update Section
     * @param {number} sectionId 
     * @param {SectionInput} [sectionInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof SectionsApiInterface
     */
    updateSectionByIdRaw(requestParameters: UpdateSectionByIdRequest): Promise<runtime.ApiResponse<SectionData>>;

    /**
     * Update Section
     * Update Section
     */
    updateSectionById(requestParameters: UpdateSectionByIdRequest): Promise<SectionData>;

}

/**
 * no description
 */
export class SectionsApi extends runtime.BaseAPI implements SectionsApiInterface {

    /**
     * Create Section
     * Create Section
     */
    async createSectionRaw(requestParameters: CreateSectionRequest): Promise<runtime.ApiResponse<SectionData>> {
        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

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
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionDataFromJSON(jsonValue));
    }

    /**
     * Create Section
     * Create Section
     */
    async createSection(requestParameters: CreateSectionRequest): Promise<SectionData> {
        const response = await this.createSectionRaw(requestParameters);
        return await response.value();
    }

    /**
     * Delete Section
     * Delete Section
     */
    async deleteSectionByIdRaw(requestParameters: DeleteSectionByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling deleteSectionById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete Section
     * Delete Section
     */
    async deleteSectionById(requestParameters: DeleteSectionByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteSectionByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * List all members in this section
     * List members by section
     */
    async getMembersBySectionIdRaw(requestParameters: GetMembersBySectionIdRequest): Promise<runtime.ApiResponse<Members>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getMembersBySectionId.');
        }

        const queryParameters: runtime.HTTPQuery = {};

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
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}/members`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MembersFromJSON(jsonValue));
    }

    /**
     * List all members in this section
     * List members by section
     */
    async getMembersBySectionId(requestParameters: GetMembersBySectionIdRequest): Promise<Members> {
        const response = await this.getMembersBySectionIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Section
     * Get Section
     */
    async getSectionByIdRaw(requestParameters: GetSectionByIdRequest): Promise<runtime.ApiResponse<SectionData>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getSectionById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionDataFromJSON(jsonValue));
    }

    /**
     * Get Section
     * Get Section
     */
    async getSectionById(requestParameters: GetSectionByIdRequest): Promise<SectionData> {
        const response = await this.getSectionByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Your GET endpoint
     * Your GET endpoint
     */
    async getSectionRolesByIdRaw(requestParameters: GetSectionRolesByIdRequest): Promise<runtime.ApiResponse<Roles>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling getSectionRolesById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections/{sectionId}/roles`.replace(`{${"sectionId"}}`, encodeURIComponent(String(requestParameters.sectionId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => RolesFromJSON(jsonValue));
    }

    /**
     * Your GET endpoint
     * Your GET endpoint
     */
    async getSectionRolesById(requestParameters: GetSectionRolesByIdRequest): Promise<Roles> {
        const response = await this.getSectionRolesByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Sections
     * Get Sections
     */
    async getSectionsRaw(requestParameters: GetSectionsRequest): Promise<runtime.ApiResponse<Sections>> {
        const queryParameters: runtime.HTTPQuery = {};

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
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

            if (tokenString) {
                headerParameters["Authorization"] = `Bearer ${tokenString}`;
            }
        }
        const response = await this.request({
            path: `/sections`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionsFromJSON(jsonValue));
    }

    /**
     * Get Sections
     * Get Sections
     */
    async getSections(requestParameters: GetSectionsRequest): Promise<Sections> {
        const response = await this.getSectionsRaw(requestParameters);
        return await response.value();
    }

    /**
     * Update Section
     * Update Section
     */
    async updateSectionByIdRaw(requestParameters: UpdateSectionByIdRequest): Promise<runtime.ApiResponse<SectionData>> {
        if (requestParameters.sectionId === null || requestParameters.sectionId === undefined) {
            throw new runtime.RequiredError('sectionId','Required parameter requestParameters.sectionId was null or undefined when calling updateSectionById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        if (this.configuration && this.configuration.accessToken) {
            const token = this.configuration.accessToken;
            const tokenString = typeof token === 'function' ? token("jwt_auth", []) : token;

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
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionDataFromJSON(jsonValue));
    }

    /**
     * Update Section
     * Update Section
     */
    async updateSectionById(requestParameters: UpdateSectionByIdRequest): Promise<SectionData> {
        const response = await this.updateSectionByIdRaw(requestParameters);
        return await response.value();
    }

}
