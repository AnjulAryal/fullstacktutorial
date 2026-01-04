<?php
session_start();

if(!isset($_SESSION['logged_in'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if(isset($_POST['theme'])){
    $theme = $_POST['theme'];
    setcookie('theme', $theme, time() + (86400*30));
    $_COOKIE['theme'] = $theme;
}

$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
$bg_color = ($theme == 'dark') ? '#333' : '#fff';
$text_color = ($theme == 'dark') ? '#fff' : '#000';

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" type="text/css" href="dashboard.css">
</head>
<body style="background-color: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>;">

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p class="hello">You are now logged in.</p>

    <h2>Choose Theme:</h2>
    <form method="post">
        <button type="submit" name="theme" value="light">Light Mode</button>
        <button type="submit" name="theme" value="dark">Dark Mode</button>
    </form>

    <form method="post" style="margin-top: 20px;">
        <button type="submit" name="logout">Logout</button>
    </form>

    <p class="last">Made with ❤️ by Anjul Aryal</p>
</div>

</body>
</html>
