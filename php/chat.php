<?php
// Set your Cohere API Key
$apiKey = "W0wQeCMmAXeMM5OsCZi5zfaF8gfqNpteXLHBd75W"; 

// Get user message
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data["message"] ?? "";

// Basic validation
if (!$userMessage) {
    echo json_encode(["reply" => "Please enter a valid message."]);
    exit;
}

// Call Cohere Generate API
$payload = [
    "model" => "command-r-plus", // You can use free trial models
    "prompt" => $userMessage,
    "max_tokens" => 100,
    "temperature" => 0.7
];

$ch = curl_init("https://api.cohere.ai/v1/generate");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
curl_close($ch);

// Decode API response
$result = json_decode($response, true);
$reply = $result["generations"][0]["text"] ?? "No response from AI.";

// Return JSON reply
echo json_encode(["reply" => trim($reply)]);
?>
