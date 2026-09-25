<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Demo;

use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Config;
use LoginRadius\Sdk\Internal\OpenApi\ApiException;
use LoginRadius\Sdk\Internal\OpenApi\ObjectSerializer;
use LoginRadius\Sdk\Internal\OpenApi\Model\AddEmailModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\AuthenticatorCodeRequest;
use LoginRadius\Sdk\Internal\OpenApi\Model\ChangePassword;
use LoginRadius\Sdk\Internal\OpenApi\Model\DeleteemailbyaccesstokenRequest;
use LoginRadius\Sdk\Internal\OpenApi\Model\EmailByLoginUserNamePhoneRequest;
use LoginRadius\Sdk\Internal\OpenApi\Model\EmailModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\ForgotPasswordPhoneModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\ForgotPasswordRequest;
use LoginRadius\Sdk\Internal\OpenApi\Model\PasskeyLoginFinish;
use LoginRadius\Sdk\Internal\OpenApi\Model\PasskeyRegisterFinish;
use LoginRadius\Sdk\Internal\OpenApi\Model\PasswordLessEmailOTPModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\PhoneIdModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\PhoneOTPModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\ProfileRequestModel;
use LoginRadius\Sdk\Internal\OpenApi\Model\ProfileRequestModelEmailInner;
use LoginRadius\Sdk\Internal\OpenApi\Model\ReAuthModelByEmailOtp;
use LoginRadius\Sdk\Internal\OpenApi\Model\ResetPassword;
use LoginRadius\Sdk\Internal\OpenApi\Model\ResetPasswordWithOTP;
use LoginRadius\Sdk\Internal\OpenApi\Model\UpdateAccountByAccessTokenRequest;
use LoginRadius\Sdk\Sott;

/**
 * The demo's contract handlers, one per route in {@see DemoRoutes} — the nine
 * `core` routes plus the four `passwordless` ones PHP has adopted — plus
 * hand-written extended handlers for email, phone, custom objects, token
 * management, and passkeys (registered alongside them by the demo's entry
 * point; see {@see ExtendedRoutes}).
 *
 * `DemoRoutes::all()` references every method below by name, so this class
 * stops compiling the moment the manifest gains a route nobody has
 * implemented. HTTP-method checking and session enforcement live in the entry
 * point — each handler here is only the interesting part: the SDK call.
 */
final class DemoHandlers
{
    public function __construct(
        private readonly Client $client,
        private readonly Config $config,
        private readonly DemoSessions $sessions
    ) {
    }

    // ------------------------------------------------------------------ auth --

    /**
     * Registers a new user. Mints a SOTT server-side; never accepts one from
     * the client. Tenants configured to require email verification return a
     * profile with no access token, so a session is minted only when one
     * actually came back — the response says which happened, because
     * "registered but not signed in" is otherwise a confusing state to land in.
     */
    public function register(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        $password = Demo::get($input, 'password');
        if ($email === null || $password === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email, password}']);
            return;
        }
        if ($this->config->apiSecret() === null || $this->config->apiSecret() === '') {
            Demo::writeJson(500, ['error' => 'LR_API_SECRET is required for registration']);
            return;
        }

        // Minted per request: a SOTT is valid for ten minutes, so it must
        // never come from configuration — and never from the client.
        $sott = Sott::generate((string) $this->config->apiKey(), $this->config->apiSecret());

        $body = new ProfileRequestModel([
            'email' => [new ProfileRequestModelEmailInner(['type' => 'Primary', 'value' => $email])],
            'password' => $password,
            'firstName' => Demo::get($input, 'firstName'),
            'lastName' => Demo::get($input, 'lastName'),
        ]);

        try {
            $result = $this->client->registration->userRegistrationBySottEmailPhoneUserName(
                $body,
                sott: $sott,
                verificationurl: Demo::verificationUrl()
            );
            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];
            // Some tenants nest the profile under `Data` on this response.
            $flat = is_array($decoded['Data'] ?? null) ? $decoded['Data'] : $decoded;

            $accessToken = $flat['access_token'] ?? null;
            $signedIn = false;
            if (is_string($accessToken) && $accessToken !== '') {
                $refreshToken = $flat['refresh_token'] ?? '';
                Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
                $signedIn = true;
            }
            Demo::writeJson(200, ['signed_in' => $signedIn, 'profile' => $decoded]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /** Email + password login. Stores the returned access token in the demo session. */
    public function login(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        $password = Demo::get($input, 'password');
        if ($email === null || $password === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email, password}']);
            return;
        }
        try {
            $body = new EmailByLoginUserNamePhoneRequest(['email' => $email, 'password' => $password]);
            $result = $this->client->login->emailByLoginUserNamePhone($body);

            // Round-tripped through JSON rather than reading typed properties:
            // this is a oneOf response (success / MFA challenge), and every
            // model already implements JsonSerializable, so this is the same
            // encoder the SDK itself trusts to describe whichever branch was
            // resolved — no separate decoder to keep in sync with it.
            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];

            // MFA challenge: surface it instead of treating it as a failure.
            // `SecondFactorAuthenticationToken` (see AuthResponseRequiredMfa's
            // wire mapping) is a flat string, present only on the challenge
            // branch of this oneOf response — absent (not merely empty) on a
            // normal success.
            $mfaToken = $decoded['SecondFactorAuthenticationToken'] ?? null;
            if (is_string($mfaToken) && $mfaToken !== '') {
                Demo::setMfaCookie($mfaToken);
                Demo::writeJson(200, [
                    'mfa_required' => true,
                    'totp_enrolled' => (bool) ($decoded['IsGoogleAuthenticatorVerified'] ?? $decoded['IsAuthenticatorVerified'] ?? false),
                    'manual_entry_code' => $decoded['ManualEntryCode'] ?? null,
                    'qr_code' => $decoded['QRCode'] ?? null,
                    'response' => $decoded,
                ]);
                return;
            }

            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'login succeeded but no access_token was returned']);
                return;
            }
            $refreshToken = $decoded['refresh_token'] ?? '';

            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'result' => $decoded]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /** Invalidates the access token upstream, then clears the demo session. */
    public function logout(): void
    {
        // The local session is cleared even if the upstream call fails —
        // otherwise a transient API error would leave the user unable to sign out.
        $this->sessions->delete(Demo::sessionId());
        Demo::clearSessionCookie();
        Demo::writeJson(200, ['ok' => true]);
    }

    // ------------------------------------------------------- passwordless --

    /** Emails a one-time code to an existing user; no password involved. */
    public function passwordlessLoginByEmail(): void
    {
        $email = Demo::query('email');
        if ($email === null || $email === '') {
            Demo::writeJson(400, ['error' => 'expected query param ?email=']);
            return;
        }
        Demo::call(fn () => $this->client->login->passwordlessLoginByEmail(email: $email));
    }

    /**
     * Completes an email passwordless login. Same response shape as
     * {@see login}, including the MFA-challenge branch — a tenant with MFA
     * enabled still enforces its second factor after the emailed code.
     */
    public function passwordlessLoginByEmailOtp(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        $otp = Demo::get($input, 'otp');
        if ($email === null || $otp === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email, otp}']);
            return;
        }
        try {
            $body = new PasswordLessEmailOTPModel(['email' => $email, 'otp' => $otp]);
            $result = $this->client->login->passwordlessLoginByEmailAndOTP($body);

            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];

            $mfaToken = $decoded['SecondFactorAuthenticationToken'] ?? null;
            if (is_string($mfaToken) && $mfaToken !== '') {
                Demo::setMfaCookie($mfaToken);
                Demo::writeJson(200, [
                    'mfa_required' => true,
                    'totp_enrolled' => (bool) ($decoded['IsGoogleAuthenticatorVerified'] ?? $decoded['IsAuthenticatorVerified'] ?? false),
                    'manual_entry_code' => $decoded['ManualEntryCode'] ?? null,
                    'qr_code' => $decoded['QRCode'] ?? null,
                    'response' => $decoded,
                ]);
                return;
            }

            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'login succeeded but no access_token was returned']);
                return;
            }
            $refreshToken = $decoded['refresh_token'] ?? '';

            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'result' => $decoded]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /** Texts a one-time code to an existing user; no password involved. */
    public function passwordlessLoginByPhone(): void
    {
        $phone = Demo::query('phone');
        if ($phone === null || $phone === '') {
            Demo::writeJson(400, ['error' => 'expected query param ?phone=']);
            return;
        }
        Demo::call(fn () => $this->client->login->passwordlessLoginByPhone(phone: $phone));
    }

    /**
     * Completes a phone passwordless login. Same response shape as
     * {@see login}, including the MFA-challenge branch.
     */
    public function passwordlessLoginByPhoneOtp(): void
    {
        $input = Demo::readJson();
        $phone = Demo::get($input, 'phone');
        $otp = Demo::get($input, 'otp');
        if ($phone === null || $otp === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {phone, otp}']);
            return;
        }
        try {
            $body = new PhoneOTPModel(['phone' => $phone, 'otp' => $otp]);
            $result = $this->client->login->passwordlessLoginPhoneVerification($body);

            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];

            $mfaToken = $decoded['SecondFactorAuthenticationToken'] ?? null;
            if (is_string($mfaToken) && $mfaToken !== '') {
                Demo::setMfaCookie($mfaToken);
                Demo::writeJson(200, [
                    'mfa_required' => true,
                    'totp_enrolled' => (bool) ($decoded['IsGoogleAuthenticatorVerified'] ?? $decoded['IsAuthenticatorVerified'] ?? false),
                    'manual_entry_code' => $decoded['ManualEntryCode'] ?? null,
                    'qr_code' => $decoded['QRCode'] ?? null,
                    'response' => $decoded,
                ]);
                return;
            }

            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'login succeeded but no access_token was returned']);
                return;
            }
            $refreshToken = $decoded['refresh_token'] ?? '';

            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'result' => $decoded]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /**
     * Landing point for the link in the verification email. Redirects back to
     * the UI with a status banner rather than returning JSON, because a
     * browser lands here directly.
     */
    public function verifyEmail(): void
    {
        $token = Demo::query('vtoken');
        if ($token === null || $token === '') {
            Demo::redirect('/?verify=missing');
            return;
        }
        try {
            // The verification endpoint shares its path with the availability
            // check, so the SDK exposes one operation; passing
            // verificationtoken performs the verification.
            $this->client->user->checkEmailAvailability(verificationtoken: $token);
            Demo::redirect('/?verify=success');
        } catch (ApiException $e) {
            // Never redirect with the raw exception message: Guzzle's message
            // for a failed request includes the full request URI, and this
            // operation sends the API secret as a query parameter — so the
            // raw message would leak it into a client-visible Location header
            // (browser history, proxy/access logs, Referer). Route through
            // LoginRadiusException, which extracts only the API's own
            // Description/Message fields from the response body.
            $lr = Client::toLoginRadiusException($e);
            $msg = $lr->description() !== '' ? $lr->description() : 'verification failed';
            Demo::redirect('/?verify=error&message=' . rawurlencode($msg));
        } catch (\Throwable $e) {
            Demo::redirect('/?verify=error&message=' . rawurlencode('verification failed'));
        }
    }

    // -------------------------------------------------------------- password --

    /** Sends a password-reset email containing a reset token. */
    public function forgotPassword(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        if ($email === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email}']);
            return;
        }
        $body = new ForgotPasswordRequest(['email' => $email]);
        Demo::call(fn () => $this->client->password->forgotPassword(
            resetpasswordurl: Demo::resetUrl(),
            forgotPasswordRequest: $body
        ));
    }

    /** Completes a reset using the token from the email. */
    public function resetPassword(): void
    {
        $input = Demo::readJson();
        $token = Demo::get($input, 'resetToken');
        $password = Demo::get($input, 'password');
        if ($token === null || $password === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {resetToken, password}']);
            return;
        }
        $body = new ResetPassword(['resetToken' => $token, 'password' => $password]);
        Demo::call(fn () => $this->client->password->resetPasswordByResetToken($body));
    }

    /** Changes the signed-in user's password. */
    public function changePassword(): void
    {
        $input = Demo::readJson();
        $oldPassword = Demo::get($input, 'oldPassword');
        $newPassword = Demo::get($input, 'newPassword');
        if ($oldPassword === null || $newPassword === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {oldPassword, newPassword}']);
            return;
        }
        $body = new ChangePassword(['oldPassword' => $oldPassword, 'newPassword' => $newPassword]);
        Demo::call(fn () => $this->client->password->changePassword(
            $body,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    // --------------------------------------------------------------- profile --

    /** Returns the signed-in user's profile. */
    public function getProfile(): void
    {
        Demo::call(fn () => $this->client->user->getAccountDetails(
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Updates editable fields on the signed-in user's profile. */
    public function updateProfile(): void
    {
        $input = Demo::readJson();
        $body = new UpdateAccountByAccessTokenRequest([
            'firstName' => Demo::get($input, 'firstName'),
            'lastName' => Demo::get($input, 'lastName'),
            'about' => Demo::get($input, 'about'),
        ]);
        Demo::call(fn () => $this->client->user->updateAccountByAccessToken(
            $body,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    // --------------------------------------------------------------- email   --

    /** Adds a secondary email to the signed-in user's account. */
    public function addEmail(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        if ($email === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email, type}']);
            return;
        }
        $type = Demo::get($input, 'type');
        $body = new AddEmailModel(['email' => $email, 'type' => $type ?? 'Secondary']);

        Demo::call(fn () => $this->client->user->addEmail(
            $body,
            accessToken: Demo::accessToken($this->sessions),
            verificationurl: Demo::verificationUrl()
        ));
    }

    /** Removes an email address from the signed-in user's account. */
    public function deleteEmail(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        if ($email === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email}']);
            return;
        }
        $body = new DeleteemailbyaccesstokenRequest([
            'email' => $email,
            'accessToken' => Demo::accessToken($this->sessions),
        ]);
        Demo::call(fn () => $this->client->user->deleteemailbyaccesstoken($body));
    }

    /**
     * Deletes the signed-in user's own account.
     *
     * The underlying operation is ADMIN-scoped: it authenticates with the API
     * secret and will delete any account in the tenant by email address.
     * Exposing that straight through would let anyone with a demo session
     * delete anyone else, so this handler reads the signed-in profile first
     * and refuses unless the address matches one the session actually owns.
     * That guard is demo policy, not an SDK limitation.
     */
    public function deleteAccount(): void
    {
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        if ($email === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email}']);
            return;
        }
        try {
            $profile = $this->client->user->getAccountDetails(accessToken: Demo::accessToken($this->sessions));
            $decodedProfile = json_decode((string) json_encode($profile), true);
            $decodedProfile = is_array($decodedProfile) ? $decodedProfile : [];
            $owned = array_filter(array_map(
                static fn ($e) => strtolower(trim((string) ($e['Value'] ?? ''))),
                is_array($decodedProfile['Email'] ?? null) ? $decodedProfile['Email'] : []
            ));
            if (!in_array(strtolower($email), $owned, true)) {
                Demo::writeJson(403, [
                    'error' => 'refusing to delete an account you are not signed in as',
                    'hint' => 'the demo only deletes the signed-in account; the underlying API would delete any address',
                ]);
                return;
            }

            $result = $this->client->accounts->deleteAccountByEmail($email);
            $this->sessions->delete(Demo::sessionId());
            Demo::clearSessionCookie();
            Demo::clearMfaCookie();
            Demo::writeJson(200, ['deleted' => $result]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    // --------------------------------------------------------------- phone   --

    /** Updates the phone number on the signed-in user's account. */
    public function updatePhone(): void
    {
        $input = Demo::readJson();
        $phone = Demo::get($input, 'phone');
        if ($phone === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {phone}']);
            return;
        }
        Demo::call(fn () => $this->client->user->changePhoneNumber(
            accessToken: Demo::accessToken($this->sessions),
            phoneIdModel: new PhoneIdModel(['phone' => $phone])
        ));
    }

    // --------------------------------------------------------------- account --

    /**
     * Resets a password using a reset token, or an OTP paired with either an
     * email or a username — the three branches of the "Reset Password with
     * token and OTP" operation.
     */
    public function resetPasswordWithToken(): void
    {
        $input = Demo::readJson();
        $password = Demo::get($input, 'password');
        $resetToken = Demo::get($input, 'resetToken');
        $otp = Demo::get($input, 'otp');
        $email = Demo::get($input, 'email');
        $username = Demo::get($input, 'username');

        $usage = 'expected JSON {password, resetToken} or {password, otp, email} or {password, otp, username}';
        if ($password === null) {
            Demo::writeJson(400, ['error' => $usage]);
            return;
        }

        if ($resetToken !== null) {
            $body = new ResetPassword(['resetToken' => $resetToken, 'password' => $password]);
        } elseif ($otp !== null && $email !== null) {
            $body = new ResetPassword(['otp' => $otp, 'email' => $email, 'password' => $password]);
        } elseif ($otp !== null && $username !== null) {
            $body = new ResetPassword(['otp' => $otp, 'username' => $username, 'password' => $password]);
        } else {
            Demo::writeJson(400, ['error' => $usage]);
            return;
        }

        Demo::call(fn () => $this->client->password->resetPasswordWithOTP($body));
    }

    // --------------------------------------------------------- custom objects --

    /** Creates a new custom object entry for the signed-in user. */
    private const CUSTOM_OBJECT_PATH_PREFIX = '/api/customobject/';

    /**
     * Resolves the custom-object schema name. An explicit value from the
     * caller (this demo's UI always sends one) wins; the manifest's generated
     * routes declare this via configQuery instead — no client value at all —
     * so LR_CUSTOM_OBJECT_NAME is the fallback for that caller shape.
     */
    private static function resolveObjectName(array $input): ?string
    {
        return Demo::get($input, 'objectname') ?? Demo::query('objectname') ?? (getenv('LR_CUSTOM_OBJECT_NAME') ?: null);
    }

    /**
     * Resolves the record id an update/delete targets. The manifest's
     * generated routes carry it as a URL path segment (PUT/DELETE
     * /api/customobject/{objectRecordId}); this demo's UI and the old
     * hand-written routes send it as a body field instead.
     */
    /**
     * Disambiguated by HTTP method, not path prefix alone: both the new
     * PUT/DELETE /api/customobject/{objectRecordId} route and the old
     * POST /api/customobject/update|delete routes share the literal prefix
     * /api/customobject/, so a prefix-only check misreads the old routes'
     * own fixed suffix ("update", "delete") as if it were a record id. The
     * manifest declares this path PUT/DELETE only, so method is a reliable
     * signal; the old routes are always POST.
     */
    private static function resolveRecordId(array $input): ?string
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        if (($method === 'PUT' || $method === 'DELETE')
            && str_starts_with($path, self::CUSTOM_OBJECT_PATH_PREFIX)
            && strlen($path) > strlen(self::CUSTOM_OBJECT_PATH_PREFIX)) {
            return substr($path, strlen(self::CUSTOM_OBJECT_PATH_PREFIX));
        }
        return Demo::get($input, 'objectrecordid');
    }

    public function createCustomObject(): void
    {
        $input = Demo::readJson();
        $objectname = self::resolveObjectName($input);
        if ($objectname === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {objectname, ...fields}, or configure LR_CUSTOM_OBJECT_NAME']);
            return;
        }
        $data = self::requestBody($input, 'objectname');
        if ($data === []) {
            // The generated client rejects an empty body with an
            // InvalidArgumentException before ever calling the API — catch
            // it here instead, so this reads as an ordinary validation error
            // rather than an uncaught-exception 500.
            Demo::writeJson(400, ['error' => 'expected at least one field besides objectname']);
            return;
        }
        Demo::call(fn () => $this->client->customObject->createCustomObjectByToken(
            $data,
            objectname: $objectname,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Lists all custom object records of the given type for the signed-in user. */
    public function listCustomObjects(): void
    {
        $input = Demo::readJson();
        $objectname = self::resolveObjectName($input);
        if ($objectname === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {objectname}, or configure LR_CUSTOM_OBJECT_NAME']);
            return;
        }
        Demo::call(fn () => $this->client->customObject->getCustomObjectByToken(
            objectname: $objectname,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Partially updates a custom object record identified by its record ID. */
    public function updateCustomObject(): void
    {
        $input = Demo::readJson();
        $objectname = self::resolveObjectName($input);
        $recordId = self::resolveRecordId($input);
        if ($objectname === null || $recordId === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {objectname, objectrecordid, ...fields} '
                . '(or a record id in the URL, and LR_CUSTOM_OBJECT_NAME configured)']);
            return;
        }
        $data = self::requestBody($input, 'objectname', 'objectrecordid');
        if ($data === []) {
            // Same client-side guard as createCustomObject — see its comment.
            Demo::writeJson(400, ['error' => 'expected at least one field besides objectname/objectrecordid']);
            return;
        }
        Demo::call(fn () => $this->client->customObject->updateCustomObjectByTokenAndRecordId(
            $recordId,
            'PartialReplace',
            $data,
            objectname: $objectname,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Deletes a custom object record identified by its record ID. */
    public function deleteCustomObject(): void
    {
        $input = Demo::readJson();
        $objectname = self::resolveObjectName($input);
        $recordId = self::resolveRecordId($input);
        if ($objectname === null || $recordId === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {objectname, objectrecordid} '
                . '(or a record id in the URL, and LR_CUSTOM_OBJECT_NAME configured)']);
            return;
        }
        Demo::call(fn () => $this->client->customObject->deleteCustomObjectByTokenAndRecordId(
            $recordId,
            objectname: $objectname,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Builds a custom-object request body from the raw JSON input, dropping the routing keys. */
    private static function requestBody(array $input, string ...$omit): array
    {
        return array_diff_key($input, array_flip($omit));
    }

    // --------------------------------------------------------------- token   --

    /**
     * Exchanges the session's refresh token for a new access token and
     * rotates what the demo session holds.
     *
     * Refreshing INVALIDATES the previous access token upstream, so a session
     * left holding the old one is not merely stale — every subsequent
     * authenticated call fails. Session id (and cookie) stay the same;
     * only the tokens behind it are replaced.
     */
    public function refreshToken(): void
    {
        $refreshToken = Demo::refreshToken($this->sessions);
        if ($refreshToken === null) {
            Demo::writeJson(400, [
                'error' => 'this session has no refresh token; the tenant did not return one at login',
            ]);
            return;
        }
        try {
            $result = $this->client->accountSession->refreshAccessToken($refreshToken);
            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];
            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'refresh succeeded but returned no access_token']);
                return;
            }
            $nextRefreshToken = $decoded['refresh_token'] ?? '';
            $sessionId = Demo::sessionId();
            if ($sessionId !== null) {
                $this->sessions->replace($sessionId, $accessToken, is_string($nextRefreshToken) ? $nextRefreshToken : '');
            }
            Demo::writeJson(200, [
                'refreshed' => true,
                'rotated' => is_string($nextRefreshToken) && $nextRefreshToken !== '',
                'expires_in' => $decoded['expires_in'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /**
     * Validates an access token. Uses the token from the request body if
     * provided; falls back to the current session's token.
     */
    public function validateToken(): void
    {
        $input = Demo::readJson();
        $token = Demo::get($input, 'accessToken') ?? Demo::accessToken($this->sessions);
        if ($token === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {accessToken} or an active session']);
            return;
        }
        Demo::call(fn () => $this->client->accountSession->validateAccessToken($token));
    }

    /** Returns active session details for the currently signed-in user. */
    public function activeSession(): void
    {
        Demo::call(fn () => $this->client->accountSession->getActiveSession(
            token: Demo::accessToken($this->sessions)
        ));
    }

    /**
     * Invalidates the access token on the LoginRadius API, then clears the
     * local session. Unlike logout (which only clears the local session),
     * this revokes the token server-side so it cannot be reused.
     */
    public function invalidateToken(): void
    {
        try {
            $this->client->accountSession->nativeInvalidateAccessToken(
                accessToken: Demo::accessToken($this->sessions)
            );
            $this->sessions->delete(Demo::sessionId());
            Demo::clearSessionCookie();
            Demo::writeJson(200, ['ok' => true]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    // --------------------------------------------------------------- passkey --

    /** Begins the Passkey login flow — returns the WebAuthn assertion challenge. */
    public function beginPasskeyLogin(): void
    {
        $input = Demo::readJson();
        $identifier = Demo::get($input, 'identifier');
        if ($identifier === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {identifier}']);
            return;
        }
        Demo::call(fn () => $this->client->login->beginPasskeyLogin($identifier));
    }

    /** Begins the Passkey registration flow — returns the WebAuthn creation challenge. */
    public function beginPasskeyRegistration(): void
    {
        $input = Demo::readJson();
        $identifier = Demo::get($input, 'identifier');
        if ($identifier === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {identifier}']);
            return;
        }
        Demo::call(fn () => $this->client->registration->beginPasskeyRegistration($identifier));
    }

    /**
     * Completes the Passkey registration flow with the attestation response
     * from the browser's navigator.credentials.create() call. The raw JSON
     * body must match the PasskeyRegisterFinish schema (wire-format property
     * names, e.g. "PasskeyCredential") — deserialized with the SDK's own
     * ObjectSerializer, the same one every API response goes through, rather
     * than the model constructor's PHP-property-named array.
     */
    public function finishPasskeyRegistration(): void
    {
        $raw = file_get_contents('php://input');
        $decoded = $raw === false || $raw === '' ? null : json_decode($raw);
        if (!is_object($decoded)) {
            Demo::writeJson(400, ['error' => 'request body must match the PasskeyRegisterFinish schema']);
            return;
        }
        $body = ObjectSerializer::deserialize($decoded, PasskeyRegisterFinish::class, []);
        Demo::call(fn () => $this->client->registration->finishPasskeyRegistration(
            $body,
            verificationurl: Demo::verificationUrl()
        ));
    }

    /**
     * Completes the Passkey login flow with the assertion response from the
     * browser's navigator.credentials.get() call. Deserialized the same way
     * as finishPasskeyRegistration — see that method's comment. On success
     * this IS a login: mints the demo session exactly like login() does.
     */
    public function finishPasskeyLogin(): void
    {
        $raw = file_get_contents('php://input');
        $decoded = $raw === false || $raw === '' ? null : json_decode($raw);
        if (!is_object($decoded)) {
            Demo::writeJson(400, ['error' => 'request body must match the PasskeyLoginFinish schema']);
            return;
        }
        $body = ObjectSerializer::deserialize($decoded, PasskeyLoginFinish::class, []);
        try {
            $result = $this->client->login->finishPasskeyLogin($body);
            $decodedResult = json_decode((string) json_encode($result), true);
            $decodedResult = is_array($decodedResult) ? $decodedResult : [];
            $accessToken = $decodedResult['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'authentication succeeded but no access_token returned']);
                return;
            }
            $refreshToken = $decodedResult['refresh_token'] ?? '';
            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'profile' => $decodedResult['Profile'] ?? null]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    // ------------------------------------------------------------------- mfa --
    // Settings/enrolment routes are auth: session, same as every other
    // extended route. The three "login challenge" routes below are
    // authenticated by the lr_mfa cookie instead (see Demo::mfaToken) — they
    // deliberately pass requiresSession: false in ExtendedRoutes and check it
    // by hand, because a half-authenticated user must never satisfy the
    // session check.

    /** Returns which second factors are configured on the signed-in account. */
    public function mfaSettings(): void
    {
        Demo::call(fn () => $this->client->security->getMFASettings(
            duoredirecturi: Demo::query('duoRedirectUri'),
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Confirms a TOTP code and enrols the authenticator on the account. */
    public function mfaEnrolTotp(): void
    {
        $input = Demo::readJson();
        $totp = Demo::get($input, 'totp');
        if ($totp === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {totp}']);
            return;
        }
        $body = new AuthenticatorCodeRequest(['authenticatorcode' => $totp]);
        Demo::call(fn () => $this->client->security->verify2faTOTPAuth(
            $body,
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Issues a fresh set of single-use MFA backup codes. */
    public function mfaBackupCodes(): void
    {
        Demo::call(fn () => $this->client->security->mfaGenerateBackupCodes(
            accessToken: Demo::accessToken($this->sessions)
        ));
    }

    /** Sends an email OTP for an in-progress MFA login challenge. */
    public function mfaSendEmailOtp(): void
    {
        $mfaToken = Demo::mfaToken();
        if ($mfaToken === null) {
            Demo::writeJson(401, ['error' => 'no MFA challenge in progress']);
            return;
        }
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        if ($email === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email}']);
            return;
        }
        Demo::call(fn () => $this->client->security->resendEmailOTPMFAToken(
            $mfaToken,
            new EmailModel(['email' => $email])
        ));
    }

    /**
     * Completes an in-progress MFA login challenge with an email OTP. Clears
     * the mfa cookie and mints a real session cookie on success.
     */
    public function mfaVerifyEmailOtp(): void
    {
        $mfaToken = Demo::mfaToken();
        if ($mfaToken === null) {
            Demo::writeJson(401, ['error' => 'no MFA challenge in progress']);
            return;
        }
        $input = Demo::readJson();
        $email = Demo::get($input, 'email');
        $otp = Demo::get($input, 'otp');
        if ($email === null || $otp === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {email, otp}']);
            return;
        }
        try {
            $result = $this->client->security->validateMfaOTPByEmail(
                $mfaToken,
                new ReAuthModelByEmailOtp(['emailid' => $email, 'otp' => $otp])
            );
            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];
            Demo::clearMfaCookie();
            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'authentication succeeded but no access_token returned']);
                return;
            }
            $refreshToken = $decoded['refresh_token'] ?? '';
            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'profile' => $decoded['Profile'] ?? null]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    /**
     * Completes an in-progress MFA login challenge with a TOTP code. Clears
     * the mfa cookie and mints a real session cookie on success.
     */
    public function mfaVerifyTotp(): void
    {
        $mfaToken = Demo::mfaToken();
        if ($mfaToken === null) {
            Demo::writeJson(401, ['error' => 'no MFA challenge in progress']);
            return;
        }
        $input = Demo::readJson();
        $totp = Demo::get($input, 'totp');
        if ($totp === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {totp}']);
            return;
        }
        try {
            $result = $this->client->security->verifyTotpByMfaToken(
                $mfaToken,
                new AuthenticatorCodeRequest(['authenticatorcode' => $totp])
            );
            $decoded = json_decode((string) json_encode($result), true);
            $decoded = is_array($decoded) ? $decoded : [];
            Demo::clearMfaCookie();
            $accessToken = $decoded['access_token'] ?? null;
            if (!is_string($accessToken) || $accessToken === '') {
                Demo::writeJson(502, ['error' => 'authentication succeeded but no access_token returned']);
                return;
            }
            $refreshToken = $decoded['refresh_token'] ?? '';
            Demo::setSessionCookie($this->sessions->create($accessToken, is_string($refreshToken) ? $refreshToken : ''));
            Demo::writeJson(200, ['ok' => true, 'profile' => $decoded['Profile'] ?? null]);
        } catch (\Throwable $e) {
            Demo::writeError($e);
        }
    }

    // -------------------------------------------------------- password (OTP) --
    // Phone/SMS-based reset — a distinct flow from resetPasswordWithToken() above
    // (which is email/username-based via a different operation). Matches
    // Node's demo: `requestOTPForPasswordReset` sends the SMS, then
    // `resetPasswordWithOTP` (the phone-shaped model, not `ResetPassword`)
    // completes it.

    /** Sends a password-reset OTP by SMS to the phone number on the account. */
    public function requestResetOtp(): void
    {
        $input = Demo::readJson();
        $phone = Demo::get($input, 'phone');
        if ($phone === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {phone}']);
            return;
        }
        Demo::call(fn () => $this->client->password->requestOTPForPasswordReset(
            new ForgotPasswordPhoneModel(['phone' => $phone])
        ));
    }

    /** Completes a password reset using the OTP delivered by SMS. */
    public function resetPasswordWithOtp(): void
    {
        $input = Demo::readJson();
        $phone = Demo::get($input, 'phone');
        $otp = Demo::get($input, 'otp');
        $password = Demo::get($input, 'password');
        if ($phone === null || $otp === null || $password === null) {
            Demo::writeJson(400, ['error' => 'expected JSON {phone, otp, password}']);
            return;
        }
        Demo::call(fn () => $this->client->password->resetPasswordWithOTP(
            new ResetPasswordWithOTP(['phone' => $phone, 'otp' => $otp, 'password' => $password])
        ));
    }
}
