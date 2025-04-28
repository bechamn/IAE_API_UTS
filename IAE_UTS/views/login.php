<?php
session_start();
include_once '../controllers/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $response = loginUser($email, $password);

    if (isset($response['token'])) {
        $_SESSION['token'] = $response['token'];
        header('Location: items.php'); // redirect to items page after login
        exit;
    } else {
        $errorMessage = $response['message'] ?? 'Login failed.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login</h4>
                </div>
                <div class="card-body">

                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                </div>
                <div class="card-footer text-center">
                    <small>Don't have an account? <a href="register.php">Register</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
