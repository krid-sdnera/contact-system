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
    AuditData,
    AuditDataFromJSON,
    AuditDataFromJSONTyped,
    AuditDataToJSON,
} from './';

/**
 * A list of audits
 * @export
 * @interface Audits
 */
export interface Audits {
    /**
     * Total number of items
     * @type {number}
     * @memberof Audits
     */
    totalItems: number;
    /**
     * Total number of pages
     * @type {number}
     * @memberof Audits
     */
    totalPages: number;
    /**
     * Current page number
     * @type {number}
     * @memberof Audits
     */
    page: number;
    /**
     * Number of items in this page
     * @type {number}
     * @memberof Audits
     */
    pageSize: number;
    /**
     * Array containg the list
     * @type {Set<AuditData>}
     * @memberof Audits
     */
    audits: Set<AuditData>;
}

export function AuditsFromJSON(json: any): Audits {
    return AuditsFromJSONTyped(json, false);
}

export function AuditsFromJSONTyped(json: any, ignoreDiscriminator: boolean): Audits {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'totalItems': json['totalItems'],
        'totalPages': json['totalPages'],
        'page': json['page'],
        'pageSize': json['pageSize'],
        'audits': (new Set((json['audits'] as Array<any>).map(AuditDataFromJSON))),
    };
}

export function AuditsToJSON(value?: Audits | null): any {
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
        'audits': (Array.from(value.audits as Set<any>).map(AuditDataToJSON)),
    };
}


