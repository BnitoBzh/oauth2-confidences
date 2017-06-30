<?php

namespace Confidences\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class ConfidencesProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';

    public function getBaseAuthorizationUrl()
    {
        return 'https://confidences.local/oauth2/auth';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://confidences.local/oauth2/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://confidences.local/api/me';
    }

    protected function getAuthorizationParameters(array $options)
    {
        return parent::getAuthorizationParameters($options);
    }

    protected function getDefaultScopes()
    {
        return [];
    }

    protected function getScopeSeparator()
    {
        return '';
    }

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

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new ConfidencesUser($response);
    }
}
