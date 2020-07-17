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
 * @interface ContactOverrideData
 */
export interface ContactOverrideData {
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    firstname?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    nickname?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    lastname?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    address?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    phoneHome?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    phoneMobile?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    phoneWork?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    relationship?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    primaryContact?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    email?: boolean;
    /**
     * 
     * @type {boolean}
     * @memberof ContactOverrideData
     */
    occupation?: boolean;
}

export function ContactOverrideDataFromJSON(json: any): ContactOverrideData {
    return ContactOverrideDataFromJSONTyped(json, false);
}

export function ContactOverrideDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): ContactOverrideData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'firstname': !exists(json, 'firstname') ? undefined : json['firstname'],
        'nickname': !exists(json, 'nickname') ? undefined : json['nickname'],
        'lastname': !exists(json, 'lastname') ? undefined : json['lastname'],
        'address': !exists(json, 'address') ? undefined : json['address'],
        'phoneHome': !exists(json, 'phoneHome') ? undefined : json['phoneHome'],
        'phoneMobile': !exists(json, 'phoneMobile') ? undefined : json['phoneMobile'],
        'phoneWork': !exists(json, 'phoneWork') ? undefined : json['phoneWork'],
        'relationship': !exists(json, 'relationship') ? undefined : json['relationship'],
        'primaryContact': !exists(json, 'primaryContact') ? undefined : json['primaryContact'],
        'email': !exists(json, 'email') ? undefined : json['email'],
        'occupation': !exists(json, 'occupation') ? undefined : json['occupation'],
    };
}

export function ContactOverrideDataToJSON(value?: ContactOverrideData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'firstname': value.firstname,
        'nickname': value.nickname,
        'lastname': value.lastname,
        'address': value.address,
        'phoneHome': value.phoneHome,
        'phoneMobile': value.phoneMobile,
        'phoneWork': value.phoneWork,
        'relationship': value.relationship,
        'primaryContact': value.primaryContact,
        'email': value.email,
        'occupation': value.occupation,
    };
}


