<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $toZip = $input['zip'] ?? '';

    if (!$toZip) {
        echo json_encode(["error" => "ZIP code not provided."]);
        exit;
    }

    $apiKey = "ECuNjCIe4QAgFXuRyvxV8zj6Db03QHoB0LWOTSq4"; // Replace with your actual API key
    $url = "https://api.api-ninjas.com/v1/salestax?zip_code=$toZip";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Api-Key: ' . $apiKey]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    // ✅ Correctly access the total_rate inside the first array element
    if (isset($data[0]['total_rate'])) {
        echo json_encode(["total_rate" => $data[0]['total_rate']]);
    } else {
        echo json_encode(["error" => "No tax rate found."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
