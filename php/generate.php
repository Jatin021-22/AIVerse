<?php
header('Content-Type: application/json');

$api_key = 'sk-0pnljUKPZfH2kh6JDIJCEO9Tnf3I8YhwCHCjWM95zInrzkHD';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $prompt = $data['prompt'] ?? '';

    if (!$prompt) {
        echo json_encode(['success' => false, 'error' => 'Prompt is missing']);
        exit;
    }

    $url = 'https://api.stability.ai/v1/generation/stable-diffusion-512-v2-1/text-to-image';

    $payload = json_encode([
        "text_prompts" => [["text" => $prompt]],
        "cfg_scale" => 7,
        "height" => 512,
        "width" => 512,
        "samples" => 1,
        "steps" => 30
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Bearer $api_key"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['success' => false, 'error' => 'cURL Error: ' . curl_error($ch)]);
        exit;
    }

    $result = json_decode($response, true);
    curl_close($ch);

    if (isset($result['artifacts'][0]['base64'])) {
        $imageData = $result['artifacts'][0]['base64'];
        $imageUrl = 'data:image/png;base64,' . $imageData;
        echo json_encode(['success' => true, 'image' => $imageUrl]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Image generation failed',
            'raw_api_response' => $result
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
