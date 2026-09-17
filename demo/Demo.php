<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Demo;

use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Internal\OpenApi\ApiException;
use LoginRadius\Sdk\LoginRadiusException;

/** Small HTTP helpers shared by the demo handlers. DEMO ONLY. */
final class Demo
{
    private const COOKIE = 'lr_demo_session';

    /**
     * Holds the second-factor authentication token from a challenge login, in
     * a cookie SEPARATE from the session cookie — the manifest's declared
     * name (`manifest/sdk.yaml` demo.mfaTokenCookie: lr_mfa), matched here by
     * hand since this route family predates PHP's generated contract. A
     * half-authenticated user must never hold anything the session cookie
     * check would accept, so this is deliberately its own cookie rather than
     * a second use of COOKIE.
     */
    private const MFA_COOKIE = 'lr_mfa';

    private function __construct()
    {
    }

    /** Reads a JSON object body into a flat associative array. Never throws. */
    public static function readJson(): array
    {
        $body = file_get_contents('php://input');
        if ($body === false || $body === '') {
            return [];
        }
        $decoded = json_decode($body, true);
        return is_array($decoded) ? $decoded : [];
    }

    /** Reads a value out of a decoded JSON body as a string, or null when absent/empty. */
    public static function get(array $input, string $key): ?string
    {
        $v = $input[$key] ?? null;
        if ($v === null) {
            return null;
        }
        $s = is_string($v) ? $v : (string) $v;
        return $s === '' ? null : $s;
    }

    public static function writeJson(int $status, array $body): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($body);
    }

    /**
     * Runs an SDK call, writing its result as `{ok: true, result: ...}` on
     * success or the mapped error envelope on failure. Every model the
     * generated client returns implements JsonSerializable, so the result
     * round-trips into the same wire shape the API sent.
     */
    public static function call(callable $fn): void
    {
        try {
            $result = $fn();
            self::writeJson(200, ['ok' => true, 'result' => $result]);
        } catch (ApiException $e) {
            self::writeSdkError($e);
        } catch (\Throwable $e) {
            self::writeJson(500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Maps a generated ApiException onto the facade's typed error for the UI.
     *
     * `apiResponse` carries the response body exactly as LoginRadius sent
     * it — LoginRadiusException::rawBody() verbatim, decoded for readability
     * when it's JSON. The other fields are OUR derived summary (code pulled
     * out via the manifest's field-alias probing, predicates, etc.) and can
     * legitimately differ from the raw body's own field names — e.g. the raw
     * body says `ErrorCode`/`Description`, this envelope says `error`/
     * `message`. Use `apiResponse` when you need to see precisely what the
     * API returned, with nothing summarised or renamed.
     */
    public static function writeSdkError(ApiException $e): void
    {
        $lr = Client::toLoginRadiusException($e);
        $status = $lr->statusCode() === 0 ? 502 : $lr->statusCode();
        $raw = $lr->rawBody();
        $decoded = $raw !== '' ? json_decode($raw, true) : null;
        self::writeJson($status, [
            'error' => $lr->code() !== '' ? $lr->code() : 'loginradius_error',
            'message' => $lr->description() !== '' ? $lr->description() : $lr->getMessage(),
            'auth' => $lr->isAuth(),
            'forbidden' => $lr->isForbidden(),
            'rateLimited' => $lr->isRateLimit(),
            'server' => $lr->isServer(),
            // The complete, unmodified body LoginRadius returned. null when
            // the request never reached the API at all (a transport failure,
            // or — as with the empty-body custom-object case — a validation
            // error the generated client threw before sending anything).
            'apiResponse' => $decoded ?? ($raw !== '' ? $raw : null),
        ]);
    }

    public static function writeError(\Throwable $e): void
    {
        if ($e instanceof ApiException) {
            self::writeSdkError($e);
            return;
        }
        self::writeJson(500, ['error' => $e->getMessage()]);
    }

    public static function redirect(string $location): void
    {
        http_response_code(302);
        header('Location: ' . $location);
    }

    public static function query(string $key): ?string
    {
        $v = $_GET[$key] ?? null;
        return is_string($v) ? $v : null;
    }

    public static function sessionId(): ?string
    {
        $v = $_COOKIE[self::COOKIE] ?? null;
        return is_string($v) && $v !== '' ? $v : null;
    }

    /**
     * Issues the demo session cookie.
     *
     * HttpOnly keeps the access token out of reach of page scripts, and
     * SameSite=Lax is what lets the email-verification redirect arrive with
     * the cookie still attached. The demo serves plain HTTP on localhost, so
     * Secure is deliberately absent — add it before running this anywhere
     * real.
     */
    public static function setSessionCookie(string $sessionId): void
    {
        header(sprintf('Set-Cookie: %s=%s; Path=/; HttpOnly; SameSite=Lax', self::COOKIE, $sessionId));
    }

    public static function clearSessionCookie(): void
    {
        header(sprintf('Set-Cookie: %s=; Path=/; Max-Age=0; HttpOnly; SameSite=Lax', self::COOKIE));
    }

    /**
     * The access token for an authenticated route. Safe to call only from a
     * handler whose route sets requiresSession — the router validated it
     * already.
     */
    public static function accessToken(DemoSessions $sessions): ?string
    {
        return $sessions->lookup(self::sessionId());
    }

    /**
     * The refresh token for an authenticated route, or null if the current
     * session's login flow never returned one. Safe to call only from a
     * handler whose route sets requiresSession.
     */
    public static function refreshToken(DemoSessions $sessions): ?string
    {
        return $sessions->lookupRefreshToken(self::sessionId());
    }

    /**
     * Issues the MFA challenge cookie, holding the second-factor token
     * itself (not an opaque id) — the token is already short-lived and
     * scoped to one login attempt, so there is nothing extra to protect by
     * indirecting through server-side storage the way the session cookie
     * does. 15-minute expiry matches the token's own validity window.
     */
    public static function setMfaCookie(string $token): void
    {
        header(sprintf(
            'Set-Cookie: %s=%s; Path=/; Max-Age=900; HttpOnly; SameSite=Lax',
            self::MFA_COOKIE,
            $token
        ));
    }

    public static function clearMfaCookie(): void
    {
        header(sprintf('Set-Cookie: %s=; Path=/; Max-Age=0; HttpOnly; SameSite=Lax', self::MFA_COOKIE));
    }

    /** The second-factor token for an in-progress MFA login challenge, or null. */
    public static function mfaToken(): ?string
    {
        $v = $_COOKIE[self::MFA_COOKIE] ?? null;
        return is_string($v) && $v !== '' ? $v : null;
    }

    public static function verificationUrl(): string
    {
        return getenv('LR_VERIFICATION_URL') ?: 'http://localhost:8080/api/auth/verify';
    }

    public static function resetUrl(): string
    {
        return getenv('LR_RESET_PASSWORD_URL') ?: 'http://localhost:8080/?reset=1';
    }
}
