<?php
session_start();
if (isset($_SESSION["username"])) {
  header("Location: ../home");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../styles.css" rel="stylesheet" />
  <title>Document</title>
</head>

<body>
  <div class="gradient-bg">
    <div class="vertical-center">
      <div class="horizontal-center">
        <div class="auth-container">
          <h1>Login</h1>
          <h2>Enter the ✨<em>Snake Game</em>✨</h2>
          <?php if (isset($_GET["error"]) && $_GET["error"] == "invalid") {
          ?>
            <p style="color: red">Invalid username or password</p>
          <?php
          }
          ?>
          <form action="action.php" method="POST" class="auth-form">
            <!-- <label for="username" style="align-self: start;">Username</label> -->
            <input id="username" name="username" placeholder="Username">
            <!-- <label for="password" style="align-self: start;">Password</label> -->
            <input id="password" name="password" type="password" placeholder="Password">
            <button type="submit">Login</button>
          </form>
          <br />
          <a href="../signup">Create an account</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>