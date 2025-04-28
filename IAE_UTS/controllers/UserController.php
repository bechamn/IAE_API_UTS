<?php
include_once '../config.php'; // contains USER_API_URL

function loginUser($email, $password) {
    $ch = curl_init(USER_API_URL . '/login');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'email' => $email,
        'password' => $password
    ]));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return json_decode($response, true);
}

function getAllUsers() {
    $ch = curl_init(ADMIN_API_URL . '/users');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     "Authorization: Bearer $token",
    //     "Accept: application/json"
    // ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>
