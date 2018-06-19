window.removeEasteregg = () => {
    // Self-destruct easteregg stuff here, especially timers and stuff
};
var canv = document.createElement('canvas');
canv.id = 'particleCanvas';
document.body.appendChild(canv);

var ctx;
var cW;
var cH;
var raindrops;
var rainStrength = 1;
var img = new Image();
img.src = './build/static/easteregg/minus.png';


function initCanvas() {
    ctx = document.getElementById("particleCanvas").getContext("2d");
    window.addEventListener('resize', resizeCanvas, false);
    resizeCanvas();
}

function resizeCanvas() {
    ctx.canvas.width = window.innerWidth;
    ctx.canvas.height = window.innerHeight;
    cW = ctx.canvas.width;
    cH = ctx.canvas.height;
}

function Raindrops() {
    this.x;
    this.y;
    this.s;
    this.width;
    this.height;
    this.drops = [];
}

Raindrops.prototype.addDrop = function() {
    this.x = (Math.random() * (cW + 100)) - 100;
    this.y = 0;
    this.s = (Math.random() * 7) + 2;

    this.drops.push({
        x: this.x,
        y: this.y,
        velY: 2,
        speed: this.s,
        life: 1
    });
};

Raindrops.prototype.render = function() {
    for (var i = 0; i < rainStrength; i++) {
        this.addDrop();
    };

    ctx.save();

    ctx.clearRect(0, 0, cW, cH);

    // Change color here
    //ctx.fillStyle = 'rgba(255, 0, 0, 1)';

    for (var i = 0; i < this.drops.length; i++) {
        var drop = this.drops[i];
        
        ctx.drawImage(img, drop.x, drop.y, 18, 18);
        drop.y += drop.speed * 2;
        drop.x += 2;
    };
	ctx.restore();
};

function init() {
    raindrops = new Raindrops();
    loop();
}

function render() {
	raindrops.render();
}

function loop() {
    requestAnimationFrame(loop);
    render();
}

initCanvas();
init();