<?php

// A runnable demo of the LoginRadius PHP SDK.
//
// Uses PHP's built-in web server — the same reasoning as the Go and Java
// demos using net/http / HttpServer — so the demo adds no dependency beyond
// the LoginRadius facade itself.
//
//   export LR_API_KEY=... LR_API_SECRET=...
//   php -S localhost:8080 demo/index.php
//
// Reads the same environment variables as every other language's demo:
// LR_API_KEY, LR_API_SECRET, and the optional server-selection trio
// LR_DOMAIN / LR_CUSTOM_DOMAIN / LR_BASE_URL.

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use LoginRadius\Sdk\Client;
use LoginRadius\Sdk\Config;
use LoginRadius\Sdk\Demo\Demo;
use LoginRadius\Sdk\Demo\DemoHandlers;
use LoginRadius\Sdk\Demo\DemoRoutes;
use LoginRadius\Sdk\Demo\DemoSessions;
use LoginRadius\Sdk\Demo\ExtendedRoutes;

// Load .env from the repo root (dev convenience — never do this in
// production). The built-in server's cwd is wherever it was launched from;
// .env lives one level up from this file regardless.
$envPath = dirname(__DIR__) . '/.env';
if (is_file($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        // Strip a UTF-8 BOM on the very first key, if the file has one.
        $key = ltrim($key, "\xEF\xBB\xBF");
        if (getenv($key) === false) {
            putenv($key . '=' . trim($value));
        }
    }
}

$apiKey = getenv('LR_API_KEY');
if ($apiKey === false || $apiKey === '') {
    // Not the STDERR constant: php -S re-invokes this file as a per-request
    // router script, and that SAPI context does not reliably predefine it —
    // a missing key would otherwise crash with "Undefined constant STDERR"
    // instead of this message. php://stderr always works.
    fwrite(fopen('php://stderr', 'w'), "LR_API_KEY is required\n");
    exit(1);
}

$config = new Config(
    apiKey: $apiKey,
    apiSecret: getenv('LR_API_SECRET') ?: null,
    // Server selection, same precedence as every other SDK.
    domain: getenv('LR_DOMAIN') ?: null,
    customDomain: getenv('LR_CUSTOM_DOMAIN') ?: null,
    baseURL: getenv('LR_BASE_URL') ?: null,
    userAgent: 'loginradius-php-demo/0.1'
);
$client = new Client($config);
$sessions = new DemoSessions();
$handlers = new DemoHandlers($client, $config, $sessions);

// The API surface comes from DemoRoutes, generated from manifest/sdk.yaml,
// plus ExtendedRoutes (hand-written, not part of the shared contract — see
// its header comment). Registering from the table (rather than by hand) is
// what keeps every language's demo on the same endpoints: method checking and
// session enforcement are applied uniformly here instead of being
// re-implemented, slightly differently, in each handler.
$routes = [...DemoRoutes::all($handlers), ...ExtendedRoutes::all($handlers)];

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// The UI and its assets. Not part of the shared contract; each language's demo
// ships its own markup, which is deliberate — only the stylesheet is shared.
//
// `php -S` with a router script hands EVERY request to this file, static files
// included, so the assets have to be served from here. Serving only index.html
// is not enough: a page that links a stylesheet the server will not hand out
// renders unstyled, and it does so silently, behind a 404 nobody sees without
// opening devtools.
$asset = $path === '/' ? 'index.html' : substr($path, 1);
// The web root is flat, so a legitimate asset name contains no separator.
// Refusing anything else, rather than resolving it, is what keeps a crafted
// request path from reading a file outside wwwroot/.
if (preg_match('/^[A-Za-z0-9._-]+$/', $asset) === 1) {
    $file = __DIR__ . '/wwwroot/' . $asset;
    if (is_file($file)) {
        // Spelled out rather than taken from mime_content_type(), which sniffs
        // content and calls CSS text/plain — and a stylesheet served without
        // text/css is ignored by every browser.
        header('Content-Type: ' . match (pathinfo($asset, PATHINFO_EXTENSION)) {
            'html' => 'text/html; charset=utf-8',
            'css' => 'text/css; charset=utf-8',
            'js' => 'text/javascript; charset=utf-8',
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'ico' => 'image/x-icon',
            default => 'application/octet-stream',
        });
        readfile($file);
        return;
    }
    if ($asset === 'index.html') {
        // The overlay did not ship; say so in the browser rather than as a 404
        // that looks like a bad URL.
        header('Content-Type: text/html; charset=utf-8');
        echo '<h1>demo UI missing</h1>';
        return;
    }
}

// Two passes rather than one: a path can be shared by more than one route
// with a different method each (e.g. /api/mfa/login/email — POST to send an
// OTP, PUT to verify it). Returning 405 on the first path match regardless of
// method would make the second route unreachable whenever it isn't listed
// first, so every same-path route is checked for a method match before any
// of them can produce a 405.
//
// A route path containing a manifest path parameter (e.g.
// /api/customobject/{objectRecordId}) matches by prefix instead of equality —
// this router has no template syntax, only exact/prefix comparison, so
// "/api/customobject/abc123" is matched against the literal text before the
// "{". Confirmed live: without this, PUT/DELETE with a real id in the URL
// matched nothing at all (404), since "{objectRecordId}" never equals a real
// id. The segment after the prefix is read directly by whichever handler
// needs it (see DemoHandlers::resolveRecordId).
$pathMatches = [];
foreach ($routes as $route) {
    $brace = strpos($route->path, '{');
    $matches = $brace === false
        ? $route->path === $path
        : str_starts_with($path, substr($route->path, 0, $brace));
    if (!$matches) {
        continue;
    }
    $pathMatches[] = $route;
    if ($route->method !== $method) {
        continue;
    }
    if ($route->requiresSession && $sessions->lookup(Demo::sessionId()) === null) {
        Demo::writeJson(401, ['error' => 'not signed in']);
        return;
    }
    try {
        ($route->handler)();
    } catch (\Throwable $e) {
        Demo::writeError($e);
    }
    return;
}
if ($pathMatches !== []) {
    header('Allow: ' . implode(', ', array_unique(array_map(fn ($r) => $r->method, $pathMatches))));
    Demo::writeJson(405, ['error' => 'method not allowed']);
    return;
}

Demo::writeJson(404, ['error' => 'not found']);
