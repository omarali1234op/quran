<?php
header('Content-Type: application/json');

function Ansha($USER_ID) { 
    $mc = ['x-api-key: e758fb28-79be-4d1c-af6b-066633ded128'];
    $dfx = ["telegramId" => (int)$USER_ID];
    $ch = curl_init('https://restore-access.indream.app/regdate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $mc);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dfx));
    $cd = curl_exec($ch);

    if ($cd === false) {
        return ['error' => 'Error: ' . curl_error($ch)];
    }

    $response = json_decode($cd, true);
    curl_close($ch);

    if (isset($response['data']['date'])) {
        return ['date' => $response['data']['date']];
    } else {
        return ['error' => 'Error: Invalid response format'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['USER_ID'])) {
        $result = Ansha($input['USER_ID']);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'USER_ID not provided']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>