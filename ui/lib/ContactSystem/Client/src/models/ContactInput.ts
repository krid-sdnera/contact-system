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
    AddressData,
    AddressDataFromJSON,
    AddressDataFromJSONTyped,
    AddressDataToJSON,
    ContactOverrideData,
    ContactOverrideDataFromJSON,
    ContactOverrideDataFromJSONTyped,
    ContactOverrideDataToJSON,
} from './';

/**
 * 
 * @export
 * @interface ContactInput
 */
export interface ContactInput {
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    state?: ContactInputStateEnum;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    firstname: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    nickname?: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    lastname: string;
    /**
     * 
     * @type {AddressData}
     * @memberof ContactInput
     */
    address?: AddressData;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    phoneHome?: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    phoneMobile?: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    phoneWork?: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    relationship?: string;
    /**
     * 
     * @type {boolean}
     * @memberof ContactInput
     */
    primaryContact?: boolean;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    email?: string;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    occupation?: string;
    /**
     * 
     * @type {number}
     * @memberof ContactInput
     */
    memberId?: number;
    /**
     * 
     * @type {string}
     * @memberof ContactInput
     */
    expiry?: string;
    /**
     * 
     * @type {ContactOverrideData}
     * @memberof ContactInput
     */
    overrides?: ContactOverrideData;
}

export function ContactInputFromJSON(json: any): ContactInput {
    return ContactInputFromJSONTyped(json, false);
}

export function ContactInputFromJSONTyped(json: any, ignoreDiscriminator: boolean): ContactInput {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'state': !exists(json, 'state') ? undefined : json['state'],
        'firstname': json['firstname'],
        'nickname': !exists(json, 'nickname') ? undefined : json['nickname'],
        'lastname': json['lastname'],
        'address': !exists(json, 'address') ? undefined : AddressDataFromJSON(json['address']),
        'phoneHome': !exists(json, 'phoneHome') ? undefined : json['phoneHome'],
        'phoneMobile': !exists(json, 'phoneMobile') ? undefined : json['phoneMobile'],
        'phoneWork': !exists(json, 'phoneWork') ? undefined : json['phoneWork'],
        'relationship': !exists(json, 'relationship') ? undefined : json['relationship'],
        'primaryContact': !exists(json, 'primaryContact') ? undefined : json['primaryContact'],
        'email': !exists(json, 'email') ? undefined : json['email'],
        'occupation': !exists(json, 'occupation') ? undefined : json['occupation'],
        'memberId': !exists(json, 'memberId') ? undefined : json['memberId'],
        'expiry': !exists(json, 'expiry') ? undefined : json['expiry'],
        'overrides': !exists(json, 'overrides') ? undefined : ContactOverrideDataFromJSON(json['overrides']),
    };
}

export function ContactInputToJSON(value?: ContactInput | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'state': value.state,
        'firstname': value.firstname,
        'nickname': value.nickname,
        'lastname': value.lastname,
        'address': AddressDataToJSON(value.address),
        'phoneHome': value.phoneHome,
        'phoneMobile': value.phoneMobile,
        'phoneWork': value.phoneWork,
        'relationship': value.relationship,
        'primaryContact': value.primaryContact,
        'email': value.email,
        'occupation': value.occupation,
        'memberId': value.memberId,
        'expiry': value.expiry,
        'overrides': ContactOverrideDataToJSON(value.overrides),
    };
}

/**
* @export
* @enum {string}
*/
export enum ContactInputStateEnum {
    Enabled = 'enabled',
    Disabled = 'disabled'
}


