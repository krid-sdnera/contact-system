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
    MemberRoleData,
    MemberRoleDataFromJSON,
    MemberRoleDataFromJSONTyped,
    MemberRoleDataToJSON,
} from './';

/**
 * A list of roles
 * @export
 * @interface MemberRoles
 */
export interface MemberRoles {
    /**
     * Array containg the list
     * @type {Array<MemberRoleData>}
     * @memberof MemberRoles
     */
    roles: Array<MemberRoleData>;
}

export function MemberRolesFromJSON(json: any): MemberRoles {
    return MemberRolesFromJSONTyped(json, false);
}

export function MemberRolesFromJSONTyped(json: any, ignoreDiscriminator: boolean): MemberRoles {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'roles': ((json['roles'] as Array<any>).map(MemberRoleDataFromJSON)),
    };
}

export function MemberRolesToJSON(value?: MemberRoles | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'roles': ((value.roles as Array<any>).map(MemberRoleDataToJSON)),
    };
}

