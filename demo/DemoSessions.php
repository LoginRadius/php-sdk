<?php

declare(strict_types=1);

namespace LoginRadius\Sdk\Demo;

/**
 * Session store mapping an opaque session id to the LoginRadius access token
 * it carries. DEMO ONLY — a real application persists sessions durably (not
 * a plaintext file), encrypts or hashes what it stores, and never keys them
 * by a value this predictable.
 *
 * Backed by a JSON file rather than an in-memory array on purpose: unlike
 * every other language's demo, PHP's built-in web server (`php -S`) re-runs
 * the router script from scratch for every request — nothing held only in a
 * PHP variable survives past the response that set it. A file is the
 * simplest thing that actually persists across that per-request lifecycle
 * without pulling in a session extension or a database for a demo.
 */
final class DemoSessions
{
    private string $storePath;

    public function __construct()
    {
        $this->storePath = sys_get_temp_dir() . '/loginradius-php-demo-sessions.json';
    }

    /**
     * Creates a new session for $accessToken (and, if the tenant returned
     * one, $refreshToken) and returns its id.
     */
    public function create(string $accessToken, string $refreshToken = ''): string
    {
        $id = bin2hex(random_bytes(16));
        $sessions = $this->load();
        $sessions[$id] = ['accessToken' => $accessToken, 'refreshToken' => $refreshToken];
        $this->save($sessions);
        return $id;
    }

    public function lookup(?string $id): ?string
    {
        if ($id === null) {
            return null;
        }
        return $this->load()[$id]['accessToken'] ?? null;
    }

    public function lookupRefreshToken(?string $id): ?string
    {
        if ($id === null) {
            return null;
        }
        $token = $this->load()[$id]['refreshToken'] ?? null;
        return is_string($token) && $token !== '' ? $token : null;
    }

    /**
     * Rotates the tokens held by an existing session in place — the id (and
     * therefore the browser's cookie) does not change. Used after a refresh,
     * which invalidates the previous access token upstream: a session left
     * holding it would fail on every subsequent authenticated call.
     */
    public function replace(string $id, string $accessToken, string $refreshToken): void
    {
        $sessions = $this->load();
        if (!isset($sessions[$id])) {
            return;
        }
        $sessions[$id] = ['accessToken' => $accessToken, 'refreshToken' => $refreshToken];
        $this->save($sessions);
    }

    public function delete(?string $id): void
    {
        if ($id === null) {
            return;
        }
        $sessions = $this->load();
        unset($sessions[$id]);
        $this->save($sessions);
    }

    /** @return array<string, array{accessToken: string, refreshToken: string}> */
    private function load(): array
    {
        if (!is_file($this->storePath)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($this->storePath), true);
        return is_array($decoded) ? $decoded : [];
    }

    /** @param array<string, array{accessToken: string, refreshToken: string}> $sessions */
    private function save(array $sessions): void
    {
        file_put_contents($this->storePath, json_encode($sessions), LOCK_EX);
    }
}
