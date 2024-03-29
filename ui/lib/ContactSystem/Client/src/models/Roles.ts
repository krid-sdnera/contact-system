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

import { exists, mapValues } from '../runtime';
import {
    RoleData,
    RoleDataFromJSON,
    RoleDataFromJSONTyped,
    RoleDataToJSON,
} from './';

/**
 * A list of roles
 * @export
 * @interface Roles
 */
export interface Roles {
    /**
     * Total number of items
     * @type {number}
     * @memberof Roles
     */
    totalItems: number;
    /**
     * Total number of pages
     * @type {number}
     * @memberof Roles
     */
    totalPages: number;
    /**
     * Current page number
     * @type {number}
     * @memberof Roles
     */
    page: number;
    /**
     * Number of items in this page
     * @type {number}
     * @memberof Roles
     */
    pageSize: number;
    /**
     * Array containg the list
     * @type {Set<RoleData>}
     * @memberof Roles
     */
    roles: Set<RoleData>;
}

export function RolesFromJSON(json: any): Roles {
    return RolesFromJSONTyped(json, false);
}

export function RolesFromJSONTyped(json: any, ignoreDiscriminator: boolean): Roles {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'totalItems': json['totalItems'],
        'totalPages': json['totalPages'],
        'page': json['page'],
        'pageSize': json['pageSize'],
        'roles': (new Set((json['roles'] as Array<any>).map(RoleDataFromJSON))),
    };
}

export function RolesToJSON(value?: Roles | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'totalItems': value.totalItems,
        'totalPages': value.totalPages,
        'page': value.page,
        'pageSize': value.pageSize,
        'roles': (Array.from(value.roles as Set<any>).map(RoleDataToJSON)),
    };
}


