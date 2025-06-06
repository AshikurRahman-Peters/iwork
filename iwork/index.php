<?php
session_start();
if (isset($_SESSION['cardnumber'])) {
    header("Location: status.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 0vh !important;
            margin-top: 200px;
        }

        .login-container {
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center the form content */
        }

        .form-group {
            margin: 10px 0;
            width: 100%;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-bottom: 1px solid #ccc;
            background: transparent;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        @media (max-width: 768px) {
            .login-container {
                width: 100%;
            }
        }
        </style>
    </head>

    <body>
        <div class="login-container">
            <h2>Login</h2>
            <?php
        // Display error message if it exists
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red; text-align: center;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // Clear the error message
        }
        ?>
            <form class="login-form" action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" placeholder="Enter your ID">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </body>

</html>