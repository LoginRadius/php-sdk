<?php

// Hand-written — unlike DemoRoutes, this is NOT part of the shared manifest
// contract in manifest/sdk.yaml `demo.routes`. It extends the PHP demo with
// endpoints the other SDKs' demos also expose ad hoc, on top of the 9 routes
// every language's demo shares.

declare(strict_types=1);

namespace LoginRadius\Sdk\Demo;

/** Endpoints added on top of the shared {@see DemoRoutes} contract. */
final class ExtendedRoutes
{
    private function __construct()
    {
    }

    /** Returns the extended endpoint list. Registered by the demo's entry point alongside DemoRoutes. */
    public static function all(DemoHandlers $h): array
    {
        return [
            // Removes an email address from the signed-in user's account.
            new DemoRoute('POST', '/api/email/delete', true, $h->deleteEmail(...)),
            // Deletes the signed-in user's account and clears the local session.
            new DemoRoute('POST', '/api/account/delete', true, $h->deleteAccount(...)),
            // Updates the phone number on the signed-in user's account.
            new DemoRoute('POST', '/api/phone/update', true, $h->updatePhone(...)),
            // Resets a password using a reset token, or an OTP paired with an email or username.
            new DemoRoute('POST', '/api/password/reset-otp', false, $h->resetPasswordWithToken(...)),
            // Creates a new custom object entry for the signed-in user.
            new DemoRoute('POST', '/api/customobject/create', true, $h->createCustomObject(...)),
            // Lists all custom object records of a given type for the signed-in user.
            new DemoRoute('POST', '/api/customobject/list', true, $h->listCustomObjects(...)),
            // Partially updates a custom object record identified by its record ID.
            new DemoRoute('POST', '/api/customobject/update', true, $h->updateCustomObject(...)),
            // Deletes a custom object record identified by its record ID.
            new DemoRoute('POST', '/api/customobject/delete', true, $h->deleteCustomObject(...)),
            // Validates an access token from the request body, or the current session's.
            new DemoRoute('POST', '/api/token/validate', false, $h->validateToken(...)),
            // Returns active session details for the currently signed-in user.
            new DemoRoute('GET', '/api/session/active', true, $h->activeSession(...)),
            // Invalidates the access token upstream, then clears the local session.
            new DemoRoute('POST', '/api/token/invalidate', true, $h->invalidateToken(...)),
            // Begins the Passkey login flow.
            new DemoRoute('POST', '/api/passkey/login/begin', false, $h->beginPasskeyLogin(...)),
            // Begins the Passkey registration flow.
            new DemoRoute('POST', '/api/passkey/register/begin', false, $h->beginPasskeyRegistration(...)),
        ];
    }
}
