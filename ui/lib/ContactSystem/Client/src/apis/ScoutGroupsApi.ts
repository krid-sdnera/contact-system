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
    ModelApiResponse,
    ModelApiResponseFromJSON,
    ModelApiResponseToJSON,
    ScoutGroupData,
    ScoutGroupDataFromJSON,
    ScoutGroupDataToJSON,
    ScoutGroupInput,
    ScoutGroupInputFromJSON,
    ScoutGroupInputToJSON,
    ScoutGroups,
    ScoutGroupsFromJSON,
    ScoutGroupsToJSON,
    Sections,
    SectionsFromJSON,
    SectionsToJSON,
} from '../models';

export interface CreateScoutGroupRequest {
    scoutGroupInput?: ScoutGroupInput;
}

export interface DeleteScoutGroupByIdRequest {
    scoutGroupId: number;
}

export interface GetListRulesByScoutGroupIdRequest {
    scoutGroupId: number;
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface GetScoutGroupByIdRequest {
    scoutGroupId: number;
}

export interface GetScoutGroupSectionsByScoutGroupIdRequest {
    scoutGroupId: number;
}

export interface GetScoutGroupsRequest {
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface UpdateScoutGroupByIdRequest {
    scoutGroupId: number;
    scoutGroupInput?: ScoutGroupInput;
}

/**
 * ScoutGroupsApi - interface
 * @export
 * @interface ScoutGroupsApiInterface
 */
export interface ScoutGroupsApiInterface {
    /**
     * Create Group
     * @summary Create Group
     * @param {ScoutGroupInput} [scoutGroupInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    createScoutGroupRaw(requestParameters: CreateScoutGroupRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Create Group
     * Create Group
     */
    createScoutGroup(requestParameters: CreateScoutGroupRequest): Promise<ScoutGroupData>;

    /**
     * Delete Group
     * @summary Delete Group
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    deleteScoutGroupByIdRaw(requestParameters: DeleteScoutGroupByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete Group
     * Delete Group
     */
    deleteScoutGroupById(requestParameters: DeleteScoutGroupByIdRequest): Promise<ModelApiResponse>;

    /**
     * Get List Rules By Scout Group ID
     * @summary Get List Rules By Scout Group ID
     * @param {number} scoutGroupId 
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getListRulesByScoutGroupIdRaw(requestParameters: GetListRulesByScoutGroupIdRequest): Promise<runtime.ApiResponse<ListRules>>;

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    getListRulesByScoutGroupId(requestParameters: GetListRulesByScoutGroupIdRequest): Promise<ListRules>;

    /**
     * Get Group
     * @summary Get Group
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getScoutGroupByIdRaw(requestParameters: GetScoutGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Get Group
     * Get Group
     */
    getScoutGroupById(requestParameters: GetScoutGroupByIdRequest): Promise<ScoutGroupData>;

    /**
     * Get Scout Group Sections By Scout Group ID
     * @summary Get Scout Group Sections By Scout Group ID
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getScoutGroupSectionsByScoutGroupIdRaw(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest): Promise<runtime.ApiResponse<Sections>>;

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    getScoutGroupSectionsByScoutGroupId(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest): Promise<Sections>;

    /**
     * Get Groups
     * @summary Get Groups
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getScoutGroupsRaw(requestParameters: GetScoutGroupsRequest): Promise<runtime.ApiResponse<ScoutGroups>>;

    /**
     * Get Groups
     * Get Groups
     */
    getScoutGroups(requestParameters: GetScoutGroupsRequest): Promise<ScoutGroups>;

    /**
     * Update Group
     * @summary Update Group
     * @param {number} scoutGroupId 
     * @param {ScoutGroupInput} [scoutGroupInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    updateScoutGroupByIdRaw(requestParameters: UpdateScoutGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Update Group
     * Update Group
     */
    updateScoutGroupById(requestParameters: UpdateScoutGroupByIdRequest): Promise<ScoutGroupData>;

}

/**
 * no description
 */
export class ScoutGroupsApi extends runtime.BaseAPI implements ScoutGroupsApiInterface {

    /**
     * Create Group
     * Create Group
     */
    async createScoutGroupRaw(requestParameters: CreateScoutGroupRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
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
            path: `/groups`,
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
            body: ScoutGroupInputToJSON(requestParameters.scoutGroupInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupDataFromJSON(jsonValue));
    }

    /**
     * Create Group
     * Create Group
     */
    async createScoutGroup(requestParameters: CreateScoutGroupRequest): Promise<ScoutGroupData> {
        const response = await this.createScoutGroupRaw(requestParameters);
        return await response.value();
    }

    /**
     * Delete Group
     * Delete Group
     */
    async deleteScoutGroupByIdRaw(requestParameters: DeleteScoutGroupByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling deleteScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete Group
     * Delete Group
     */
    async deleteScoutGroupById(requestParameters: DeleteScoutGroupByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteScoutGroupByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    async getListRulesByScoutGroupIdRaw(requestParameters: GetListRulesByScoutGroupIdRequest): Promise<runtime.ApiResponse<ListRules>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getListRulesByScoutGroupId.');
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
            path: `/groups/{scoutGroupId}/list-rules`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ListRulesFromJSON(jsonValue));
    }

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    async getListRulesByScoutGroupId(requestParameters: GetListRulesByScoutGroupIdRequest): Promise<ListRules> {
        const response = await this.getListRulesByScoutGroupIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Group
     * Get Group
     */
    async getScoutGroupByIdRaw(requestParameters: GetScoutGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupDataFromJSON(jsonValue));
    }

    /**
     * Get Group
     * Get Group
     */
    async getScoutGroupById(requestParameters: GetScoutGroupByIdRequest): Promise<ScoutGroupData> {
        const response = await this.getScoutGroupByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    async getScoutGroupSectionsByScoutGroupIdRaw(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest): Promise<runtime.ApiResponse<Sections>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getScoutGroupSectionsByScoutGroupId.');
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
            path: `/groups/{scoutGroupId}/sections`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionsFromJSON(jsonValue));
    }

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    async getScoutGroupSectionsByScoutGroupId(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest): Promise<Sections> {
        const response = await this.getScoutGroupSectionsByScoutGroupIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getScoutGroupsRaw(requestParameters: GetScoutGroupsRequest): Promise<runtime.ApiResponse<ScoutGroups>> {
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
            path: `/groups`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupsFromJSON(jsonValue));
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getScoutGroups(requestParameters: GetScoutGroupsRequest): Promise<ScoutGroups> {
        const response = await this.getScoutGroupsRaw(requestParameters);
        return await response.value();
    }

    /**
     * Update Group
     * Update Group
     */
    async updateScoutGroupByIdRaw(requestParameters: UpdateScoutGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling updateScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: ScoutGroupInputToJSON(requestParameters.scoutGroupInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupDataFromJSON(jsonValue));
    }

    /**
     * Update Group
     * Update Group
     */
    async updateScoutGroupById(requestParameters: UpdateScoutGroupByIdRequest): Promise<ScoutGroupData> {
        const response = await this.updateScoutGroupByIdRaw(requestParameters);
        return await response.value();
    }

}
