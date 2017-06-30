<?php

namespace Confidences\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConfidencesProvider
 *      Provide an adapter for Confidences OAuth 2.0
 *
 * @package Confidences\OAuth2\Client\Provider
 * @author  Paul Thebaud
 */
class ConfidencesProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Return the authorization url
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://confidences.local/oauth2/auth';
    }

    /**
     * Return the token url
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://confidences.local/oauth2/token';
    }

    /**
     * Return the user information url
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://confidences.local/api/me';
    }

    /**
     * Return the authorization parameters
     *
     * @param array $options
     *
     * @return array
     */
    protected function getAuthorizationParameters(array $options)
    {
        return parent::getAuthorizationParameters($options);
    }

    /**
     * Return the default scopes
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * Return the scope separator
     *
     * @return string
     */
    protected function getScopeSeparator()
    {
        return '';
    }

    /**
     * Will check the response to throw a new exception
     *
     * @param ResponseInterface $response
     * @param array|string      $data
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (! empty($data['error'])) {
            $code = 0;
            $error = $data['error'];

            if (is_array($error)) {
                $code = $error['code'];
                $error = $error['message'];
            }

            throw new IdentityProviderException($error, $code, $data);
        }
    }

    /**
     * Create the ConfidencesUser from a response
     *
     * @param array       $response
     * @param AccessToken $token
     *
     * @return ConfidencesUser
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new ConfidencesUser($response);
    }
}
