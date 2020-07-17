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
 * 
 * @export
 * @interface MemberRoleData
 */
export interface MemberRoleData {
    /**
     * 
     * @type {string}
     * @memberof MemberRoleData
     */
    state?: MemberRoleDataStateEnum;
    /**
     * 
     * @type {string}
     * @memberof MemberRoleData
     */
    managementState?: MemberRoleDataManagementStateEnum;
    /**
     * 
     * @type {string}
     * @memberof MemberRoleData
     */
    expiry?: string;
    /**
     * 
     * @type {RoleData}
     * @memberof MemberRoleData
     */
    role?: RoleData;
}

export function MemberRoleDataFromJSON(json: any): MemberRoleData {
    return MemberRoleDataFromJSONTyped(json, false);
}

export function MemberRoleDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): MemberRoleData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'state': !exists(json, 'state') ? undefined : json['state'],
        'managementState': !exists(json, 'managementState') ? undefined : json['managementState'],
        'expiry': !exists(json, 'expiry') ? undefined : json['expiry'],
        'role': !exists(json, 'role') ? undefined : RoleDataFromJSON(json['role']),
    };
}

export function MemberRoleDataToJSON(value?: MemberRoleData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'state': value.state,
        'managementState': value.managementState,
        'expiry': value.expiry,
        'role': RoleDataToJSON(value.role),
    };
}

/**
* @export
* @enum {string}
*/
export enum MemberRoleDataStateEnum {
    Enabled = 'enabled',
    Disabled = 'disabled'
}
/**
* @export
* @enum {string}
*/
export enum MemberRoleDataManagementStateEnum {
    Managed = 'managed',
    Unmanaged = 'unmanaged'
}


