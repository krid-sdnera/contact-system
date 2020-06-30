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
    SectionData,
    SectionDataFromJSON,
    SectionDataFromJSONTyped,
    SectionDataToJSON,
} from './';

/**
 * 
 * @export
 * @interface RoleData
 */
export interface RoleData {
    /**
     * 
     * @type {string}
     * @memberof RoleData
     */
    id: string;
    /**
     * 
     * @type {string}
     * @memberof RoleData
     */
    name: string;
    /**
     * 
     * @type {string}
     * @memberof RoleData
     */
    externalId?: string;
    /**
     * 
     * @type {SectionData}
     * @memberof RoleData
     */
    section: SectionData;
}

export function RoleDataFromJSON(json: any): RoleData {
    return RoleDataFromJSONTyped(json, false);
}

export function RoleDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): RoleData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'id': json['id'],
        'name': json['name'],
        'externalId': !exists(json, 'externalId') ? undefined : json['externalId'],
        'section': SectionDataFromJSON(json['section']),
    };
}

export function RoleDataToJSON(value?: RoleData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'id': value.id,
        'name': value.name,
        'externalId': value.externalId,
        'section': SectionDataToJSON(value.section),
    };
}

