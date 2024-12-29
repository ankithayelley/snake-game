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
  <script type="text/javascript">
    function validateForm() {
      const username = document.forms[0].username.value;
      const password = document.forms[0].password.value;
      const confirm_password = document.forms[0].confirm_password.value;
      if (password !== confirm_password) {
        alert("Passwords do not match");
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <div class="gradient-bg">
    <div class="vertical-center">
      <div class="horizontal-center">
        <div class="auth-container">
          <h1>Signup</h1>
          <h2>Get ready for the ✨<em>Snake Game</em>✨</h2>
          <?php if (isset($_GET["error"])) {
            if ($_GET["error"] == "username") {
          ?>
              <p style="color: red">Username is taken</p>
            <?php
            } else if ($_GET["error"] == "invalid") {
            ?>
              <p style="color: red">Something went wrong</p>
          <?php
            }
          }
          ?>
          <form action="action.php" method="POST" onsubmit="return validateForm()" class="auth-form">
            <!-- <label for="username" style="align-self: start;">Username</label> -->
            <input id="username" name="username" placeholder="Username" required>
            <!-- <label for="password" style="align-self: start;">Password</label> -->
            <input id="password" name="password" type="password" placeholder="Password" required>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required>
            <button type="submit">Login</button>
          </form>
          <br />
          <a href="../login">Already have an account?</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>