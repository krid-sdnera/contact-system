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
 * @interface AddressData
 */
export interface AddressData {
    /**
     * 
     * @type {string}
     * @memberof AddressData
     */
    street1: string;
    /**
     * 
     * @type {string}
     * @memberof AddressData
     */
    street2?: string;
    /**
     * 
     * @type {string}
     * @memberof AddressData
     */
    city: string;
    /**
     * 
     * @type {string}
     * @memberof AddressData
     */
    state: string;
    /**
     * 
     * @type {string}
     * @memberof AddressData
     */
    postcode: string;
}

export function AddressDataFromJSON(json: any): AddressData {
    return AddressDataFromJSONTyped(json, false);
}

export function AddressDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): AddressData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'street1': json['street1'],
        'street2': !exists(json, 'street2') ? undefined : json['street2'],
        'city': json['city'],
        'state': json['state'],
        'postcode': json['postcode'],
    };
}

export function AddressDataToJSON(value?: AddressData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'street1': value.street1,
        'street2': value.street2,
        'city': value.city,
        'state': value.state,
        'postcode': value.postcode,
    };
}


