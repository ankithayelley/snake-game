<?php
include('../../connection.php');
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $data = json_decode(file_get_contents('php://input'), true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
      'status' => 'error',
      'message' => 'Invalid JSON provided',
    ]);
    http_response_code(400);
    exit;
  }
  $user_id = (int)$_SESSION["user_id"];
  $score = isset($data['score']) ? $data['score'] : null;

  if ($user_id && $score !== null) {
    $qry = "INSERT INTO `scores` (`user_id`, `score`) VALUES(?,?)";
    $stmt = $con->prepare($qry);
    if ($stmt === false) {
      die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $int_score = (int)$score;
    $stmt->bind_param("ii", $user_id, $int_score);
    if (!($stmt->execute())) {
      echo json_encode([
        'status' => 'error',
        'message' => 'Something went wrong',
      ]);
      http_response_code(500);
    } else {
      $worldRecordQuery = "SELECT MAX(score) AS max_score FROM `scores`";
      $worldRecordResult = $con->query($worldRecordQuery);
      $worldRecord = $worldRecordResult->fetch_assoc();
      $is_world_record = $int_score > $worldRecord['max_score'];

      $personalRecordQuery = "SELECT MAX(score) AS max_score FROM `scores` WHERE user_id = ?";
      $personalStmt = $con->prepare($personalRecordQuery);
      $personalStmt->bind_param("i", $user_id);
      $personalStmt->execute();
      $personalResult = $personalStmt->get_result();
      $personalRecord = $personalResult->fetch_assoc();
      $is_personal_record = $int_score > $personalRecord['max_score'];
      echo json_encode([
        'user_id' => $user_id,
        'score' => $score,
        'is_world_record' => $is_world_record,
        'is_personal_record' => $is_personal_record,
      ]);
      http_response_code(201);
    }
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Missing user_id or score',
    ]);
    http_response_code(400);  // Bad request
  }
} else {
  $qry = "SELECT s.id as id, u.id as user_id, u.username as username, s.score as score FROM scores s LEFT JOIN users u on u.id = s.user_id ORDER BY `score`";
  $result = $con->query($qry);
  if ($result->num_rows > 0) {
    $scores = [];
    while ($row = $result->fetch_assoc()) {
      $scores[] = $row;
    }
    echo json_encode(
      $scores
    );
    http_response_code(200);
  } else {
    echo json_encode([]);
  }
}
