<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use LoginRadius\Sdk\AuthenticatingClient;
use LoginRadius\Sdk\Config;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Asserts the shared SDK manifest's concrete credential wiring: which header or
 * query parameter each credential lands in, Authorization precedence, and
 * that a default header can never mask a credential. Mirrors
 * the Node SDK's auth.test.ts case for case.
 */
final class AuthenticatingClientTest extends TestCase
{
    /** Sends $request through a client built from $config and returns what actually went over the wire. */
    private static function sentRequest(Config $config, RequestInterface $request): RequestInterface
    {
        $history = [];
        $mock = new MockHandler([new Response(200, [], '{}')]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($history));
        $inner = new GuzzleClient(['handler' => $stack]);

        (new AuthenticatingClient($inner, $config))->send($request);

        return $history[0]['request'];
    }

    private static function get(string $uri = 'https://api.loginradius.com/x'): RequestInterface
    {
        return new Request('GET', $uri);
    }

    public function testApiKeySentAsHeaderAndQuery(): void
    {
        $req = self::sentRequest(new Config(apiKey: 'my-key'), self::get());

        $this->assertSame('my-key', $req->getHeaderLine('X-LoginRadius-ApiKey'));
        parse_str($req->getUri()->getQuery(), $q);
        $this->assertSame('my-key', $q['apikey']);
    }

    public function testApiSecretSentAsHeaderAndQuery(): void
    {
        $req = self::sentRequest(new Config(apiKey: 'k', apiSecret: 'my-secret'), self::get());

        $this->assertSame('my-secret', $req->getHeaderLine('X-LoginRadius-ApiSecret'));
        parse_str($req->getUri()->getQuery(), $q);
        $this->assertSame('my-secret', $q['apisecret']);
    }

    public function testXLoginRadiusApiKeyOverridesTheHeaderOnly(): void
    {
        $req = self::sentRequest(
            new Config(apiKey: 'base-key', xLoginRadiusApiKey: 'override-key'),
            self::get()
        );

        $this->assertSame('override-key', $req->getHeaderLine('X-LoginRadius-ApiKey'));
        parse_str($req->getUri()->getQuery(), $q);
        // The query form is unaffected by the header-only override.
        $this->assertSame('base-key', $q['apikey']);
    }

    public function testBearerTokenWinsOverM2mBearerToken(): void
    {
        $req = self::sentRequest(
            new Config(bearerToken: 'user-token', m2mBearerToken: 'm2m-token'),
            self::get()
        );

        $this->assertSame('Bearer user-token', $req->getHeaderLine('Authorization'));
    }

    public function testM2mBearerTokenUsedWhenBearerTokenIsAbsent(): void
    {
        $req = self::sentRequest(new Config(m2mBearerToken: 'm2m-token'), self::get());

        $this->assertSame('Bearer m2m-token', $req->getHeaderLine('Authorization'));
    }

    public function testAccessTokenSentAsQueryParameter(): void
    {
        $req = self::sentRequest(new Config(accessToken: 'user-access-token'), self::get());

        parse_str($req->getUri()->getQuery(), $q);
        $this->assertSame('user-access-token', $q['access_token']);
    }

    public function testPerCallQueryValueWinsOverTheConfiguredCredential(): void
    {
        $req = self::sentRequest(
            new Config(apiKey: 'configured-key'),
            self::get('https://api.loginradius.com/x?apikey=explicit-key')
        );

        parse_str($req->getUri()->getQuery(), $q);
        $this->assertSame('explicit-key', $q['apikey']);
    }

    public function testDefaultHeaderNeverMasksACredential(): void
    {
        $req = self::sentRequest(
            new Config(
                apiKey: 'my-key',
                defaultHeaders: ['X-LoginRadius-ApiKey' => 'should-not-win', 'X-Custom' => 'default-value']
            ),
            self::get()
        );

        $this->assertSame('my-key', $req->getHeaderLine('X-LoginRadius-ApiKey'));
        $this->assertSame('default-value', $req->getHeaderLine('X-Custom'));
    }

    public function testUserAgentDefaultsToTheSdkVersionString(): void
    {
        $req = self::sentRequest(new Config(apiKey: 'k'), self::get());

        $this->assertStringStartsWith('loginradius-php/', $req->getHeaderLine('User-Agent'));
    }

    public function testOriginIpSentAsHeaderOption(): void
    {
        $req = self::sentRequest(new Config(apiKey: 'k', originIp: '203.0.113.5'), self::get());

        $this->assertSame('203.0.113.5', $req->getHeaderLine('X-Origin-IP'));
    }

    public function testPreventWebhookFlagSendsItsFixedValue(): void
    {
        $req = self::sentRequest(new Config(apiKey: 'k', preventWebhook: true), self::get());

        $this->assertSame('true', $req->getHeaderLine('X-PreventWebhook'));
    }

    public function testSigningIsOffByDefault(): void
    {
        $req = self::sentRequest(
            new Config(apiKey: 'k', apiSecret: 's'),
            self::get('https://api.loginradius.com/identity/v2/manage/account/uid')
        );

        $this->assertFalse($req->hasHeader('digest'));
    }

    public function testSigningAppliesOnlyToManagementEndpointsWhenEnabled(): void
    {
        $req = self::sentRequest(
            new Config(apiKey: 'k', apiSecret: 's', apiRequestSigning: true),
            self::get('https://api.loginradius.com/identity/v2/auth/login')
        );

        $this->assertFalse($req->hasHeader('digest'));
    }

    public function testSigningAddsDigestAndExpiresHeadersOnAManagementEndpoint(): void
    {
        $req = self::sentRequest(
            new Config(apiKey: 'k', apiSecret: 's', apiRequestSigning: true),
            self::get('https://api.loginradius.com/identity/v2/manage/account/uid')
        );

        $this->assertTrue($req->hasHeader('digest'));
        $this->assertTrue($req->hasHeader('x-Request-Expires'));
        parse_str($req->getUri()->getQuery(), $q);
        $this->assertArrayNotHasKey('apisecret', $q);
    }
}
