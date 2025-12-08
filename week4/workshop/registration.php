<?php
// Variables
$name = $email = "";
$nameErr = $emailErr = $passErr = $confirmErr = "";
$successMsg = $fileErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // 2. Validation
    if (empty($name)) {
        $nameErr = "Name is required";
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if (empty($password)) {
        $passErr = "Password is required";
    } elseif (strlen($password) < 6) {
        $passErr = "Password must be at least 6 characters";
    } elseif (!preg_match("/[@#$%^&*()\-_=+{};:,<.>]/", $password)) {
        $passErr = "Password must include a special character";
    }

    if (empty($confirm_password)) {
        $confirmErr = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $confirmErr = "Passwords do not match";
    }

    // If no validation errors
    if (empty($nameErr) && empty($emailErr) && empty($passErr) && empty($confirmErr)) {

        $file = "users.json";

        // 4. Read JSON file
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $json_data = file_get_contents($file);

        if ($json_data === false) {
            $fileErr = "Error reading users.json file.";
        } else {
            $users = json_decode($json_data, true);
            if (!is_array($users)) {
                $users = [];
            }

            // 5. Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create user array
            $new_user = [
                "name" => $name,
                "email" => $email,
                "password" => $hashed_password
            ];

            // 6. Add to existing users
            $users[] = $new_user;

            // 7. Write back to JSON
            if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT))) {
                // 8. Success Message
                $successMsg = "Registration successful!";
                // Clear fields
                $name = $email = "";
            } else {
                // 9. Error handling
                $fileErr = "Error writing to users.json file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container {
            width: 350px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .error { color: red; font-size: 14px; }
        .success { color: green; font-size: 16px; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <?php if(!empty($successMsg)) : ?>
        <div class="success"><?= $successMsg ?></div>
    <?php endif; ?>

    <?php if(!empty($fileErr)) : ?>
        <div class="error"><?= $fileErr ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <div class="error"><?= $nameErr ?></div>

        <label>Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
        <div class="error"><?= $emailErr ?></div>

        <label>Password:</label>
        <input type="password" name="password">
        <div class="error"><?= $passErr ?></div>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password">
        <div class="error"><?= $confirmErr ?></div>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
