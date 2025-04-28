<?php
session_start();
include_once '../controllers/ItemController.php';
include_once '../controllers/OrderController.php';

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $quantity = $_POST['quantity'] ?? 1;
    $response = placeOrder($_POST['item_id'], $quantity, $_SESSION['token']);
    if (isset($response['success'])) {
        $successMessage = "Order placed successfully!";
    } else {
        $errorMessage = $response['message'] ?? "Failed to place order.";
    }
}

$items = getItems();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Item Shop</a>
    <div class="d-flex">
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Available Items</h1>

    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($item['description']) ?></p>
                        <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($item['price']) ?> IDR</p>
                        <!-- Order Button trigger modal -->
                        <button type="button" class="btn btn-success mt-auto" data-bs-toggle="modal" data-bs-target="#orderModal<?= $item['id'] ?>">
                            Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Modal -->
            <div class="modal fade" id="orderModal<?= $item['id'] ?>" tabindex="-1" aria-labelledby="orderModalLabel<?= $item['id'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel<?= $item['id'] ?>">Order: <?= htmlspecialchars($item['name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                          <div class="mb-3">
                              <label for="quantity<?= $item['id'] ?>" class="form-label">Quantity</label>
                              <input type="number" class="form-control" id="quantity<?= $item['id'] ?>" name="quantity" value="1" min="1" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm Order</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
