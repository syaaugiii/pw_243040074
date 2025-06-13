<?php
require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $loginResult = $auth->login($email, $password);
        if ($loginResult) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: pages/homepage.php');
            }
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    } elseif (isset($_POST['register'])) {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if ($auth->register($username, $email, $password)) {
            $success = 'Registration successful! Please login.';
        } else {
            $error = 'Registration failed. Email might already be in use.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 5px 15px #e50914;
            padding: 2rem;
        }

        .brand {
            color: #e50914;
            font-weight: bold;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <div class="brand">MovieFlix</div>

                    <?php if ($error): ?>
                        <div class="alert alert-info"><?= $error ?></div>
                    <?php endif; ?>

                    <ul class="nav nav-tabs" id="authTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="authTabContent">
                        <div class="tab-pane fade show active" id="login">
                            <form method="POST">
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-danger w-100">Login</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="register">
                            <form method="POST">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="register" class="btn btn-success w-100">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>