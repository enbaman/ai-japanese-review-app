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

$sql = "SELECT * FROM reviews WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$review = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>レビュー編集</title>
</head>

<body>

	<h1>レビュー編集</h1>

	<form action="update_review.php" method="POST">

		<input
			type="hidden"
			name="id"
			value="<?php echo $review['id']; ?>">

		<p>評価</p>

		<input
			type="text"
			name="rating"
			value="<?php echo $review['rating']; ?>">

		<p>コメント</p>

		<textarea
			name="comment"
			rows="5"
			cols="50"><?php echo $review['comment']; ?></textarea>

		<br><br>

		<button type="submit">
			更新
		</button>

	</form>

</body>

</html>