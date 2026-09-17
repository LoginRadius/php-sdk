# LoginRadius PHP SDK — v12

Generated from the LoginRadius OpenAPI specification. Every LoginRadius SDK —
Go, Node.js, Java, .NET, and PHP — is rendered from that one spec plus one
shared behavioural manifest, so credentials, base-URL precedence, error
classification, request signing, and SOTT behave identically across all of
them.

## What changed in v12

v12 is generated rather than hand-written. Practically, that means:

- **Full API coverage.** Every operation in the spec, not a hand-maintained
  subset that drifts behind the API.
- **Typed models** for every request and response.
- **One credential path.** Credentials, cross-cutting request options,
  signing, and debug logging are applied by a single decorator around the
  HTTP client, so there is one place to audit rather than one per method.
- **Typed errors** with intent-based predicates (`isAuth()`, `isRateLimit()`)
  instead of status-code comparisons at every call site.

v12 has never been released, so it is not a drop-in replacement for a prior
release. See `MIGRATION_GUIDE.md`.

## Install

```bash
# 12.0.0-rc.1 is a prerelease. Composer's default minimum-stability is
# `stable`, so a range like ^12.0 skips it — require the exact version.
composer require loginradius/php-sdk:12.0.0-rc.1
```

Requires PHP 8.1+.

## Quickstart

```php
use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Config;

$client = new Client(new Config(apiKey: getenv('LR_API_KEY')));

$result = $client->login->checkUserNameAvailability(username: 'alice');
```

Construct one `Client` per tenant / credential set and reuse it — every
service property shares the same underlying HTTP client and configuration.

## Configuration

Supply only the credentials your endpoints require — the constructor throws
`InvalidArgumentException` if none are set:

```php
$config = new Config(
    apiKey: getenv('LR_API_KEY'),
    apiSecret: getenv('LR_API_SECRET'),   // server-side only
    accessToken: $sessionAccessToken,
);
```

Named arguments cover every option: `domain` / `customDomain` / `baseURL`
(server selection, highest precedence first — see `Config::resolveBaseUrl()`),
`timeoutSeconds`, `httpClient` (a pre-configured Guzzle client to extend
rather than replace), `defaultHeaders`, `apiRequestSigning`, `debug` (a
writable stream — credential values are redacted, only header names appear),
and `serverIndex`.

## Errors

Every non-2xx response or transport failure throws `LoginRadiusException`:

```php
use LoginRadius\Sdk\LoginRadiusException;

try {
    $client->user->getAccountDetails(accessToken: $accessToken);
} catch (LoginRadiusException $e) {
    if ($e->isAuth()) {
        // 401 — missing or invalid credentials
    }
    echo $e->statusCode(), ' ', $e->code(), ' ', $e->description();
}
```

## SOTT (registration)

Registration endpoints require a Secure One-Time Token, minted server-side
from your API key and secret — never in a browser or mobile client:

```php
use LoginRadius\Sdk\Sott;

$sott = Sott::generate($apiKey, $apiSecret);
```

## Demo

A runnable demo app lives in `demo/` — every endpoint the shared contract and
the extended routes expose, behind a small HTML page:

```bash
composer install
export LR_API_KEY=... LR_API_SECRET=...
php -S localhost:8080 demo/index.php
```

Then open http://localhost:8080/.

## API reference

[`docs/API.md`](./docs/API.md) lists every operation with its method name,
HTTP verb and path, grouped by service.

## Generated client

`src/Internal/OpenApi/` is the raw client openapi-generator produces from the
spec. It is an implementation detail — use the facade in `src/` instead;
`Internal\OpenApi` may change shape between generator versions without
notice.
