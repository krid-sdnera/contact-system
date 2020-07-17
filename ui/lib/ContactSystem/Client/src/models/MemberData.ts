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
    ContactData,
    ContactDataFromJSON,
    ContactDataFromJSONTyped,
    ContactDataToJSON,
    MemberOverrideData,
    MemberOverrideDataFromJSON,
    MemberOverrideDataFromJSONTyped,
    MemberOverrideDataToJSON,
    MemberRoleData,
    MemberRoleDataFromJSON,
    MemberRoleDataFromJSONTyped,
    MemberRoleDataToJSON,
} from './';

/**
 * 
 * @export
 * @interface MemberData
 */
export interface MemberData {
    /**
     * 
     * @type {number}
     * @memberof MemberData
     */
    id: number;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    state?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    managementState?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    firstname: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    lastname: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    nickname?: string;
    /**
     * 
     * @type {AddressData}
     * @memberof MemberData
     */
    address?: AddressData;
    /**
     * 
     * @type {Date}
     * @memberof MemberData
     */
    dateOfBirth?: Date;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    membershipNumber?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    phoneHome?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    phoneMobile?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    phoneWork?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    gender?: string;
    /**
     * 
     * @type {string}
     * @memberof MemberData
     */
    expiry?: string;
    /**
     * 
     * @type {MemberOverrideData}
     * @memberof MemberData
     */
    overrides?: MemberOverrideData;
    /**
     * Array containg the list
     * @type {Array<MemberRoleData>}
     * @memberof MemberData
     */
    roles?: Array<MemberRoleData>;
    /**
     * Array containg the list
     * @type {Array<ContactData>}
     * @memberof MemberData
     */
    contacts?: Array<ContactData>;
}

export function MemberDataFromJSON(json: any): MemberData {
    return MemberDataFromJSONTyped(json, false);
}

export function MemberDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): MemberData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'id': json['id'],
        'state': !exists(json, 'state') ? undefined : json['state'],
        'managementState': !exists(json, 'managementState') ? undefined : json['managementState'],
        'firstname': json['firstname'],
        'lastname': json['lastname'],
        'nickname': !exists(json, 'nickname') ? undefined : json['nickname'],
        'address': !exists(json, 'address') ? undefined : AddressDataFromJSON(json['address']),
        'dateOfBirth': !exists(json, 'dateOfBirth') ? undefined : (new Date(json['dateOfBirth'])),
        'membershipNumber': !exists(json, 'membershipNumber') ? undefined : json['membershipNumber'],
        'phoneHome': !exists(json, 'phoneHome') ? undefined : json['phoneHome'],
        'phoneMobile': !exists(json, 'phoneMobile') ? undefined : json['phoneMobile'],
        'phoneWork': !exists(json, 'phoneWork') ? undefined : json['phoneWork'],
        'gender': !exists(json, 'gender') ? undefined : json['gender'],
        'expiry': !exists(json, 'expiry') ? undefined : json['expiry'],
        'overrides': !exists(json, 'overrides') ? undefined : MemberOverrideDataFromJSON(json['overrides']),
        'roles': !exists(json, 'roles') ? undefined : ((json['roles'] as Array<any>).map(MemberRoleDataFromJSON)),
        'contacts': !exists(json, 'contacts') ? undefined : ((json['contacts'] as Array<any>).map(ContactDataFromJSON)),
    };
}

export function MemberDataToJSON(value?: MemberData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'id': value.id,
        'state': value.state,
        'managementState': value.managementState,
        'firstname': value.firstname,
        'lastname': value.lastname,
        'nickname': value.nickname,
        'address': AddressDataToJSON(value.address),
        'dateOfBirth': value.dateOfBirth === undefined ? undefined : (value.dateOfBirth.toISOString().substr(0,10)),
        'membershipNumber': value.membershipNumber,
        'phoneHome': value.phoneHome,
        'phoneMobile': value.phoneMobile,
        'phoneWork': value.phoneWork,
        'gender': value.gender,
        'expiry': value.expiry,
        'overrides': MemberOverrideDataToJSON(value.overrides),
        'roles': value.roles === undefined ? undefined : ((value.roles as Array<any>).map(MemberRoleDataToJSON)),
        'contacts': value.contacts === undefined ? undefined : ((value.contacts as Array<any>).map(ContactDataToJSON)),
    };
}


