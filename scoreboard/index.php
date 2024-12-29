<?php
include('../connection.php');
session_start();
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
        <a href="../home" class="home">Home</a>
        <a href="." class="scoreboard selected">Scoreboard</a>
      </div>
      <form method="POST" action="../logout.php" style="display: flex; align-items: center">
        <span style="margin-right: 20px">Hello, <?php echo $_SESSION["username"]; ?></span>
        <button type="submit" class="logout">Logout</button>
      </form>
    </nav>
    <div class="horizontal-center">
      <div style="display: flex; flex-direction: column;">
        <h1>World Leaderboard</h1>
        <?php
        $qry = "SELECT s.id as id, u.id as user_id, u.username as username, s.score as score FROM scores s LEFT JOIN users u on u.id = s.user_id ORDER BY `score` DESC";
        $result = $con->query($qry);
        ?>
        <div id="table-wrapper">
          <div id="table-scroll">
            <table border='1' class='styled-table'>
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['score']) . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>