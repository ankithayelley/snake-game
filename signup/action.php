<?php
include('../connection.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo "Invalid Request Method: ", $_SERVER["REQUEST_METHOD"];
} else {
  $qry = "INSERT INTO `users` (`username`, `password`) VALUES(?,?)";
  // $user = $conn->execute_query($qry, [$id])->fetch_assoc();
  $stmt = $con->prepare($qry);
  if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
  }
  $stmt->bind_param("ss", $_POST["username"], $_POST["password"]);
  try {

    if (!($stmt->execute())) {
      echo "Failed to Signup!<br>";
    } else {
      $result = $stmt->insert_id;
      if ($result) {
        $_SESSION['username'] = $_POST["username"];
        $_SESSION["user_id"] = $result;
        header("Location: ../home");
      } else {
        header("Location:./?error=invalid");
      }
    }
  } catch (Exception $e) {
    header("Location:./?error=username");
  }
}
