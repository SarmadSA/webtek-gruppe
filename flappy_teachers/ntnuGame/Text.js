function Text(){
  this.state1Text = function(){
    textSize(32);
    text("Press 'space' to play", width/2 , height/3);
    fill(255, 255, 255, 255);
  }

  this.state2Text = function(){
    textSize(32);
    text(score.toString(), width/2 , height/3);
    fill(255, 255, 255, 255);
  }

  this.state3Text = function(){
    textSize(32);
    text("Your score was: " + score.toString() + "!", width/2, height/3 - 50);
    text("Press 's' to play again!", width/2, (height/3) + 50);
    fill(255, 255, 255, 255);
  }
}
