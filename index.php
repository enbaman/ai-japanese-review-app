<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "review_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
	die("接続失敗");
}

$sql = "SELECT * FROM reviews ORDER BY created_at DESC";

$result = $conn->query($sql);
$statsSql = "
SELECT rating, COUNT(*) as count
FROM reviews
GROUP BY rating
";

$statsResult = $conn->query($statsSql);

$stats = [];

while ($row = $statsResult->fetch_assoc()) {
	$stats[$row["rating"]] = $row["count"];
}
$sentences = [
	"本日は雨がありますので、傘を持ってください。",
	"昨日は映画を見に行きました。",
	"明日は友人と食事をします。",
	"この商品は高品質で人気があります。",
	"駅まで徒歩5分で到着できます。",
	"今日は天気が良いので散歩に行きます。",
	"この本は初心者にもおすすめです。",
	"会議は午後3時から開始されます。"
];

$randomSentence = $sentences[array_rand($sentences)];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AI日本語レビューアプリ</title>

	<link rel="stylesheet" href="style.css">
</head>

<body>
	<form action="save_review.php" method="POST">
		<div class="container">

			<h1>AI日本語レビューアプリ</h1>
			<button type="button" id="theme-toggle">
				🌙 ダークモード
			</button>
			<div class="sentence-box">
				<h2>AI文章</h2>

				<p>
					<?php echo $randomSentence; ?>
				</p>
				<input
					type="hidden"
					name="sentence"
					value="<?php echo $randomSentence; ?>">
			</div>

			<div class="button-group">
				<button type="button" data-rating="自然">自然</button>

				<button type="button" data-rating="少し違和感">
					少し違和感
				</button>

				<button type="button" data-rating="不自然">
					不自然
				</button>
				<input type="hidden" name="rating" id="rating">
			</div>

			<div class="comment-box">
				<textarea name="comment" placeholder="コメントを書いてください"></textarea>
			</div>

			<input type="submit" value="レビューを保存" class="save-button">

		</div>
	</form>
	<h2>統計情報</h2>

	<p>
		自然:
		<?php echo $stats["自然"] ?? 0; ?>件
	</p>

	<p>
		少し違和感:
		<?php echo $stats["少し違和感"] ?? 0; ?>件
	</p>

	<p>
		不自然:
		<?php echo $stats["不自然"] ?? 0; ?>件
	</p>
	<form action="delete_all_reviews.php" method="POST">

		<button
			type="submit"
			onclick="return confirm('本当に全て削除しますか？');">

			全件削除

		</button>

	</form>
	<h2>レビュー一覧</h2>

	<?php while ($row = $result->fetch_assoc()): ?>

		<div class="review-item">

			<p>
				<strong>AI文章:</strong>
				<?php echo $row["sentence"]; ?>
			</p>

			<p>
				<strong>評価:</strong>
				<?php echo $row["rating"]; ?>
			</p>

			<p>
				<strong>コメント:</strong>
				<?php echo $row["comment"]; ?>
			</p>
			<p>
				<strong>AIスコア:</strong>
				<?php echo $row["ai_score"]; ?>
			</p>

			<p>
				<strong>AI評価:</strong>
				<?php echo $row["ai_feedback"]; ?>
			</p>

			<p>
				<strong>改善文:</strong>
				<?php echo $row["ai_corrected"]; ?>
			</p>
			<form action="edit_review.php" method="GET">

				<input
					type="hidden"
					name="id"
					value="<?php echo $row['id']; ?>">

				<button type="submit">
					編集
				</button>

			</form>
			<form action="delete_review.php" method="GET">

				<input
					type="hidden"
					name="id"
					value="<?php echo $row['id']; ?>">

				<button
					type="submit"
					onclick="return confirm('本当に削除しますか？')">
					削除
				</button>

			</form>
			<hr>

		</div>

	<?php endwhile; ?>
	<script src="script.js"></script>

</body>

</html>