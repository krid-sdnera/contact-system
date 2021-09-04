<?php
/**
 * JwtData
 *
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Model
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * Contact System API
 *
 * This is the spec for the Constact system API
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: dirk@arends.com.au
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace OpenAPI\Server\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the JwtData model.
 *
 * A JSON Web Token
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class JwtData 
{
        /**
     * The JSON Web Token
     *
     * @var string
     * @SerializedName("token")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $token;

    /**
     * A refresh token for the JSON Web Token
     *
     * @var string
     * @SerializedName("refresh_token")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $refreshToken;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->token = isset($data['token']) ? $data['token'] : null;
        $this->refreshToken = isset($data['refreshToken']) ? $data['refreshToken'] : null;
    }

    /**
     * Gets token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Sets token.
     *
     * @param string $token  The JSON Web Token
     *
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Gets refreshToken.
     *
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * Sets refreshToken.
     *
     * @param string $refreshToken  A refresh token for the JSON Web Token
     *
     * @return $this
     */
    public function setRefreshToken(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }
}


