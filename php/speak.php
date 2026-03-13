<?php
// speak.php
header("Content-Type: audio/mpeg");

$data = json_decode(file_get_contents("php://input"), true);
$text = trim($data['text'] ?? '');

if (!$text) {
    http_response_code(400);
    echo "Text is required.";
    exit;
}
// old API key :- sk_d30455253a77118d764b6df8c21478db0d00f3c4a31e23a6
// second old :- sk_f35446ac1bb6464a6213a5869d7960d24227b94123c69261

$api_key = 'sk_61953fe40203c4d51eae21d0488f82bf05e751676c527e9e';

// Voice ID (get from https://elevenlabs.io)
$voice_id = 'XcWoPxj7pwnIgM3dQnWv'; // Replace with your preferred voice

$payload = json_encode([
    "text" => $text,
    "model_id" => "eleven_monolingual_v1",
    "voice_settings" => [
        "stability" => 0.5,
        "similarity_boost" => 0.75
    ]
]);

$ch = curl_init("https://api.elevenlabs.io/v1/text-to-speech/$voice_id");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "xi-api-key: $api_key"
    ]
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode === 200) {
    echo $response;
} else {
    http_response_code(500);
    echo "Voice generation failed.";
}
?>
