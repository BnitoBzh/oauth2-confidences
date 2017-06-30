<?php

namespace Confidences\OAuth2\Client\Test\Provider;

use Confidences\OAuth2\Client\Provider\ConfidencesProvider;
use Confidences\OAuth2\Client\Provider\ConfidencesUser;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConfidencesProviderTest
 *
 * @package Confidences\OAuth2\Client\Test\Provider
 * @author  Paul Thebaud
 *
 * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider
 */
class ConfidencesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfidencesProvider
     */
    protected $provider;

    protected function setUp()
    {
        $this->provider = new ConfidencesProvider();
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::getBaseAuthorizationUrl()
     */
    public function testGetBaseAuthorizationUrl()
    {
        $this->assertEquals('https://confidences.co/oauth2/auth', $this->provider->getBaseAuthorizationUrl());
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::getBaseAccessTokenUrl()
     */
    public function testGetBaseAccessTokenUrl()
    {
        $this->assertEquals('https://confidences.co/oauth2/token', $this->provider->getBaseAccessTokenUrl([]));
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::getResourceOwnerDetailsUrl()
     */
    public function testGetResourceOwnerDetailsUrl()
    {
        $this->assertEquals(
            'https://confidences.co/api/me',
            $this->provider->getResourceOwnerDetailsUrl($this->createMock(AccessToken::class))
        );
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::getDefaultScopes()
     */
    public function testGetDefaultScopes()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('getDefaultScopes');
        $method->setAccessible(true);
        $this->assertEquals([], $method->invoke($this->provider));
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::getScopeSeparator()
     */
    public function testGetScopeSeparator()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('getScopeSeparator');
        $method->setAccessible(true);
        $this->assertEquals('', $method->invoke($this->provider));
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::checkResponse()
     */
    public function testCheckResponseExceptionNoCode()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('checkResponse');
        $method->setAccessible(true);

        $response = $this->createMock(ResponseInterface::class);
        $this->expectException(IdentityProviderException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('error');

        $method->invoke($this->provider, $response, ['error' => 'error']);
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::checkResponse()
     */
    public function testCheckResponseExceptionCode()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('checkResponse');
        $method->setAccessible(true);

        $response = $this->createMock(ResponseInterface::class);
        $this->expectException(IdentityProviderException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('error');

        $method->invoke($this->provider, $response, ['error' => ['code' => 1, 'message' => 'error']]);
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::checkResponse()
     */
    public function testCheckResponse()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('checkResponse');
        $method->setAccessible(true);

        $response = $this->createMock(ResponseInterface::class);

        $this->assertNull($method->invoke($this->provider, $response, []));
    }

    /**
     * @covers \Confidences\OAuth2\Client\Provider\ConfidencesProvider::createResourceOwner()
     */
    public function testCreateResourceOwner()
    {
        $reflection = new \ReflectionClass(ConfidencesProvider::class);
        $method = $reflection->getMethod('createResourceOwner');
        $method->setAccessible(true);

        $user = $method->invoke($this->provider, [], $this->createMock(AccessToken::class));
        $this->assertInstanceOf(ConfidencesUser::class, $user);
    }
}
