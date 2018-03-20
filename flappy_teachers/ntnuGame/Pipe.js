function Pipe(){
  this.space = 300;
  this.size = random(50,height/2);
  this.bottom = this.size + this.space;
  this.top = this.size;
  this.x = width;
  this.w = 50;
  this.speed = 4;
  this.scored = false;

  this.hitsBottom = function(bird) {
    if (bird.y + bird.ry > this.bottom) {
      if ( (bird.x + bird.rx > this.x && bird.x + bird.rx < this.x + this.w) || (bird.x > this.x && bird.x < this.x + this.w)) {
        return true;
      }
    }
    return false;
  }

  this.hitsTop = function(bird){
    if (bird.y < this.top) {
      if ( (bird.x + bird.rx > this.x && bird.x + bird.rx < this.x + this.w) || (bird.x > this.x && bird.x < this.x + this.w) ) {
        return true;
      }
    }
    return false;
  }

  this.draw = function(){
    image( pipe2 , this.x , this.bottom , this.w , height-this.bottom);
    image( pipe1 , this.x , 0 , this.w , this.top );
  };

  this.move = function(){
    this.x -= this.speed;
  }

  this.offscreen = function(){
    if(this.x < -this.w){
      return true;
    }
    return false;
  }

  this.score = function(){
    if((this.x < bird.x) && !this.scored){
      score++;
      this.scored = true;
    }
  }


}
