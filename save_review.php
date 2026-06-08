<?php

function analyzeText($text)
{
	$baseScore = 70;

	if (preg_match('/です|ます|。/', $text)) {
		$baseScore += 10;
	}

	if (strlen($text) > 30) {
		$baseScore += 10;
	}

	if (strlen($text) < 10) {
		$baseScore -= 10;
	}

	$baseScore = max(0, min(100, $baseScore));

	$feedbacks = [
		"自然な日本語です。",
		"少しだけ違和感があります。",
		"とても読みやすい文章です。",
		"表現がシンプルで良いです。"
	];

	$feedback = $feedbacks[array_rand($feedbacks)];

	return [
		"choices" => [
			[
				"message" => [
					"content" => json_encode([
						"score" => $baseScore,
						"feedback" => $feedback,
						"corrected" => $text
					], JSON_UNESCAPED_UNICODE)
				]
			]
		]
	];
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "review_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
	die("接続失敗: " . $conn->connect_error);
}

$sentence = $_POST["sentence"] ?? "";
$rating   = $_POST["rating"] ?? "";
$comment  = $_POST["comment"] ?? "";

$aiResult = analyzeText($sentence);

$aiContent = $aiResult["choices"][0]["message"]["content"] ?? "";

$aiJson = json_decode($aiContent, true);

if (!$aiJson) {
	die("JSON解析失敗: " . $aiContent);
}

$ai_score     = $aiJson["score"] ?? 0;
$ai_feedback  = $aiJson["feedback"] ?? "";
$ai_corrected = $aiJson["corrected"] ?? "";

$sql = "INSERT INTO reviews 
(sentence, rating, comment, ai_score, ai_feedback, ai_corrected)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
	die("SQLエラー: " . $conn->error);
}

$stmt->bind_param(
	"sssiss",
	$sentence,
	$rating,
	$comment,
	$ai_score,
	$ai_feedback,
	$ai_corrected
);

$stmt->execute();

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
