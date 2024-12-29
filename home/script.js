/**
 * @returns {HTMLCanvasElement}
 */
function getCanvas() {
  return document.getElementById("game");
}
const canvas = getCanvas();
const ctx = canvas.getContext("2d");
// draw on the screen to get the context, ask canvas  to get the 2d context

const scoreEl = document.getElementById("score");
const resetButton = document.getElementById("reset-button");

// snake axis
class SnakePart {
  constructor(x, y) {
    this.x = x;
    this.y = y;
  }
}
// size and count of a tile
const tileCount = 20;
const tileSize = canvas.width / tileCount - 2;
let speed,
  headX,
  snakeParts,
  headY,
  tailLength,
  appleX,
  appleY,
  inputsXVelocity,
  inputsYVelocity,
  xVelocity,
  yVelocity,
  score;

function init() {
  // speed of the game
  speed = 7;
  // head of the snake
  headX = 10;
  headY = 10;
  snakeParts = [];
  tailLength = 2;
  // apple size
  appleX = 5;
  appleY = 5;
  // movement
  inputsXVelocity = 0;
  inputsYVelocity = 0;

  xVelocity = 0;
  yVelocity = 0;

  score = 0;
}

init();

let gulpSound = new Audio("gulp.mp3");

let appleColor = "red";
let backgroundColor = "#402202";
let snakeColor = "#3f87a6";
let snakeHeadColor = "#f69c3c";

resetButton.addEventListener("click", (e) => {
  init();
  drawGame();
});

//game loop
function drawGame() {
  xVelocity = inputsXVelocity;
  yVelocity = inputsYVelocity;

  changeSnakePosition();
  let result = isGameOver();
  if (result) {
    return true;
  }

  clearScreen();

  checkAppleCollision();
  drawApple();
  drawSnake();

  drawScore();

  if (score > 5) {
    speed = 9;
  }
  if (score > 10) {
    speed = 11;
  }

  setTimeout(drawGame, 1000 / speed);
}

function isGameOver() {
  let gameOver = false;

  if (yVelocity === 0 && xVelocity === 0) {
    return false;
  }

  //walls
  if (headX < 0) {
    gameOver = true;
  } else if (headX === tileCount) {
    gameOver = true;
  } else if (headY < 0) {
    gameOver = true;
  } else if (headY === tileCount) {
    gameOver = true;
  }

  for (let i = 0; i < snakeParts.length; i++) {
    let part = snakeParts[i];
    if (part.x === headX && part.y === headY) {
      gameOver = true;
      break;
    }
  }

  if (gameOver) {
    ctx.fillStyle = "white";
    ctx.font = "50px Verdana";

    var gradient = ctx.createLinearGradient(0, 0, canvas.width, 0);
    gradient.addColorStop("0", " magenta");
    gradient.addColorStop("0.5", "blue");
    gradient.addColorStop("1.0", "red");
    ctx.fillStyle = gradient;

    ctx.fillText("Game Over!", canvas.width / 6.5, canvas.height / 2);
    if (score > 0) {
      postScore();
    }
  }

  return gameOver;
}

function drawScore() {
  // ctx.fillStyle = "white";
  // ctx.font = "10px Verdana";
  // ctx.fillText("Score " + score, canvas.width - 50, 10);
  scoreEl.textContent = score;
}

function clearScreen() {
  ctx.fillStyle = backgroundColor;
  ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function getHeadRoundedness(r = 8) {
  if ((xVelocity === 0 && yVelocity === 0) || yVelocity === -1) {
    return [r, r, 0, 0];
  }
  if (xVelocity === 1) {
    return [0, r, r, 0];
  }
  if (xVelocity === -1) {
    return [r, 0, 0, r];
  }
  if (yVelocity === 1) {
    return [0, 0, r, r];
  }
}

function drawSnake() {
  ctx.fillStyle = snakeColor;
  for (let i = 0; i < snakeParts.length; i++) {
    let part = snakeParts[i];
    ctx.fillRect(part.x * tileCount, part.y * tileCount, tileSize, tileSize);
  }

  snakeParts.push(new SnakePart(headX, headY)); //put an item at the end of the list next to the head
  while (snakeParts.length > tailLength) {
    snakeParts.shift(); // remove the furthet item from the snake parts if have more than our tail size.
  }
  ctx.strokeStyle = snakeHeadColor;
  ctx.fillStyle = snakeHeadColor;
  ctx.beginPath();

  ctx.roundRect(
    headX * tileCount,
    headY * tileCount,
    tileSize,
    tileSize,
    getHeadRoundedness()
  );
  ctx.fill();
  ctx.stroke();
}

function changeSnakePosition() {
  headX = headX + xVelocity;
  headY = headY + yVelocity;
}

function drawApple() {
  ctx.strokeStyle = appleColor;
  ctx.fillStyle = appleColor;
  ctx.beginPath();
  ctx.roundRect(appleX * tileCount, appleY * tileCount, tileSize, tileSize, 8);
  ctx.fill();
  ctx.stroke();
}

function checkAppleCollision() {
  if (appleX === headX && appleY == headY) {
    appleX = Math.floor(Math.random() * tileCount);
    appleY = Math.floor(Math.random() * tileCount);
    tailLength++;
    score++;
    gulpSound.play();
  }
}

document.body.addEventListener("keydown", keyDown);

function keyDown(event) {
  //up
  if (event.keyCode == 38 || event.keyCode == 87) {
    //87 is w
    if (inputsYVelocity == 1) return;
    inputsYVelocity = -1;
    inputsXVelocity = 0;
  }

  //down
  if (event.keyCode == 40 || event.keyCode == 83) {
    // 83 is s
    if (inputsYVelocity == -1) return;
    inputsYVelocity = 1;
    inputsXVelocity = 0;
  }

  //left
  if (event.keyCode == 37 || event.keyCode == 65) {
    // 65 is a
    if (inputsXVelocity == 1) return;
    inputsYVelocity = 0;
    inputsXVelocity = -1;
  }

  //right
  if (event.keyCode == 39 || event.keyCode == 68) {
    //68 is d
    if (inputsXVelocity == -1) return;
    inputsYVelocity = 0;
    inputsXVelocity = 1;
  }
}

function postScore() {
  fetch("http://localhost/snake-game/api/score/", {
    method: "POST",
    body: JSON.stringify({
      score,
    }),
  })
    .then((res) => res.json())
    .then((res) => res.score)
    .then((score) => alert(`Score posted: ${score}`));
}

drawGame();
