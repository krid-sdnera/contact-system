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
    MemberData,
    MemberDataFromJSON,
    MemberDataToJSON,
    ModelApiResponse,
    ModelApiResponseFromJSON,
    ModelApiResponseToJSON,
    ScoutGroupData,
    ScoutGroupDataFromJSON,
    ScoutGroupDataToJSON,
    ScoutGroupInput,
    ScoutGroupInputFromJSON,
    ScoutGroupInputToJSON,
    SectionData,
    SectionDataFromJSON,
    SectionDataToJSON,
} from '../models';

export interface AddGroupLocalMarkerByIdRequest {
    groupId: number;
}

export interface CreateGroupRequest {
    scoutGroupInput?: ScoutGroupInput;
}

export interface DeleteGroupByIdRequest {
    groupId: number;
}

export interface DeleteGroupLocalMarkerByIdRequest {
    groupId: number;
}

export interface GetGroupByIdRequest {
    groupId: number;
}

export interface GetGroupMembersByIdRequest {
    groupId: number;
}

export interface GetGroupSectionsByIdRequest {
    groupId: number;
}

export interface GetGroupsRequest {
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface UpdateGroupByIdRequest {
    groupId: number;
    scoutGroupInput?: ScoutGroupInput;
}

/**
 * GroupsApi - interface
 * @export
 * @interface GroupsApiInterface
 */
export interface GroupsApiInterface {
    /**
     * addGroupLocalMarkerById
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    addGroupLocalMarkerByIdRaw(requestParameters: AddGroupLocalMarkerByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * addGroupLocalMarkerById
     */
    addGroupLocalMarkerById(requestParameters: AddGroupLocalMarkerByIdRequest): Promise<ModelApiResponse>;

    /**
     * Create Group
     * @summary Create Group
     * @param {ScoutGroupInput} [scoutGroupInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    createGroupRaw(requestParameters: CreateGroupRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Create Group
     * Create Group
     */
    createGroup(requestParameters: CreateGroupRequest): Promise<ScoutGroupData>;

    /**
     * Delete Group
     * @summary Delete Group
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    deleteGroupByIdRaw(requestParameters: DeleteGroupByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete Group
     * Delete Group
     */
    deleteGroupById(requestParameters: DeleteGroupByIdRequest): Promise<ModelApiResponse>;

    /**
     * deleteGroupLocalMarkerById
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    deleteGroupLocalMarkerByIdRaw(requestParameters: DeleteGroupLocalMarkerByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * deleteGroupLocalMarkerById
     */
    deleteGroupLocalMarkerById(requestParameters: DeleteGroupLocalMarkerByIdRequest): Promise<ModelApiResponse>;

    /**
     * Get Group
     * @summary Get Group
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    getGroupByIdRaw(requestParameters: GetGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Get Group
     * Get Group
     */
    getGroupById(requestParameters: GetGroupByIdRequest): Promise<ScoutGroupData>;

    /**
     * getGroupMembersById
     * @summary Your GET endpoint
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    getGroupMembersByIdRaw(requestParameters: GetGroupMembersByIdRequest): Promise<runtime.ApiResponse<Array<MemberData>>>;

    /**
     * getGroupMembersById
     * Your GET endpoint
     */
    getGroupMembersById(requestParameters: GetGroupMembersByIdRequest): Promise<Array<MemberData>>;

    /**
     * getGroupSectionsById
     * @summary Your GET endpoint
     * @param {number} groupId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    getGroupSectionsByIdRaw(requestParameters: GetGroupSectionsByIdRequest): Promise<runtime.ApiResponse<Array<SectionData>>>;

    /**
     * getGroupSectionsById
     * Your GET endpoint
     */
    getGroupSectionsById(requestParameters: GetGroupSectionsByIdRequest): Promise<Array<SectionData>>;

    /**
     * Get Groups
     * @summary Get Groups
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    getGroupsRaw(requestParameters: GetGroupsRequest): Promise<runtime.ApiResponse<Array<ScoutGroupData>>>;

    /**
     * Get Groups
     * Get Groups
     */
    getGroups(requestParameters: GetGroupsRequest): Promise<Array<ScoutGroupData>>;

    /**
     * Update Group
     * @summary Update Group
     * @param {number} groupId 
     * @param {ScoutGroupInput} [scoutGroupInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof GroupsApiInterface
     */
    updateGroupByIdRaw(requestParameters: UpdateGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>>;

    /**
     * Update Group
     * Update Group
     */
    updateGroupById(requestParameters: UpdateGroupByIdRequest): Promise<ScoutGroupData>;

}

/**
 * no description
 */
export class GroupsApi extends runtime.BaseAPI implements GroupsApiInterface {

    /**
     * addGroupLocalMarkerById
     */
    async addGroupLocalMarkerByIdRaw(requestParameters: AddGroupLocalMarkerByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling addGroupLocalMarkerById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}/local`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * addGroupLocalMarkerById
     */
    async addGroupLocalMarkerById(requestParameters: AddGroupLocalMarkerByIdRequest): Promise<ModelApiResponse> {
        const response = await this.addGroupLocalMarkerByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Create Group
     * Create Group
     */
    async createGroupRaw(requestParameters: CreateGroupRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
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
    async createGroup(requestParameters: CreateGroupRequest): Promise<ScoutGroupData> {
        const response = await this.createGroupRaw(requestParameters);
        return await response.value();
    }

    /**
     * Delete Group
     * Delete Group
     */
    async deleteGroupByIdRaw(requestParameters: DeleteGroupByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling deleteGroupById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
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
    async deleteGroupById(requestParameters: DeleteGroupByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteGroupByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * deleteGroupLocalMarkerById
     */
    async deleteGroupLocalMarkerByIdRaw(requestParameters: DeleteGroupLocalMarkerByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling deleteGroupLocalMarkerById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}/local`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * deleteGroupLocalMarkerById
     */
    async deleteGroupLocalMarkerById(requestParameters: DeleteGroupLocalMarkerByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteGroupLocalMarkerByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Group
     * Get Group
     */
    async getGroupByIdRaw(requestParameters: GetGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling getGroupById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
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
    async getGroupById(requestParameters: GetGroupByIdRequest): Promise<ScoutGroupData> {
        const response = await this.getGroupByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * getGroupMembersById
     * Your GET endpoint
     */
    async getGroupMembersByIdRaw(requestParameters: GetGroupMembersByIdRequest): Promise<runtime.ApiResponse<Array<MemberData>>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling getGroupMembersById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}/members`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => jsonValue.map(MemberDataFromJSON));
    }

    /**
     * getGroupMembersById
     * Your GET endpoint
     */
    async getGroupMembersById(requestParameters: GetGroupMembersByIdRequest): Promise<Array<MemberData>> {
        const response = await this.getGroupMembersByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * getGroupSectionsById
     * Your GET endpoint
     */
    async getGroupSectionsByIdRaw(requestParameters: GetGroupSectionsByIdRequest): Promise<runtime.ApiResponse<Array<SectionData>>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling getGroupSectionsById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}/sections`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => jsonValue.map(SectionDataFromJSON));
    }

    /**
     * getGroupSectionsById
     * Your GET endpoint
     */
    async getGroupSectionsById(requestParameters: GetGroupSectionsByIdRequest): Promise<Array<SectionData>> {
        const response = await this.getGroupSectionsByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getGroupsRaw(requestParameters: GetGroupsRequest): Promise<runtime.ApiResponse<Array<ScoutGroupData>>> {
        const queryParameters: runtime.HTTPQuery = {};

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

        const response = await this.request({
            path: `/groups`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => jsonValue.map(ScoutGroupDataFromJSON));
    }

    /**
     * Get Groups
     * Get Groups
     */
    async getGroups(requestParameters: GetGroupsRequest): Promise<Array<ScoutGroupData>> {
        const response = await this.getGroupsRaw(requestParameters);
        return await response.value();
    }

    /**
     * Update Group
     * Update Group
     */
    async updateGroupByIdRaw(requestParameters: UpdateGroupByIdRequest): Promise<runtime.ApiResponse<ScoutGroupData>> {
        if (requestParameters.groupId === null || requestParameters.groupId === undefined) {
            throw new runtime.RequiredError('groupId','Required parameter requestParameters.groupId was null or undefined when calling updateGroupById.');
        }

        const queryParameters: runtime.HTTPQuery = {};

        const headerParameters: runtime.HTTPHeaders = {};

        headerParameters['Content-Type'] = 'application/json';

        if (this.configuration && this.configuration.apiKey) {
            headerParameters["x-auth-token"] = this.configuration.apiKey("x-auth-token"); // contact_auth authentication
        }

        const response = await this.request({
            path: `/groups/{groupId}`.replace(`{${"groupId"}}`, encodeURIComponent(String(requestParameters.groupId))),
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
    async updateGroupById(requestParameters: UpdateGroupByIdRequest): Promise<ScoutGroupData> {
        const response = await this.updateGroupByIdRaw(requestParameters);
        return await response.value();
    }

}
