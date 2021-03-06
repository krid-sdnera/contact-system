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
 * A JSON Web Token
 * @export
 * @interface JwtData
 */
export interface JwtData {
    /**
     * The JSON Web Token
     * @type {string}
     * @memberof JwtData
     */
    token: string;
    /**
     * A refresh token for the JSON Web Token
     * @type {string}
     * @memberof JwtData
     */
    refreshToken: string;
}

export function JwtDataFromJSON(json: any): JwtData {
    return JwtDataFromJSONTyped(json, false);
}

export function JwtDataFromJSONTyped(json: any, ignoreDiscriminator: boolean): JwtData {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'token': json['token'],
        'refreshToken': json['refresh_token'],
    };
}

export function JwtDataToJSON(value?: JwtData | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'token': value.token,
        'refresh_token': value.refreshToken,
    };
}


