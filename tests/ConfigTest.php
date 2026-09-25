<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use LoginRadius\Sdk\Config;
use PHPUnit\Framework\TestCase;

/**
 * Asserts the shared SDK manifest's concrete values — base-URL precedence and the
 * "at least one credential" validation. A manifest change is supposed to
 * break this test, so a behavioural change cannot land silently. Mirrors
 * the Node SDK's config.test.ts case for case.
 */
final class ConfigTest extends TestCase
{
    public function testFallsBackToProductionWhenNothingSupplied(): void
    {
        $this->assertSame('https://api.loginradius.com', (new Config(apiKey: 'k'))->resolveBaseUrl());
    }

    public function testUsesDomainWhenOnlyDomainIsSet(): void
    {
        $cfg = new Config(apiKey: 'k', domain: 'acme');
        $this->assertSame('https://acme.hub.loginradius.com', $cfg->resolveBaseUrl());
    }

    public function testCustomDomainWinsOverDomain(): void
    {
        $cfg = new Config(apiKey: 'k', domain: 'acme', customDomain: 'auth.acme.com');
        $this->assertSame('https://auth.acme.com', $cfg->resolveBaseUrl());
    }

    public function testBaseUrlWinsOverBoth(): void
    {
        $cfg = new Config(
            apiKey: 'k',
            baseURL: 'https://staging.api.loginradius.com',
            customDomain: 'auth.acme.com',
            domain: 'acme'
        );
        $this->assertSame('https://staging.api.loginradius.com', $cfg->resolveBaseUrl());
    }

    public function testThrowsWhenNoCredentialIsSupplied(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/at least one credential is required/');
        new Config();
    }

    public function testThrowsWhenOnlyServerOptionsAreSupplied(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Config(domain: 'acme', timeoutSeconds: 5);
    }

    /** @dataProvider soleCredentialProvider */
    public function testAcceptsEachCredentialAlone(string $name, string $value): void
    {
        $cfg = new Config(...[$name => $value]);
        $this->assertSame($value, $cfg->{$name}());
    }

    public static function soleCredentialProvider(): array
    {
        return [
            'apiKey' => ['apiKey', 'k'],
            'accessToken' => ['accessToken', 't'],
            'bearerToken' => ['bearerToken', 't'],
            'm2mBearerToken' => ['m2mBearerToken', 't'],
            'clientId' => ['clientId', 'c'],
            'xLoginRadiusApiKey (header-only override)' => ['xLoginRadiusApiKey', 'k'],
        ];
    }

    public function testDefaultTimeoutWhenUnset(): void
    {
        $cfg = new Config(apiKey: 'k');
        $this->assertFalse($cfg->timeoutSet());
        $this->assertSame(Config::DEFAULT_TIMEOUT_SECONDS, $cfg->timeoutSeconds());
    }

    public function testExplicitTimeoutIsHonoured(): void
    {
        $cfg = new Config(apiKey: 'k', timeoutSeconds: 5);
        $this->assertTrue($cfg->timeoutSet());
        $this->assertSame(5, $cfg->timeoutSeconds());
    }

    public function testDefaultUserAgentCarriesTheSdkVersion(): void
    {
        $cfg = new Config(apiKey: 'k');
        $this->assertStringStartsWith('loginradius-php/', $cfg->userAgent());
    }
}
