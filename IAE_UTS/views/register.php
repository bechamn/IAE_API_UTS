<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once '../controllers/AuthController.php';
    $response = register($_POST['name'], $_POST['email'], $_POST['password']);
    if (isset($response['message']) && $response['message'] == 'User registered successfully') {
        header('Location: login.php');
    } else {
        $error = $response['message'] ?? 'Registration failed';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4">
        <h2 class="mb-4">Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input name="name" type="text" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required/>
            </div>
            <button class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Login</a>
        </form>
    </div>
</div>
</body>
</html>
