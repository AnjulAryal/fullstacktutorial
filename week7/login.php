<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login'])) {
    try {
        $student_id = $_POST['student_id'];
        $password   = $_POST['password'];

        $sql = "SELECT * FROM students WHERE student_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$student_id]);
        $student = $stmt->fetch();

        if ($student) {
            $isPasswordValid  = password_verify($password, $student['password_hash']);
            if($isPasswordValid){
            	session_start();
            	$_SESSION['logged_in'] = true;
            	$_SESSION['username'] = $student['full_name'];
            	header("Location:dashboard.php");
            }else{
            	echo "Invalid Password";
            }
        } else {
            echo "Invalid Student ID";
        }

    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title><style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f6f8;
}

form {
    width: 320px;
    margin: 120px auto;
    padding: 25px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 6px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input:focus {
    outline: none;
    border-color: #007bff;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 15px;
}

button:hover {
    background-color: #0056b3;
}
</style>
	<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f6f8;
}

form {
    width: 320px;
    margin: 120px auto;
    padding: 25px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 6px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input:focus {
    outline: none;
    border-color: #007bff;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 15px;
}

button:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>
<form method="POST">
	    <label>Student ID</label>
	    <input type="text" name="student_id" required>

	    <label>Password</label>
	    <input type="password" name="password" required>

	    <button type="submit" name="login">Login</button>
</form>
</body>
</html>