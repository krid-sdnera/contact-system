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
    ScoutGroupData,
    ScoutGroupDataFromJSON,
    ScoutGroupDataFromJSONTyped,
    ScoutGroupDataToJSON,
} from './';

/**
 * 
 * @export
 * @interface SectionData
 */
export interface SectionData {
    /**
     * 
     * @type {number}
     * @memberof SectionData
     */
    id: number;
    /**
     * 
     * @type {string}
     * @memberof SectionData
     */
    name: string;
    /**
     * 
     * @type {string}
     * @memberof SectionData
     */
    externalId?: string;
    /**
     * 
     * @type {ScoutGroupData}
     * @memberof SectionData
     */
    scoutGroup: ScoutGroupData;
}

export function SectionDataFromJSON(json: any): SectionData {
    return SectionDataFromJSONTyped(json, false);
}

export function SectionDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): SectionData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'id': json['id'],
        'name': json['name'],
        'externalId': !exists(json, 'externalId') ? undefined : json['externalId'],
        'scoutGroup': ScoutGroupDataFromJSON(json['scoutGroup']),
    };
}

export function SectionDataToJSON(value?: SectionData | null): any {
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
        'scoutGroup': ScoutGroupDataToJSON(value.scoutGroup),
    };
}


