function Scene(){
  this.choice = round(random(1,4));
  this.layers = [];
  this.images = [];
  this.speed = 0.5;
  this.x1Scene1 = 0;
  this.xLength = width;
  this.x1Scene2 = width;
  this.choose = function(){
    switch(this.choice){
      case 1:
        this.layers.push('/layer01_ground.png');
        this.layers.push('/layer02_cake.png');
        this.layers.push('/layer03_trees.png');
        this.layers.push('/layer04_clouds.png');
        this.layers.push('/layer05_rocks.png');
        this.layers.push('/layer06_sky.png');
        break;

      case 2:
        this.layers.push('/Layer01_Clouds_1.png');
        this.layers.push('/layer02_Clouds_2.png');
        this.layers.push('/layer03_Clouds_3.png');
        this.layers.push('/layer04_Path.png');
        this.layers.push('/layer05_Castle.png');
        this.layers.push('/layer06_Stars_3.png');
        this.layers.push('/layer07_Stars_2.png');
        this.layers.push('/layer08_Stars_1.png');
        this.layers.push('/layer09_Sky.png');
        break;

      case 3:
        this.layers.push('/layer01_Ground.png');
        this.layers.push('/layer02_Trees.png');
        this.layers.push('/layer03_Hills_1.png');
        this.layers.push('/layer04_Hills_2.png');
        this.layers.push('/layer05_Clouds.png');
        this.layers.push('/layer06_Rocks.png');
        this.layers.push('/layer07_Sky.png');
        break;

      case 4:
        this.layers.push('/layer01_Ground.png');
        this.layers.push('/layer02_Trees_rocks.png');
        this.layers.push('/layer03_Hills_Castle.png');
        this.layers.push('/layer04_Clouds.png');
        this.layers.push('/layer05_Hills.png');
        this.layers.push('/layer06_Rocks.png');
        this.layers.push('/layer07_Sky.png');
         break;
    }

  }

  this.choose();

  this.loadBackgroundImages = function(){
    for(let i = this.layers.length - 1; i >= 0; i--){
      this.images.push(loadImage('https://localhost/projects/p5/ntnuGame/back' + this.choice + this.layers[i],'png'))
    }
  }

  this.loadBackgroundImages();

  this.draw = function(){
    this.x1Scene1 -= this.speed;
    this.x1Scene2 -= this.speed;

    for(let i = 0; i < this.images.length; i++){
      if(this.x1Scene1 <= -width){
        this.x1Scene1 = width;
      } else if( this.x1Scene2 <= -width){
        this.x1Scene2 = width;
      }
      image(this.images[i],this.x1Scene1,0,this.xLength,height);
      image(this.images[i], this.x1Scene2, 0, this.xLength, height);
    }
  }
}
