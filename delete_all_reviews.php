<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "review_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
	die("接続失敗");
}

$sql = "DELETE FROM reviews";

$conn->query($sql);

header("Location: index.php");
exit();
