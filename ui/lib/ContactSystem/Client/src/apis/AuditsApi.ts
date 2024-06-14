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
    Audits,
    AuditsFromJSON,
    AuditsToJSON,
} from '../models';

export interface GetAuditsRequest {
    query?: string;
    sort?: string;
    pageSize?: number;
    page?: number;
}

/**
 * AuditsApi - interface
 * 
 * @export
 * @interface AuditsApiInterface
 */
export interface AuditsApiInterface {
    /**
     * Get Audits
     * @summary Get Audits
     * @param {string} [query] 
     * @param {string} [sort] 
     * @param {number} [pageSize] 
     * @param {number} [page] 
     * @param {*} [options] Override http request option.
     * @throws {RequiredError}
     * @memberof AuditsApiInterface
     */
    getAuditsRaw(requestParameters: GetAuditsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Audits>>;

    /**
     * Get Audits
     * Get Audits
     */
    getAudits(requestParameters: GetAuditsRequest, initOverrides?: RequestInit): Promise<Audits>;

}

/**
 * 
 */
export class AuditsApi extends runtime.BaseAPI implements AuditsApiInterface {

    /**
     * Get Audits
     * Get Audits
     */
    async getAuditsRaw(requestParameters: GetAuditsRequest, initOverrides?: RequestInit): Promise<runtime.ApiResponse<Audits>> {
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
            path: `/audits`,
            method: 'GET',
            headers: headerParameters,
            query: queryParameters,
        }, initOverrides);

        return new runtime.JSONApiResponse(response, (jsonValue) => AuditsFromJSON(jsonValue));
    }

    /**
     * Get Audits
     * Get Audits
     */
    async getAudits(requestParameters: GetAuditsRequest, initOverrides?: RequestInit): Promise<Audits> {
        const response = await this.getAuditsRaw(requestParameters, initOverrides);
        return await response.value();
    }

}
