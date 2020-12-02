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
    Contacts,
    ContactsFromJSON,
    ContactsToJSON,
    MemberData,
    MemberDataFromJSON,
    MemberDataToJSON,
    MemberInput,
    MemberInputFromJSON,
    MemberInputToJSON,
    MemberRoleData,
    MemberRoleDataFromJSON,
    MemberRoleDataToJSON,
    MemberRoleInput,
    MemberRoleInputFromJSON,
    MemberRoleInputToJSON,
    MemberRoles,
    MemberRolesFromJSON,
    MemberRolesToJSON,
    Members,
    MembersFromJSON,
    MembersToJSON,
    ModelApiResponse,
    ModelApiResponseFromJSON,
    ModelApiResponseToJSON,
} from '../models';

export interface AddMemberRoleByIdRequest {
    memberId: number;
    roleId: number;
    memberRoleInput?: MemberRoleInput;
}

export interface CreateMemberRequest {
    memberInput: MemberInput;
}

export interface DeleteMemberByIdRequest {
    memberId: number;
}

export interface GetMemberByIdRequest {
    memberId: number;
}

export interface GetMemberContactsByIdRequest {
    memberId: number;
}

export interface GetMemberRolesByIdRequest {
    memberId: number;
}

export interface GetMembersRequest {
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface MergeMemberRequest {
    memberId: number;
    mergeMemberId: number;
}

export interface PatchMemberByIdRequest {
    memberId: number;
    memberInput?: MemberInput;
}

export interface RemoveMemberRoleByIdRequest {
    memberId: number;
    roleId: number;
}

export interface UpdateMemberByIdRequest {
    memberId: number;
    memberInput?: MemberInput;
}

/**
 * MembersApi - interface
 * @export
 * @interface MembersApiInterface
 */
export interface MembersApiInterface {
    /**
     * addMemberRoleById
     * @summary Add Member Role
     * @param {number} memberId 
     * @param {number} roleId 
     * @param {MemberRoleInput} [memberRoleInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    addMemberRoleByIdRaw(requestParameters: AddMemberRoleByIdRequest): Promise<runtime.ApiResponse<MemberRoleData>>;

    /**
     * addMemberRoleById
     * Add Member Role
     */
    addMemberRoleById(requestParameters: AddMemberRoleByIdRequest): Promise<MemberRoleData>;

    /**
     * Create a member
     * @summary Create a member
     * @param {MemberInput} memberInput 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    createMemberRaw(requestParameters: CreateMemberRequest): Promise<runtime.ApiResponse<MemberData>>;

    /**
     * Create a member
     * Create a member
     */
    createMember(requestParameters: CreateMemberRequest): Promise<MemberData>;

    /**
     * Delete a member
     * @summary Delete member
     * @param {number} memberId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    deleteMemberByIdRaw(requestParameters: DeleteMemberByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete a member
     * Delete member
     */
    deleteMemberById(requestParameters: DeleteMemberByIdRequest): Promise<ModelApiResponse>;

    /**
     * Get details for a member
     * @summary Get member
     * @param {number} memberId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    getMemberByIdRaw(requestParameters: GetMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>>;

    /**
     * Get details for a member
     * Get member
     */
    getMemberById(requestParameters: GetMemberByIdRequest): Promise<MemberData>;

    /**
     * List contacts for this member
     * @summary List member\'s contacts
     * @param {number} memberId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    getMemberContactsByIdRaw(requestParameters: GetMemberContactsByIdRequest): Promise<runtime.ApiResponse<Contacts>>;

    /**
     * List contacts for this member
     * List member\'s contacts
     */
    getMemberContactsById(requestParameters: GetMemberContactsByIdRequest): Promise<Contacts>;

    /**
     * List roles for this member
     * @summary List member\'s roles
     * @param {number} memberId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    getMemberRolesByIdRaw(requestParameters: GetMemberRolesByIdRequest): Promise<runtime.ApiResponse<MemberRoles>>;

    /**
     * List roles for this member
     * List member\'s roles
     */
    getMemberRolesById(requestParameters: GetMemberRolesByIdRequest): Promise<MemberRoles>;

    /**
     * List all members
     * @summary List all members
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    getMembersRaw(requestParameters: GetMembersRequest): Promise<runtime.ApiResponse<Members>>;

    /**
     * List all members
     * List all members
     */
    getMembers(requestParameters: GetMembersRequest): Promise<Members>;

    /**
     * Merge member
     * @summary Merge member
     * @param {number} memberId 
     * @param {number} mergeMemberId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    mergeMemberRaw(requestParameters: MergeMemberRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Merge member
     * Merge member
     */
    mergeMember(requestParameters: MergeMemberRequest): Promise<ModelApiResponse>;

    /**
     * Partially update member
     * @summary Partially update member
     * @param {number} memberId 
     * @param {MemberInput} [memberInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    patchMemberByIdRaw(requestParameters: PatchMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>>;

    /**
     * Partially update member
     * Partially update member
     */
    patchMemberById(requestParameters: PatchMemberByIdRequest): Promise<MemberData>;

    /**
     * removeMemberRoleById
     * @summary Remove Member Role
     * @param {number} memberId 
     * @param {number} roleId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    removeMemberRoleByIdRaw(requestParameters: RemoveMemberRoleByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * removeMemberRoleById
     * Remove Member Role
     */
    removeMemberRoleById(requestParameters: RemoveMemberRoleByIdRequest): Promise<ModelApiResponse>;

    /**
     * Update member
     * @summary Update member
     * @param {number} memberId 
     * @param {MemberInput} [memberInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof MembersApiInterface
     */
    updateMemberByIdRaw(requestParameters: UpdateMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>>;

    /**
     * Update member
     * Update member
     */
    updateMemberById(requestParameters: UpdateMemberByIdRequest): Promise<MemberData>;

}

/**
 * no description
 */
export class MembersApi extends runtime.BaseAPI implements MembersApiInterface {

    /**
     * addMemberRoleById
     * Add Member Role
     */
    async addMemberRoleByIdRaw(requestParameters: AddMemberRoleByIdRequest): Promise<runtime.ApiResponse<MemberRoleData>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling addMemberRoleById.');
        }

        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling addMemberRoleById.');
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
            path: `/members/{memberId}/roles/{roleId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))).replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: MemberRoleInputToJSON(requestParameters.memberRoleInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberRoleDataFromJSON(jsonValue));
    }

    /**
     * addMemberRoleById
     * Add Member Role
     */
    async addMemberRoleById(requestParameters: AddMemberRoleByIdRequest): Promise<MemberRoleData> {
        const response = await this.addMemberRoleByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Create a member
     * Create a member
     */
    async createMemberRaw(requestParameters: CreateMemberRequest): Promise<runtime.ApiResponse<MemberData>> {
        if (requestParameters.memberInput === null || requestParameters.memberInput === undefined) {
            throw new runtime.RequiredError('memberInput','Required parameter requestParameters.memberInput was null or undefined when calling createMember.');
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
            path: `/members`,
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
            body: MemberInputToJSON(requestParameters.memberInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberDataFromJSON(jsonValue));
    }

    /**
     * Create a member
     * Create a member
     */
    async createMember(requestParameters: CreateMemberRequest): Promise<MemberData> {
        const response = await this.createMemberRaw(requestParameters);
        return await response.value();
    }

    /**
     * Delete a member
     * Delete member
     */
    async deleteMemberByIdRaw(requestParameters: DeleteMemberByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling deleteMemberById.');
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
            path: `/members/{memberId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete a member
     * Delete member
     */
    async deleteMemberById(requestParameters: DeleteMemberByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteMemberByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get details for a member
     * Get member
     */
    async getMemberByIdRaw(requestParameters: GetMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling getMemberById.');
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
            path: `/members/{memberId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberDataFromJSON(jsonValue));
    }

    /**
     * Get details for a member
     * Get member
     */
    async getMemberById(requestParameters: GetMemberByIdRequest): Promise<MemberData> {
        const response = await this.getMemberByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * List contacts for this member
     * List member\'s contacts
     */
    async getMemberContactsByIdRaw(requestParameters: GetMemberContactsByIdRequest): Promise<runtime.ApiResponse<Contacts>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling getMemberContactsById.');
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
            path: `/members/{memberId}/contacts`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ContactsFromJSON(jsonValue));
    }

    /**
     * List contacts for this member
     * List member\'s contacts
     */
    async getMemberContactsById(requestParameters: GetMemberContactsByIdRequest): Promise<Contacts> {
        const response = await this.getMemberContactsByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * List roles for this member
     * List member\'s roles
     */
    async getMemberRolesByIdRaw(requestParameters: GetMemberRolesByIdRequest): Promise<runtime.ApiResponse<MemberRoles>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling getMemberRolesById.');
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
            path: `/members/{memberId}/roles`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberRolesFromJSON(jsonValue));
    }

    /**
     * List roles for this member
     * List member\'s roles
     */
    async getMemberRolesById(requestParameters: GetMemberRolesByIdRequest): Promise<MemberRoles> {
        const response = await this.getMemberRolesByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * List all members
     * List all members
     */
    async getMembersRaw(requestParameters: GetMembersRequest): Promise<runtime.ApiResponse<Members>> {
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
            path: `/members`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MembersFromJSON(jsonValue));
    }

    /**
     * List all members
     * List all members
     */
    async getMembers(requestParameters: GetMembersRequest): Promise<Members> {
        const response = await this.getMembersRaw(requestParameters);
        return await response.value();
    }

    /**
     * Merge member
     * Merge member
     */
    async mergeMemberRaw(requestParameters: MergeMemberRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling mergeMember.');
        }

        if (requestParameters.mergeMemberId === null || requestParameters.mergeMemberId === undefined) {
            throw new runtime.RequiredError('mergeMemberId','Required parameter requestParameters.mergeMemberId was null or undefined when calling mergeMember.');
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
            path: `/members/{memberId}/merge_into/{mergeMemberId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))).replace(`{${"mergeMemberId"}}`, encodeURIComponent(String(requestParameters.mergeMemberId))),
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Merge member
     * Merge member
     */
    async mergeMember(requestParameters: MergeMemberRequest): Promise<ModelApiResponse> {
        const response = await this.mergeMemberRaw(requestParameters);
        return await response.value();
    }

    /**
     * Partially update member
     * Partially update member
     */
    async patchMemberByIdRaw(requestParameters: PatchMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling patchMemberById.');
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
            path: `/members/{memberId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'PATCH',
            headers: headerParameters,
            query: queryParameters,
            body: MemberInputToJSON(requestParameters.memberInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberDataFromJSON(jsonValue));
    }

    /**
     * Partially update member
     * Partially update member
     */
    async patchMemberById(requestParameters: PatchMemberByIdRequest): Promise<MemberData> {
        const response = await this.patchMemberByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * removeMemberRoleById
     * Remove Member Role
     */
    async removeMemberRoleByIdRaw(requestParameters: RemoveMemberRoleByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling removeMemberRoleById.');
        }

        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling removeMemberRoleById.');
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
            path: `/members/{memberId}/roles/{roleId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))).replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * removeMemberRoleById
     * Remove Member Role
     */
    async removeMemberRoleById(requestParameters: RemoveMemberRoleByIdRequest): Promise<ModelApiResponse> {
        const response = await this.removeMemberRoleByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Update member
     * Update member
     */
    async updateMemberByIdRaw(requestParameters: UpdateMemberByIdRequest): Promise<runtime.ApiResponse<MemberData>> {
        if (requestParameters.memberId === null || requestParameters.memberId === undefined) {
            throw new runtime.RequiredError('memberId','Required parameter requestParameters.memberId was null or undefined when calling updateMemberById.');
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
            path: `/members/{memberId}`.replace(`{${"memberId"}}`, encodeURIComponent(String(requestParameters.memberId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: MemberInputToJSON(requestParameters.memberInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MemberDataFromJSON(jsonValue));
    }

    /**
     * Update member
     * Update member
     */
    async updateMemberById(requestParameters: UpdateMemberByIdRequest): Promise<MemberData> {
        const response = await this.updateMemberByIdRaw(requestParameters);
        return await response.value();
    }

}
