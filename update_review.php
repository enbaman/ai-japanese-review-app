<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "review_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
	die("接続失敗");
}

$id = $_POST["id"];
$rating = $_POST["rating"];
$comment = $_POST["comment"];

$sql = "UPDATE reviews
        SET rating = ?, comment = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
	"ssi",
	$rating,
	$comment,
	$id
);

$stmt->execute();

header("Location: index.php");
exit();
