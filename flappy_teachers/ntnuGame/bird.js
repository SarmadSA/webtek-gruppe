function Bird () {
  this.x = 75;
  this.y = 200;
  this.ry = 80;
  this.rx = 100;
  this.yv = 0;
  this.ya = 9.8/60;

  this.draw = function(){
    if(this.yv > 0){
      image(img1,this.x,this.y,this.rx,this.ry);
    } else if(this.yv <= 0){
      image(img2,this.x,this.y,this.rx,this.ry);
    }
  }

  this.move = function(){
    this.yv += this.ya;
    this.y += this.yv;

    if(this.y > height){
      gameRun = 2;
      this.y = height;
      this.yv = 0;
    } else if(this.y < 0){
      this.y = 0;
      this.yv = 0;
    }
  }

  this.up = function(){
    this.yv = -8;
  }

}
