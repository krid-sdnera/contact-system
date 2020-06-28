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
/**
 * 
 * @export
 * @interface MemberSuggetion
 */
export interface MemberSuggetion {
    /**
     * 
     * @type {string}
     * @memberof MemberSuggetion
     */
    id?: string;
}

export function MemberSuggetionFromJSON(json: any): MemberSuggetion {
    return MemberSuggetionFromJSONTyped(json, false);
}

export function MemberSuggetionFromJSONTyped(json: any, ignoreDiscriminator: boolean): MemberSuggetion {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'id': !exists(json, 'id') ? undefined : json['id'],
    };
}

export function MemberSuggetionToJSON(value?: MemberSuggetion | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'id': value.id,
    };
}


