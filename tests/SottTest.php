<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use LoginRadius\Sdk\Sott;
use PHPUnit\Framework\TestCase;

/**
 * CROSS-LANGUAGE PARITY.
 *
 * The golden value below was produced by the Go SDK's
 * `GenerateSOTTWithWindow` for the same inputs. Every LoginRadius SDK must
 * emit a byte-identical token, because the API validates the AES payload
 * exactly — a drifted IV, iteration count, salt, or timestamp format yields a
 * token that is silently rejected.
 *
 * If this test fails, the implementation has diverged, not the expectation.
 * The shared parameters live in sdk-factory's manifest/sdk.yaml under `sott:`.
 * Mirrors languages/node/static/__tests__/sott.test.ts.
 */
final class SottTest extends TestCase
{
    private const GOLDEN = 'yvLBFPR3aRNl1YlisgPpEdphb73sUfne2Jem7hTKWU6RLlkcfjYOhe5B7kSHorQS*1059092e1510bfbc5388d7438b943106';
    private const API_KEY = 'test-api-key';
    private const API_SECRET = 'test-api-secret';

    private static function start(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2026-01-02T03:04:05Z');
    }

    private static function end(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('2026-01-02T03:14:05Z');
    }

    public function testMatchesTheGoSdkByteForByte(): void
    {
        $this->assertSame(
            self::GOLDEN,
            Sott::generateWithWindow(self::API_KEY, self::API_SECRET, self::start(), self::end())
        );
    }

    public function testIsDeterministicForAFixedWindow(): void
    {
        $a = Sott::generateWithWindow(self::API_KEY, self::API_SECRET, self::start(), self::end());
        $b = Sott::generateWithWindow(self::API_KEY, self::API_SECRET, self::start(), self::end());
        $this->assertSame($a, $b);
    }

    public function testChangesWhenTheWindowChanges(): void
    {
        $other = new \DateTimeImmutable('2026-01-02T03:15:05Z');
        $this->assertNotSame(
            self::GOLDEN,
            Sott::generateWithWindow(self::API_KEY, self::API_SECRET, self::start(), $other)
        );
    }

    public function testEmitsBase64StarMd5Hex(): void
    {
        $token = Sott::generateWithWindow(self::API_KEY, self::API_SECRET, self::start(), self::end());
        [$payload, $checksum] = explode('*', $token);
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9+\/]+=*$/', $payload);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $checksum);
    }

    public function testRejectsAMissingApiKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Sott::generateWithWindow('', self::API_SECRET, self::start(), self::end());
    }

    public function testRejectsAMissingApiSecret(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Sott::generateWithWindow(self::API_KEY, '', self::start(), self::end());
    }

    public function testDefaultsToATenMinuteWindow(): void
    {
        $this->assertSame(10, Sott::DEFAULT_WINDOW_MINUTES);
    }

    public function testProducesAUsableTokenFromTheCurrentClock(): void
    {
        $token = Sott::generate(self::API_KEY, self::API_SECRET);
        $this->assertCount(2, explode('*', $token));
        $this->assertNotSame(self::GOLDEN, $token);
    }
}
