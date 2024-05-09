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
 * @interface SectionResponse
 */
export interface SectionResponse {
    /**
     * Whether the request was successful or not
     * @type {boolean}
     * @memberof SectionResponse
     */
    success: boolean;
    /**
     * 
     * @type {SectionData}
     * @memberof SectionResponse
     */
    section: SectionData;
}

export function SectionResponseFromJSON(json: any): SectionResponse {
    return SectionResponseFromJSONTyped(json, false);
}

export function SectionResponseFromJSONTyped(json: any, ignoreDiscriminator: boolean): SectionResponse {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'success': json['success'],
        'section': SectionDataFromJSON(json['section']),
    };
}

export function SectionResponseToJSON(value?: SectionResponse | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'success': value.success,
        'section': SectionDataToJSON(value.section),
    };
}

