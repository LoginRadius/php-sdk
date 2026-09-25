<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use LoginRadius\Sdk\Signing;
use PHPUnit\Framework\TestCase;

/**
 * CROSS-LANGUAGE PARITY.
 *
 * The golden digests below were produced by running the REFERENCE
 * implementation — `creatHashForApplicationSignig` in
 * admin-console-backend/lib/services/loginradius-v2-sdk/lr.js — against these
 * exact inputs. They are not copied from this SDK's own output, so this test
 * proves the port matches the known-working algorithm rather than merely
 * matching itself. Mirrors the Node SDK's signing.test.ts.
 */
final class SigningTest extends TestCase
{
    private const SECRET = 'test-api-secret';
    private const URI = 'https://api.loginradius.com/identity/v2/manage/account/uid?apikey=test-api-key';
    // Signing::sign adds the 20-minute window, so `now` is the golden expiry minus 20m.
    private const GOLDEN_NO_BODY = 'SHA-256=WhdnDwiFzLUkrhBOUQYzrec+ZllDrY6X0hdovov8bKY=';
    private const GOLDEN_WITH_BODY = 'SHA-256=cVEPKKM+Dd1fzQePAPDKMKCn+2QollSbzWfVx8YxSzM=';
    private const GOLDEN_EXPIRES = '2026-01-02 03:24:05';

    private static function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2026-01-02T03:04:05Z');
    }

    public function testMatchesTheReferenceImplementationWithNoBody(): void
    {
        $h = Signing::sign(self::SECRET, self::URI, null, self::now());
        $this->assertSame(self::GOLDEN_NO_BODY, $h->digest);
    }

    public function testMatchesTheReferenceImplementationWithABody(): void
    {
        $h = Signing::sign(self::SECRET, self::URI, '{"Uid":"abc123"}', self::now());
        $this->assertSame(self::GOLDEN_WITH_BODY, $h->digest);
    }

    public function testStampsAFullyZeroPaddedUtcExpiry20MinutesAhead(): void
    {
        $h = Signing::sign(self::SECRET, self::URI, null, self::now());
        $this->assertSame(self::GOLDEN_EXPIRES, $h->expires);
        $this->assertSame(20 * 60, Signing::EXPIRY_SECONDS);
    }

    public function testChangesWhenTheBodyChanges(): void
    {
        $h = Signing::sign(self::SECRET, self::URI, '{"Uid":"other"}', self::now());
        $this->assertNotSame(self::GOLDEN_WITH_BODY, $h->digest);
    }

    public function testChangesWhenTheSecretChanges(): void
    {
        $h = Signing::sign('other-secret', self::URI, null, self::now());
        $this->assertNotSame(self::GOLDEN_NO_BODY, $h->digest);
    }

    public function testIsStableAcrossEquivalentUrlEscapings(): void
    {
        $encoded = 'https://api.loginradius.com/identity/v2/manage/account/uid%3Fapikey%3Dtest-api-key';
        $a = Signing::sign(self::SECRET, $encoded, null, self::now());
        $b = Signing::sign(self::SECRET, rawurldecode($encoded), null, self::now());
        $this->assertSame($a->digest, $b->digest);
    }

    /** @dataProvider pathProvider */
    public function testShouldSign(string $path, bool $expected): void
    {
        $this->assertSame($expected, Signing::shouldSign($path));
    }

    public static function pathProvider(): array
    {
        return [
            ['/identity/v2/manage/account/uid', true],
            ['/v2/manage/roles', true],
            ['/identity/v2/auth/login', false],
            ['/identity/v2/auth/register', false],
            // The access-token exchange is explicitly excluded by the reference.
            ['/identity/v2/manage/account/access_token', false],
        ];
    }
}
