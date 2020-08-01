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
 * A list of sections
 * @export
 * @interface Sections
 */
export interface Sections {
    /**
     * Array containg the list
     * @type {Array<SectionData>}
     * @memberof Sections
     */
    sections: Array<SectionData>;
}

export function SectionsFromJSON(json: any): Sections {
    return SectionsFromJSONTyped(json, false);
}

export function SectionsFromJSONTyped(json: any, ignoreDiscriminator: boolean): Sections {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'sections': ((json['sections'] as Array<any>).map(SectionDataFromJSON)),
    };
}

export function SectionsToJSON(value?: Sections | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'sections': ((value.sections as Array<any>).map(SectionDataToJSON)),
    };
}


