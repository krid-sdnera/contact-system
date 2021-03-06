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
    RoleData,
    RoleDataFromJSON,
    RoleDataToJSON,
    RoleInput,
    RoleInputFromJSON,
    RoleInputToJSON,
    Roles,
    RolesFromJSON,
    RolesToJSON,
} from '../models';

export interface CreateRoleRequest {
    roleInput?: RoleInput;
}

export interface DeleteRoleByIdRequest {
    roleId: number;
}

export interface GetMembersByRoleIdRequest {
    roleId: number;
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface GetRoleByIdRequest {
    roleId: number;
}

export interface GetRolesRequest {
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

export interface UpdateRoleByIdRequest {
    roleId: number;
    roleInput?: RoleInput;
}

/**
 * RolesApi - interface
 * @export
 * @interface RolesApiInterface
 */
export interface RolesApiInterface {
    /**
     * Create role
     * @summary Create role
     * @param {RoleInput} [roleInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    createRoleRaw(requestParameters: CreateRoleRequest): Promise<runtime.ApiResponse<RoleData>>;

    /**
     * Create role
     * Create role
     */
    createRole(requestParameters: CreateRoleRequest): Promise<RoleData>;

    /**
     * Delete role
     * @summary Delete role
     * @param {number} roleId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    deleteRoleByIdRaw(requestParameters: DeleteRoleByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>>;

    /**
     * Delete role
     * Delete role
     */
    deleteRoleById(requestParameters: DeleteRoleByIdRequest): Promise<ModelApiResponse>;

    /**
     * List all members in this role
     * @summary List members by role
     * @param {number} roleId 
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    getMembersByRoleIdRaw(requestParameters: GetMembersByRoleIdRequest): Promise<runtime.ApiResponse<Members>>;

    /**
     * List all members in this role
     * List members by role
     */
    getMembersByRoleId(requestParameters: GetMembersByRoleIdRequest): Promise<Members>;

    /**
     * Get role
     * @summary Get Role
     * @param {number} roleId 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    getRoleByIdRaw(requestParameters: GetRoleByIdRequest): Promise<runtime.ApiResponse<RoleData>>;

    /**
     * Get role
     * Get Role
     */
    getRoleById(requestParameters: GetRoleByIdRequest): Promise<RoleData>;

    /**
     * Get roles
     * @summary Get roles
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    getRolesRaw(requestParameters: GetRolesRequest): Promise<runtime.ApiResponse<Roles>>;

    /**
     * Get roles
     * Get roles
     */
    getRoles(requestParameters: GetRolesRequest): Promise<Roles>;

    /**
     * Update role
     * @summary Update role
     * @param {number} roleId 
     * @param {RoleInput} [roleInput] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof RolesApiInterface
     */
    updateRoleByIdRaw(requestParameters: UpdateRoleByIdRequest): Promise<runtime.ApiResponse<RoleData>>;

    /**
     * Update role
     * Update role
     */
    updateRoleById(requestParameters: UpdateRoleByIdRequest): Promise<RoleData>;

}

/**
 * no description
 */
export class RolesApi extends runtime.BaseAPI implements RolesApiInterface {

    /**
     * Create role
     * Create role
     */
    async createRoleRaw(requestParameters: CreateRoleRequest): Promise<runtime.ApiResponse<RoleData>> {
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
            path: `/roles`,
            method: 'POST',
            headers: headerParameters,
            query: queryParameters,
            body: RoleInputToJSON(requestParameters.roleInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => RoleDataFromJSON(jsonValue));
    }

    /**
     * Create role
     * Create role
     */
    async createRole(requestParameters: CreateRoleRequest): Promise<RoleData> {
        const response = await this.createRoleRaw(requestParameters);
        return await response.value();
    }

    /**
     * Delete role
     * Delete role
     */
    async deleteRoleByIdRaw(requestParameters: DeleteRoleByIdRequest): Promise<runtime.ApiResponse<ModelApiResponse>> {
        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling deleteRoleById.');
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
            path: `/roles/{roleId}`.replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'DELETE',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => ModelApiResponseFromJSON(jsonValue));
    }

    /**
     * Delete role
     * Delete role
     */
    async deleteRoleById(requestParameters: DeleteRoleByIdRequest): Promise<ModelApiResponse> {
        const response = await this.deleteRoleByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * List all members in this role
     * List members by role
     */
    async getMembersByRoleIdRaw(requestParameters: GetMembersByRoleIdRequest): Promise<runtime.ApiResponse<Members>> {
        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling getMembersByRoleId.');
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
            path: `/roles/{roleId}/members`.replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => MembersFromJSON(jsonValue));
    }

    /**
     * List all members in this role
     * List members by role
     */
    async getMembersByRoleId(requestParameters: GetMembersByRoleIdRequest): Promise<Members> {
        const response = await this.getMembersByRoleIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get role
     * Get Role
     */
    async getRoleByIdRaw(requestParameters: GetRoleByIdRequest): Promise<runtime.ApiResponse<RoleData>> {
        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling getRoleById.');
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
            path: `/roles/{roleId}`.replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => RoleDataFromJSON(jsonValue));
    }

    /**
     * Get role
     * Get Role
     */
    async getRoleById(requestParameters: GetRoleByIdRequest): Promise<RoleData> {
        const response = await this.getRoleByIdRaw(requestParameters);
        return await response.value();
    }

    /**
     * Get roles
     * Get roles
     */
    async getRolesRaw(requestParameters: GetRolesRequest): Promise<runtime.ApiResponse<Roles>> {
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
            path: `/roles`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => RolesFromJSON(jsonValue));
    }

    /**
     * Get roles
     * Get roles
     */
    async getRoles(requestParameters: GetRolesRequest): Promise<Roles> {
        const response = await this.getRolesRaw(requestParameters);
        return await response.value();
    }

    /**
     * Update role
     * Update role
     */
    async updateRoleByIdRaw(requestParameters: UpdateRoleByIdRequest): Promise<runtime.ApiResponse<RoleData>> {
        if (requestParameters.roleId === null || requestParameters.roleId === undefined) {
            throw new runtime.RequiredError('roleId','Required parameter requestParameters.roleId was null or undefined when calling updateRoleById.');
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
            path: `/roles/{roleId}`.replace(`{${"roleId"}}`, encodeURIComponent(String(requestParameters.roleId))),
            method: 'PUT',
            headers: headerParameters,
            query: queryParameters,
            body: RoleInputToJSON(requestParameters.roleInput),
        });

        return new runtime.JSONApiResponse(response, (jsonValue) => RoleDataFromJSON(jsonValue));
    }

    /**
     * Update role
     * Update role
     */
    async updateRoleById(requestParameters: UpdateRoleByIdRequest): Promise<RoleData> {
        const response = await this.updateRoleByIdRaw(requestParameters);
        return await response.value();
    }

}
