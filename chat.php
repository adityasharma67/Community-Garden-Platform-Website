<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $payload): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function read_json_body(): array
{
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function canned_reply(string $message): string
{
    $m = mb_strtolower($message);
    if (str_contains($m, 'contact')) {
        return "You can join the community from the Contact page (it saves your details to the database). Open: Contact Us → “Join Our Community”.";
    }
    if (str_contains($m, 'login') || str_contains($m, 'sign')) {
        return "You can create an account from the Sign up page, then log in from Login. After login, your name appears in the navbar.";
    }
    if (str_contains($m, 'db') || str_contains($m, 'database')) {
        return "This site uses MySQL/MariaDB. Set DB_HOST, DB_PORT, DB_NAME, DB_USERNAME, DB_PASSWORD as environment variables before running PHP.";
    }
    return "Hi! I can help with Plant‑Hub pages (Home, Gardens, Contact, Login/Sign up). Ask me where to find something or how to set it up.";
}

function call_gemini(string $apiKey, string $model, string $prompt): ?string
{
    $url = sprintf(
        'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
        rawurlencode($model),
        rawurlencode($apiKey)
    );

    $system = getenv('GEMINI_SYSTEM_PROMPT') ?: 'You are a helpful assistant for the Plant-Hub community garden website. Keep answers short and practical.';

    $payload = [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $system . "\n\nUser: " . $prompt],
                ],
            ],
        ],
        'generationConfig' => [
            'temperature' => 0.4,
            'maxOutputTokens' => 250,
        ],
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_TIMEOUT => 15,
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $err) {
        error_log('Gemini request failed: ' . $err);
        return null;
    }

    if ($code < 200 || $code >= 300) {
        error_log('Gemini bad status ' . $code . ': ' . $response);
        return null;
    }

    $json = json_decode($response, true);
    if (!is_array($json)) {
        return null;
    }

    $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
    return is_string($text) && trim($text) !== '' ? trim($text) : null;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['reply' => 'Method not allowed.']);
}

$body = read_json_body();
$message = trim((string) ($body['message'] ?? ''));
if ($message === '') {
    respond(400, ['reply' => 'Message is required.']);
}

$apiKey = getenv('GEMINI_API_KEY') ?: '';
$model = getenv('GEMINI_MODEL') ?: 'gemini-1.5-flash';

if ($apiKey !== '') {
    $reply = call_gemini($apiKey, $model, $message);
    if ($reply !== null) {
        respond(200, ['reply' => $reply]);
    }
}

respond(200, ['reply' => canned_reply($message)]);

