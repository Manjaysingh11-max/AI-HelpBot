<?php
header("Content-Type: application/json");

require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'];
$userLang = $data['lang'] ?? 'en';

$prompt = "Reply in $userLang: $userMessage";

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . API_KEY,
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model" => "gpt-4o",
    "messages" => [["role" => "user", "content" => $prompt]]
]));

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$botReply = $responseData['choices'][0]['message']['content'] ?? "Sorry, I couldn't process that.";

echo json_encode(["reply" => $botReply]);
?>
