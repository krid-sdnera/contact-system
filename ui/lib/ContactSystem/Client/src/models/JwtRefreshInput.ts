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
 * JWT Refresh Token
 * @export
 * @interface JwtRefreshInput
 */
export interface JwtRefreshInput {
    /**
     * The refresh token
     * @type {string}
     * @memberof JwtRefreshInput
     */
    refreshToken: string;
}

export function JwtRefreshInputFromJSON(json: any): JwtRefreshInput {
    return JwtRefreshInputFromJSONTyped(json, false);
}

export function JwtRefreshInputFromJSONTyped(json: any, ignoreDiscriminator: boolean): JwtRefreshInput {
    if ((json === undefined) || (json === null)) {
        return json;
    }
    return {
        
        'refreshToken': json['refresh_token'],
    };
}

export function JwtRefreshInputToJSON(value?: JwtRefreshInput | null): any {
    if (value === undefined) {
        return undefined;
    }
    if (value === null) {
        return null;
    }
    return {
        
        'refresh_token': value.refreshToken,
    };
}


