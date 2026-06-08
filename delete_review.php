<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "review_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
	die("接続失敗");
}

$id = $_GET["id"];

$sql = "DELETE FROM reviews WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.php");
exit();
