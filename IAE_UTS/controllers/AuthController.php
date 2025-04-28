<?php
include_once '../config.php';

function login($email, $password) {
    $data = [
        'email' => $email,
        'password' => $password,
    ];

    $ch = curl_init(USER_API_URL . '/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function register($name, $email, $password) {
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ];

    $ch = curl_init(USER_API_URL . '/register');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>
