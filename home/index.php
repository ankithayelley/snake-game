<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: ../login");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../styles.css" rel="stylesheet" />
  <title>Snek Gaem | Home</title>
  <script src="script.js" defer></script>
</head>

<body>
  <div class="gradient-bg">
    <nav>
      <div style="display: flex;">
        <a href="." class="home selected">Home</a>
        <a href="../scoreboard" class="scoreboard">Scoreboard</a>
      </div>
      <form method="POST" action="../logout.php" style="display: flex; align-items: center">
        <span style="margin-right: 20px">Hello, <?php echo $_SESSION["username"]; ?></span>
        <button type="submit" class="logout">Logout</button>
      </form>
    </nav>
    <div class="vertical-center" style="height: 80vh">
      <div class="horizontal-center">
        <div style="display: flex; flex-direction: column;">
          <h3 style="text-align: center">Score: <span id="score">0</span></h3>
          <canvas id="game" height="400" width="400"></canvas>
          <br />
          <button id="reset-button">Reset</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>