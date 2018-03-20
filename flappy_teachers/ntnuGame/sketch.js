let height = 800;
let width = 800;
let bird;
let img1, img2, pipe1, pipe2, background1,background2,background3,background4;
let sound1,sound2;
let pipes = [];
let b;
let gameRun;
let score;
let UItext;
let playMusic;

function setup() {
  // put setup code here
  loadImages();
  let ctx = createCanvas(width,height);
  windowy = (windowHeight - height) / 2;
  windowx = (windowWidth - width) / 2;
  ctx.position(windowx,windowy);
  textAlign(CENTER);
  gameRun = 0;
  score = 0;
  pipes = [];
  frameRate(60);
  b = new Scene();
  bird = new Bird(width, height);
  UItext = new Text();
  playMusic = false;
  // sound1.play();
}

function draw() {
  if(playMusic){
    if(!sound1.isPlaying() && !sound2.isPlaying()){
      sound2.play();
    }
  }

  b.draw();

  bird.draw();

  // game state 1
  if(gameRun === 0){
    score = 0;
    UItext.state1Text();
  }

  // game state 2
  if(gameRun === 1){
    drawPipes();
    bird.move();
    UItext.state2Text();
  }

  // game state 3
  if(gameRun === 2){
    UItext.state3Text();
  }
}

function keyPressed(){
  if(keyCode === 32){
    if(gameRun === 0){
      playMusic = true;
      gameRun = 1;
    }
    bird.up();
  }

  if(keyCode === 83){
    bird.y = height/2;
    pipes = [];
    score = 0;
    gameRun = 1;
  }
}

function drawPipes(){
  for (var i = pipes.length-1; i >= 0; i--) {
    pipes[i].draw();
    pipes[i].move();
    pipes[i].score();

    if (pipes[i].hitsBottom(bird) || pipes[i].hitsTop(bird)) {
      gameRun = 2;
    }


    if (pipes[i].offscreen()) {
      pipes.splice(i, 1);
    }


  }
  if (b.x1Scene1 % 70 === 0) {
    pipes.push(new Pipe());
  }
}

function chooseBackground(){
  let choice = round(random(1,4));
  return ('https://localhost/projects/p5/ntnuGame/backgrounds/back' + choice + '/background_' + choice + '.png');
}

function loadImages(){
  img1 = loadImage('https://localhost/projects/p5/ntnuGame/flappy_teachers/arne2.png','png');
  img2 = loadImage('https://localhost/projects/p5/ntnuGame/flappy_teachers/arne3.png','png');
  pipe1 = loadImage('https://localhost/projects/p5/ntnuGame/ruler/rulerTop.png','png');
  pipe2 = loadImage('https://localhost/projects/p5/ntnuGame/ruler/rulerBottom.png','png');

}

function preload(){
  soundFormats('wav')
  sound1 = loadSound('https://localhost/projects/p5/ntnuGame/music/music1.wav');
  sound2 = loadSound('https://localhost/projects/p5/ntnuGame/music/music2.wav');
}
