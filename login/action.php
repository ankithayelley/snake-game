<?php
include('../connection.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo "Invalid Request Method: ", $_SERVER["REQUEST_METHOD"];
} else {
  $qry = "SELECT `username`, `id` FROM `users` WHERE `username`=? AND `password`=?";
  // $user = $conn->execute_query($qry, [$id])->fetch_assoc();
  $stmt = $con->prepare($qry);
  if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
  }
  $stmt->bind_param("ss", $_POST["username"], $_POST["password"]);
  if (!($stmt->execute())) {
    echo "Failed to Login!<br>";
  } else {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (isset($user["username"])) {
      $_SESSION['username'] = $user["username"];
      $_SESSION['user_id'] = $user["id"];
      header("Location: ../home");
    } else {
      header("Location:./?error=invalid");
    }
  }
}
