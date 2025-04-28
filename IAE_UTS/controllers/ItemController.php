<?php
include_once '../config.php';

function getItems() {
    $ch = curl_init(ADMIN_API_URL . '/items');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     "Authorization: Bearer $token",
    //     "Accept: application/json"
    // ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// delete item
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    session_start();
    $id = $_GET['id'];
    $ch = curl_init(ADMIN_API_URL . "/items/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$_SESSION['token']}",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    header('Location: ../views/admin.php');
}
?>
