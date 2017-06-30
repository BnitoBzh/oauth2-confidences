# Google Provider for OAuth 2.0 Client

[![Build Status](https://img.shields.io/travis/paul-thebaud/oauth2-confidences.svg)](https://travis-ci.org/paul-thebaud/oauth2-confidences)
[![Code Coverage](https://img.shields.io/coveralls/paul-thebaud/oauth2-confidences.svg)](https://coveralls.io/r/paul-thebaud/oauth2-confidences)
[![License](https://img.shields.io/packagist/l/paulthebaud/oauth2-confidences.svg)](https://github.com/paul-thebaud/oauth2-confidences/blob/master/LICENSE)
[![Latest Stable Version](https://img.shields.io/packagist/v/paulthebaud/oauth2-confidences.svg)](https://packagist.org/packages/paulthebaud/oauth2-confidences)

This package provides Confidences OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Requirements

The following versions of PHP are supported.

* PHP 5.6
* PHP 7.0
* PHP 7.1
* HHVM

## Installation

To install, use composer:

```
composer require paulthebaud/oauth2-confidences
```

## Usage

### Authorization Code Flow

```php
$provider = new Confidences\OAuth2\Client\Provider\Google([
    'clientId'     => '{confidences-client-id}',
    'clientSecret' => '{confidences-client-secret}',
    'redirectUri'  => 'https://example.com/callback-url'
]);

if (!empty($_GET['error'])) {

    // Got an error, probably user denied access
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));

} elseif (empty($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $ownerDetails->getFirstName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Something went wrong: ' . $e->getMessage());

    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();

    // Number of seconds until the access token will expire
    echo $token->getExpires();
}
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](https://github.com/paul-thebaud/oauth2-confidences/blob/master/LICENSE) for more information.