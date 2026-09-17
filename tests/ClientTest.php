<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Tests;

use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Config;
use LoginRadius\Sdk\Internal\OpenApi\ApiException;
use LoginRadius\Sdk\LoginRadiusException;
use PHPUnit\Framework\TestCase;

/**
 * Smoke-tests wiring the facade doesn't otherwise exercise: that every
 * generated service is reachable off the client, and that the generated
 * ApiException converts to the facade's typed exception.
 */
final class ClientTest extends TestCase
{
    public function testExposesTheCoreServicesUsedByTheDemo(): void
    {
        $client = new Client(new Config(apiKey: 'k'));

        // A representative subset, not the full 50+ services — this is a
        // wiring smoke test, not a service-discovery test (that lives in
        // sdk-factory's tools/derive-services.mjs against the generated tree).
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\UserApi::class, $client->user);
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\LoginApi::class, $client->login);
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\RegistrationApi::class, $client->registration);
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\PasswordApi::class, $client->password);
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\CustomObjectApi::class, $client->customObject);
        $this->assertInstanceOf(\LoginRadius\Sdk\Internal\OpenApi\Api\AccountSessionApi::class, $client->accountSession);
    }

    public function testConfigIsReturnedVerbatim(): void
    {
        $config = new Config(apiKey: 'k');
        $client = new Client($config);
        $this->assertSame($config, $client->config());
    }

    public function testToLoginRadiusExceptionConverts(): void
    {
        $e = new ApiException('boom', 400, [], '{"ErrorCode":123,"Message":"x","Description":"y"}');
        $lr = Client::toLoginRadiusException($e);
        $this->assertInstanceOf(LoginRadiusException::class, $lr);
        $this->assertSame(400, $lr->statusCode());
        $this->assertSame('123', $lr->code());
    }
}
