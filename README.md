# jnjxp.auth-handler
[Aura\Auth] Authentication middleware

[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

## Installation
```
composer require jnjxp/auth-handler
```

## Usage
See [Aura\Auth] documentation.
```php
// Create handler with Auth and ResumeService instance
$handler = new Jnjxp\AuthHandler\AuthHandler($auth, $resume);

// Optionally set the `AuthAttribute`, the name of the attribute on which to
// store the `AuthAttribute` in the `Request`. Defaults to 'aura/auth:auth'
$handler->setAuthAttribute('auth');

// Add to your middleware stack, radar, relay, etc.
$stack->middleware($handler);

// Subsequest dealings with `Request` will have the `Auth` instance available at
// the previous specified atribute
$auth = $request->getAttribute('auth');


// The `AuthRequestAwareTrait` should make dealings easier.
//
// Have all your objects that deal with the auth attribute on the request use
// the `AuthRequestAwareTrait` and have your DI container use the setter, so that 
// they all know where the auth object is stored.

class MyMiddleware
{
    use \Jnjxp\AuthHandler\AuthRequestAwareTrait;

    public function __invoke($request, $response, $next)
    {
        $auth = $this->getAuth($request);
        $status = $this->getAuthStatus($request);
        $isValid = $this->isAuthValid($request);

        // ...
        return $next($request, $response);
    }
}

class MyInputExtractor
{

    use \Jnjxp\AuthHandler\AuthRequestAwareTrait;

    public funciton __invoke($request)
    {
        return [
            'auth' => $this->getAuth($request),
            'data' => $request->getParsedBody()
        ];
    }
}
```
[Aura\Auth]: https://github.com/auraphp/Aura.Auth

[ico-version]: https://img.shields.io/packagist/v/jnjxp/auth-handler.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jnjxp/jnjxp.auth-handler/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jnjxp/jnjxp.auth-handler.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jnjxp/jnjxp.auth-handler.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jnjxp/auth-handler
[link-travis]: https://travis-ci.org/jnjxp/jnjxp.auth-handler
[link-scrutinizer]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.auth-handler
[link-code-quality]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.auth-handler
