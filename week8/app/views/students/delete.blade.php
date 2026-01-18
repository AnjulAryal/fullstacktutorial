<?php
require __DIR__ . "/../../db.php";
$id = $_GET['id'] ?? null;
if(!$id) die("No ID provided.");

$stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>
