# Migrating from v11 to v12

v11 is [`loginradius/php-sdk`](https://github.com/LoginRadius/php-sdk) 11.7.0, a
hand-written SDK. v12 is generated from the LoginRadius OpenAPI specification and
wrapped in a thin facade. This guide covers the differences that change every
call site: the package, configuration, construction, the call style, and errors.

**It does not include a full endpoint-by-endpoint mapping.** Every operation in
the API is present in v12, so the mapping exists — it just is not written out
here. The representative flows below show how to derive it, and `docs/API.md`
lists every operation with the endpoint it calls, which is the reliable way to
find a v11 method's counterpart.

## Package

The Composer name is unchanged, so this is a version bump:

```bash
# v11
composer require loginradius/php-sdk:11.7.0

# v12
composer require loginradius/php-sdk:12.0.0-rc.1
```

Because the name is the same, Composer will not resolve both at once. A project
is on v11 or on v12.

## Configuration

v11 read credentials from **global constants** defined before use. v12 takes them
as constructor arguments:

```php
// v11 — global constants, process-wide
define('LR_API_KEY', 'LOGINRADIUS_API_KEY_HERE');
define('LR_API_SECRET', 'LOGINRADIUS_API_SECRET_HERE');
define('APP_NAME', 'LOGINRADIUS_SITE_NAME_HERE');

// v12 — configuration is a value you pass
use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Config;

$client = new Client(new Config(
    apiKey:    getenv('LR_API_KEY'),
    apiSecret: getenv('LR_API_SECRET'),   // server-side only
));
```

That difference matters if you serve more than one tenant: constants cannot be
redefined, so v11 could hold exactly one credential set per process. In v12 you
construct one `Client` per tenant and hold both.

## Construction and call style

v11 instantiated **one class per API** and took request bodies as **JSON
strings**. v12 exposes every service as a property of one client, and takes
named arguments:

```php
// v11
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;

$authenticationAPI = new AuthenticationAPI();
$accountAPI        = new AccountAPI();

$payload = '{"email":"user@example.com","password":"password"}';
$result  = $authenticationAPI->loginByEmail($payload);

// v12
$result = $client->login->emailByLoginUserNamePhone(
    authLoginByEmailRequest: ['email' => 'user@example.com', 'password' => 'secret'],
);
```

Hand-built JSON strings are the change worth noticing: a typo in a v11 payload
was a runtime API error with a generic message. In v12 the body is an array
against a typed model, so the failure is local and legible.

## Errors

Both versions throw, so the shape of your `try` block survives. What changes is
what you can ask the exception:

```php
// v11
try {
    $accountAPI->getAccountProfileByUid($uid);
} catch (LoginRadiusException $e) {
    // inspect the message
}

// v12
use LoginRadius\Sdk\LoginRadiusException;

try {
    $client->accounts->getAccountIdentityByUID(uid: $uid);
} catch (LoginRadiusException $e) {
    if ($e->isAuth())      { /* credential rejected — do not retry as-is */ }
    if ($e->isRateLimit()) { /* back off */ }
    if ($e->isServer())    { /* retry with backoff */ }

    error_log($e->statusCode() . ' ' . $e->code() . ' ' . $e->description());
}
```

The API returns three different error envelopes depending on the endpoint family
— PascalCase, camelCase, and the OAuth `{error, error_description}` shape. All
three normalise to the same exception, so one handler works everywhere.

## Representative endpoint mapping

v11 method names came from a hand-written surface; v12's come from the
specification's `operationId`. Most differ, and the reliable way to find a
counterpart is to match the **HTTP endpoint** rather than the name.

| v11 | v12 | Endpoint |
| --- | --- | --- |
| `AuthenticationAPI->loginByEmail` | `$client->login->emailByLoginUserNamePhone` | `POST /identity/v2/auth/login` |
| `AccountAPI->getAccountProfileByUid` | `$client->accounts->getAccountIdentityByUID` | `GET /identity/v2/manage/account/{uid}` |

Note the second one is admin-scoped (`/manage/`, authorised by the API secret).
For the signed-in user's own profile, `$client->user->getAccountDetails` calls
`GET /identity/v2/auth/account` with their access token — usually what a
customer-facing integration wants.

## Other conventions worth knowing

- **SOTT generation is built in.** `Sott::generate($apiKey, $apiSecret)` replaces
  any hand-rolled AES/PBKDF2 implementation.
- **Model bodies are plain arrays.** Every generated model constructor takes
  `array $data` keyed by the PHP property name, not the wire-format name — see
  the model's own `@param` docblock for the exact keys.
- **Credentials are configuration, not per-call arguments.** Set them once on
  `Config`; the client injects the right header, query parameter, or
  `Authorization` scheme on every request.

## What we don't migrate for you

Nothing rewrites your call sites. The v11 and v12 method surfaces differ enough
that a mechanical codemod would produce plausible-looking calls against the wrong
endpoints, which is worse than a compile error. Work endpoint by endpoint using
`docs/API.md`.

## Need help?

Open an issue with the v11 method you are replacing and the endpoint it called,
and we will point you at the v12 equivalent.
