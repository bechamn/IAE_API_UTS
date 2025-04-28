<?php
session_start();
include_once '../controllers/ItemController.php';
include_once '../controllers/OrderController.php';
include_once '../controllers/UserController.php';
include_once '../config.php';

// Check if logged in
if (!isset($_SESSION['token'])) {
    header('Location: ../views/login.php');
    exit;
}

if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Order '.htmlspecialchars($_GET['order_id']).' confirmed successfully!</div>';
} elseif (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">Failed to confirm order '.htmlspecialchars($_GET['order_id']).'</div>';
}

// Fetch data
$items = getItems();
$orders = getAllOrders();
$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <div class="d-flex justify-content-between mb-4">
        <a href="create_item.php" class="btn btn-success">Add New Item</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <h2>Items</h2>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
                <td>
                    <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Orders</h2>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th><th>Status</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['status']) ?></td>
                <td>
                <?php if ($order['status'] == 'pending'): ?>
                    <form method="POST" action="<?= USER_API_URL ?>/orders/<?= $order['id'] ?>/confirm" style="display: inline;">
                    <input type="hidden" name="_method" value="PUT">
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')">Confirm</button>
                    </form>
                    <?php
                        // Immediately after the form - handle the response
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
                            $orderId = $order['id'];
                            $response = file_get_contents("http://127.0.0.1:8002/api/orders/$orderId/confirm", false, stream_context_create([
                                'http' => [
                                    'method' => 'PUT',
                                    'header' => "Content-type: application/json\r\n",
                                    'content' => json_encode(['_method' => 'PUT'])
                                ]
                            ]));
                            
                            $result = json_decode($response, true);
                            
                            if ($result && !isset($result['error'])) {
                                header("Location: admin.php?success=1&order_id=$orderId");
                            } else {
                                header("Location: admin.php?error=1&order_id=$orderId");
                            }
                            exit();
                        }
                    ?>
                <?php else: ?>
                    <span class="badge bg-success">Confirmed</span>
                <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Users</h2>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
    function confirmOrder(orderId) {
        console.log("Confirming order with ID:", orderId);  // For debugging

        var formData = new FormData();
        formData.append('order_id', orderId);

        // Send the PUT request using fetch
        fetch('../controllers/OrderController.php', {
            method: 'PUT',  // Change the method to PUT
            body: formData,
            headers: {
                'Content-Type': 'application/json',  // Optional, in case the API expects JSON
            }
        })
        .then(response => response.json())  // Parse the JSON response from the server
        .then(data => {
            if (data.status === true) {
                alert("Order confirmed successfully!");
                location.reload();  // Optionally reload the page to show updated status
            } else {
                alert("Failed to confirm order.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while confirming the order." + error.message);
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
