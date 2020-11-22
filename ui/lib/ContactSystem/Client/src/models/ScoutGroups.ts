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
 * A list of scout groups
 * @export
 * @interface ScoutGroups
 */
export interface ScoutGroups {
    /**
     * Array containg the list
     * @type {Array<ScoutGroupData>}
     * @memberof ScoutGroups
     */
    scoutGroups: Array<ScoutGroupData>;
}

export function ScoutGroupsFromJSON(json: any): ScoutGroups {
    return ScoutGroupsFromJSONTyped(json, false);
}

export function ScoutGroupsFromJSONTyped(json: any, ignoreDiscriminator: boolean): ScoutGroups {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'scoutGroups': ((json['scoutGroups'] as Array<any>).map(ScoutGroupDataFromJSON)),
    };
}

export function ScoutGroupsToJSON(value?: ScoutGroups | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'scoutGroups': ((value.scoutGroups as Array<any>).map(ScoutGroupDataToJSON)),
    };
}

