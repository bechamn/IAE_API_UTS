<?php
include_once '../config.php';

function placeOrder($item_id, $quantity, $token) {
    $data = [
        'item_id' => $item_id,
        'quantity' => $quantity,
    ];

    $ch = curl_init(USER_API_URL . '/order');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function getOrders($token) {
    $ch = curl_init(USER_API_URL . '/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function getAllOrders() {
    $ch = curl_init(USER_API_URL . '/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function confirmOrder($order_id) {
    $ch = curl_init(USER_API_URL . "/orders/{$order_id}/confirm");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>
