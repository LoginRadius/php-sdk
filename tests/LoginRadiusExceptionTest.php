<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use LoginRadius\Sdk\Internal\OpenApi\ApiException;
use LoginRadius\Sdk\LoginRadiusException;
use PHPUnit\Framework\TestCase;

/**
 * Asserts the shared SDK manifest's concrete error-classification values: the
 * predicates' status codes, the envelope shapes tried in order, and the
 * case-insensitive field-alias probing. A manifest change is supposed to
 * break this test. Mirrors the Node SDK's errors.test.ts
 * case for case.
 */
final class LoginRadiusExceptionTest extends TestCase
{
    private static function from(int $status, ?array $body): LoginRadiusException
    {
        return LoginRadiusException::from(new ApiException('', $status, [], $body === null ? null : json_encode($body)));
    }

    public function testIsAuthFlags401Only(): void
    {
        $this->assertTrue(self::from(401, [])->isAuth());
        $this->assertFalse(self::from(403, [])->isAuth());
        $this->assertFalse(self::from(400, [])->isAuth());
    }

    public function testIsForbiddenFlags403Only(): void
    {
        $this->assertTrue(self::from(403, [])->isForbidden());
        $this->assertFalse(self::from(401, [])->isForbidden());
        $this->assertFalse(self::from(400, [])->isForbidden());
    }

    public function testIsRateLimitFlags429(): void
    {
        $this->assertTrue(self::from(429, [])->isRateLimit());
        $this->assertFalse(self::from(400, [])->isRateLimit());
    }

    public function testIsServerFlags5xx(): void
    {
        $this->assertTrue(self::from(500, [])->isServer());
        $this->assertTrue(self::from(599, [])->isServer());
        $this->assertFalse(self::from(600, [])->isServer());
        $this->assertFalse(self::from(499, [])->isServer());
    }

    public function testParsesTheStandardApiErrorEnvelope(): void
    {
        $e = self::from(401, ['ErrorCode' => 906, 'Message' => 'Invalid Access Token', 'Description' => 'The access token has expired']);
        $this->assertSame('906', $e->code());
        $this->assertSame('The access token has expired', $e->description());
    }

    public function testParsesTheCamelCaseNativeEnvelope(): void
    {
        $e = self::from(401, ['errorCode' => 906, 'message' => 'Invalid Access Token', 'description' => 'The access token has expired']);
        $this->assertSame('906', $e->code());
        $this->assertSame('The access token has expired', $e->description());
    }

    public function testParsesTheOAuthEnvelope(): void
    {
        $e = self::from(400, ['error' => 'invalid_grant', 'error_description' => 'The token is expired']);
        $this->assertSame('invalid_grant', $e->code());
        $this->assertSame('The token is expired', $e->description());
    }

    public function testAppliesAStatusHintWhenTheBodyIsEmpty(): void
    {
        $e = self::from(401, null);
        $this->assertSame('', $e->code());
        $this->assertStringContainsString('authentication failed', $e->description());
    }

    public function testAppliesAStatusHintForForbidden(): void
    {
        $e = self::from(403, null);
        $this->assertStringContainsString('IP-access restriction', $e->description());
    }

    public function testRawBodyIsPreservedVerbatim(): void
    {
        $body = ['ErrorCode' => 906, 'Message' => 'x', 'Description' => 'y'];
        $e = self::from(401, $body);
        $this->assertSame(json_encode($body), $e->rawBody());
    }

    public function testTransportFailureHasNoStatus(): void
    {
        $e = LoginRadiusException::from(new ApiException('connection refused', 0, [], null));
        $this->assertSame(0, $e->statusCode());
        $this->assertFalse($e->isAuth());
        $this->assertFalse($e->isServer());
    }
}
