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
    ScoutGroupInput,
    ScoutGroupInputFromJSON,
    ScoutGroupInputToJSON,
    ScoutGroupResponse,
    ScoutGroupResponseFromJSON,
    ScoutGroupResponseToJSON,
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
 * 
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
    createScoutGroupRaw(requestParameters: CreateScoutGroupRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>>;

    /**
     * Create Group
     * Create Group
     */
    createScoutGroup(requestParameters: CreateScoutGroupRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse>;

    /**
     * Delete Group
     * @summary Delete Group
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    deleteScoutGroupByIdRaw(requestParameters: DeleteScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete Group
     * Delete Group
     */
    deleteScoutGroupById(requestParameters: DeleteScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ModelApiResponse>;

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
    getListRulesByScoutGroupIdRaw(requestParameters: GetListRulesByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ListRules>>;

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    getListRulesByScoutGroupId(requestParameters: GetListRulesByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<ListRules>;

    /**
     * Get Group
     * @summary Get Group
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getScoutGroupByIdRaw(requestParameters: GetScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>>;

    /**
     * Get Group
     * Get Group
     */
    getScoutGroupById(requestParameters: GetScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse>;

    /**
     * Get Scout Group Sections By Scout Group ID
     * @summary Get Scout Group Sections By Scout Group ID
     * @param {number} scoutGroupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    getScoutGroupSectionsByScoutGroupIdRaw(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Sections>>;

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    getScoutGroupSectionsByScoutGroupId(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<Sections>;

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
    getScoutGroupsRaw(requestParameters: GetScoutGroupsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroups>>;

    /**
     * Get Groups
     * Get Groups
     */
    getScoutGroups(requestParameters: GetScoutGroupsRequest, initOverrides?: RequestInit): Promise<ScoutGroups>;

    /**
     * Update Group
     * @summary Update Group
     * @param {number} scoutGroupId 
     * @param {ScoutGroupInput} [scoutGroupInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof ScoutGroupsApiInterface
     */
    updateScoutGroupByIdRaw(requestParameters: UpdateScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>>;

    /**
     * Update Group
     * Update Group
     */
    updateScoutGroupById(requestParameters: UpdateScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse>;

}

/**
 * 
 */
export class ScoutGroupsApi extends runtime.BaseAPI implements ScoutGroupsApiInterface {

    /**
     * Create Group
     * Create Group
     */
    async createScoutGroupRaw(requestParameters: CreateScoutGroupRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>> {
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
            path: `/groups`,
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
            body: ScoutGroupInputToJSON(requestParameters.scoutGroupInput),
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupResponseFromJSON(jsonValue));
    }

    /**
     * Create Group
     * Create Group
     */
    async createScoutGroup(requestParameters: CreateScoutGroupRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse> {
        const response = await this.createScoutGroupRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Delete Group
     * Delete Group
     */
    async deleteScoutGroupByIdRaw(requestParameters: DeleteScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling deleteScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete Group
     * Delete Group
     */
    async deleteScoutGroupById(requestParameters: DeleteScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ModelApiResponse> {
        const response = await this.deleteScoutGroupByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    async getListRulesByScoutGroupIdRaw(requestParameters: GetListRulesByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ListRules>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getListRulesByScoutGroupId.');
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
            path: `/groups/{scoutGroupId}/list-rules`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ListRulesFromJSON(jsonValue));
    }

    /**
     * Get List Rules By Scout Group ID
     * Get List Rules By Scout Group ID
     */
    async getListRulesByScoutGroupId(requestParameters: GetListRulesByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<ListRules> {
        const response = await this.getListRulesByScoutGroupIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get Group
     * Get Group
     */
    async getScoutGroupByIdRaw(requestParameters: GetScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupResponseFromJSON(jsonValue));
    }

    /**
     * Get Group
     * Get Group
     */
    async getScoutGroupById(requestParameters: GetScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse> {
        const response = await this.getScoutGroupByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    async getScoutGroupSectionsByScoutGroupIdRaw(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Sections>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling getScoutGroupSectionsByScoutGroupId.');
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
            path: `/groups/{scoutGroupId}/sections`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => SectionsFromJSON(jsonValue));
    }

    /**
     * Get Scout Group Sections By Scout Group ID
     * Get Scout Group Sections By Scout Group ID
     */
    async getScoutGroupSectionsByScoutGroupId(requestParameters: GetScoutGroupSectionsByScoutGroupIdRequest, initOverrides?: RequestInit): Promise<Sections> {
        const response = await this.getScoutGroupSectionsByScoutGroupIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getScoutGroupsRaw(requestParameters: GetScoutGroupsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroups>> {
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
            path: `/groups`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupsFromJSON(jsonValue));
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getScoutGroups(requestParameters: GetScoutGroupsRequest, initOverrides?: RequestInit): Promise<ScoutGroups> {
        const response = await this.getScoutGroupsRaw(requestParameters, initOverrides);
        return await response.value();
    }

    /**
     * Update Group
     * Update Group
     */
    async updateScoutGroupByIdRaw(requestParameters: UpdateScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<ScoutGroupResponse>> {
        if (requestParameters.scoutGroupId === null || requestParameters.scoutGroupId === undefined) {
            throw new runtime.RequiredError('scoutGroupId','Required parameter requestParameters.scoutGroupId was null or undefined when calling updateScoutGroupById.');
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
            path: `/groups/{scoutGroupId}`.replace(`{${"scoutGroupId"}}`, encodeURIComponent(String(requestParameters.scoutGroupId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: ScoutGroupInputToJSON(requestParameters.scoutGroupInput),
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => ScoutGroupResponseFromJSON(jsonValue));
    }

    /**
     * Update Group
     * Update Group
     */
    async updateScoutGroupById(requestParameters: UpdateScoutGroupByIdRequest, initOverrides?: RequestInit): Promise<ScoutGroupResponse> {
        const response = await this.updateScoutGroupByIdRaw(requestParameters, initOverrides);
        return await response.value();
    }

}
