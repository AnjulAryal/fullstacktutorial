<?php
	require_once "db.php";
	if($_SERVER['REQUEST_METHOD']==="POST"&& isset($_POST['add_student'])){
		$student_id = $_POST['student_id'];
		$name= $_POST['name'];
		$password = $_POST['password'];

		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$sql  =  "INSERT INTO students(student_id,full_name,password_hash)
			Values(?,?,?)";
		try{
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$student_id,$name,$hashedPassword]);
			echo "SucessFully Added";
			header("Location: login.php");
		}catch(PDOException $e){
			die("Unable to Connect the Database".$e->getMessage());
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Registration Form</title>
	<link rel="stylesheet" type="text/css" href="./register.css">
</head>
<style>
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}
	h1{
		text-align: center;
		padding-top: 4rem;
	}
form {
    width: 320px;
    margin: 100px auto;
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 6px;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
<body>
	<h1>Student Registration Form</h1>
	<form method="POST">
		<label>Student Id</label>
		<input type="text" name="student_id">
		<br>
		<label>Name:</label>
		<input type="text" name="name">
		<br>
		<label>Password</label>
		<input type="password" name="password">
		<br>
		<button type="Submit" name="add_student">Submit</button>
	</form>
</body>
</html>