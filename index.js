function Chess(){
    this.isBlack = false,
    this.sequence = -1,
    this.isMyturn = true,
    this.chessArr = [],
    this.backCount = 3,
    this.notZero = false,
    this.canvas = document.getElementById("myCanvas"),
    that = this,

    this.Board = function() {
        var canvas = that.canvas; //for test this and that
        if (canvas.getContext) {
            var ctx = canvas.getContext("2d");
            //draw the grid
            var grid_cols = 20;
            var grid_rows = 20;
            var cell_height = canvas.height / grid_rows;
            var cell_width = canvas.width / grid_cols;
            ctx.lineWidth = 1;
            ctx.strokeStyle = "#a0a0a0";
            //结束边框描绘  
            ctx.beginPath();
            //准备画横线  
            for (var col = 0; col <= grid_cols; col++) {
                var x = col * cell_width;
                ctx.moveTo(x, 0);
                ctx.lineTo(x, canvas.height);
            }
            //准备画竖线  
            for (var row = 0; row <= grid_rows; row++) {
                var y = row * cell_height;
                ctx.moveTo(0, y);
                ctx.lineTo(canvas.width, y);
            }
            //完成描绘  
            ctx.stroke();
        }
    },

    this.setPanel = function() {
        // var that = this;
        // var tr = $("#toolPanel>table>tr:nth-of-type(1)");
        var lbClr = $("#infos>td:nth-of-type(1)>label:nth-Child(2)");
        var lbSeq = $("#infos>td:nth-of-type(2)>label:nth-Child(2)");
        var lbTrn = $("#infos>td:nth-of-type(3)>label:nth-Child(2)");
        lbClr.text(that.isBlack? "Black" : "White");
        lbSeq.text(that.sequence === 0 ? "First" : "Last");
        lbTrn.text(that.isMyturn ? "YES" : "NOT");
    },

    this.choiceColor = function() {
        // var that = this;
        $.ajax({
            url: "http://localhost:8001/chessGame_ttalk/start.php?callback=?",
            type: "get",
            dataType: "jsonp",
            crossDomain: true,
            data: {
                "choiceColor": true
            },
            jsonp: "callback",
            success: function(callback) {
                // console.log(callback, typeof(callback));
                if (callback === true) {
                    that.isBlack = true;
                    that.sequence = 0;
                    that.isMyturn = true;
                } else if (callback === false) {
                    that.isBlack = false;
                    that.sequence = 1;
                    that.isMyturn = false;
                } else {
                    console.log("error");
                }
                chess.setPanel();
            },
            error: function() {
                console.log("choiceColor error");
            },
        });
    },

    this.markChess = function() {
        // var that = this;
        // var sndPos=that.sndPos();
        that.canvas.onclick = function(e) {
            if (that.isMyturn === true) {
                e = e ? e : window.event;
                var chessX = Math.round(e.offsetX / 25);
                var chessY = Math.round(e.offsetY / 25);
                that.sndPos(chessX, chessY);
                // var isMark = that.sndPos(chessX, chessY);
                // setTimeout(function(){console.log(that.notZero, isMark);},500) 
                /*                setTimeout(function(){
                                    // console.log(that.notZero, isMark);
                                    if (that.notZero == true) {
                                        that.drawChess(chessX, chessY, that.isBlack);
                                    }
                                    that.isMyturn = false;
                                },300);*/

            }
        };
    }, //markChess()

    this.sndPos = function(pos) {
        // var that = this;
        // var pos = [chessX, chessY];
        var color = that.isBlack === true ? 1 : -1;
        // var isMark = false;
        $.ajax({
            url: "http://localhost:8001/chessGame_ttalk/sndPos.php?callback=?",
            type: "get",
            dataType: "jsonp",
            jsonp: "callback",
            crossDomain: true,
            async: false, //no effect here ????
            data: {
                "clr": color,
                "pos": pos,
                "sndPos": true,
            },
            success: function(isInsert) {
                // console.log(isInsert, typeof(isInsert));
                if(isInsert){
                    that.chessArr.push(pos);
                    // that.drawChess(chessX, chessY, that.isBlack);
                    that.isMyturn = false;
                }else{
                    console.info("insert position failed");
                }
                // var state = parseInt(callback[0]); //xxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // if (state == 2) {
                //     that.chessArr.push(pos);
                //     that.playerWin(callback[1] == "black" ? true : false); 
                // } else if (state === 0) {
                //     console.log("duplicate position while sndPos");
                // } else if (state == 1) {
                //     // if (callback[0] == true) {
                //     // console.log(that.isBlack);
                //     that.chessArr.push(pos);
                //     that.drawChess(chessX, chessY, that.isBlack);
                //     that.isMyturn = false;
                //     // }
                // }
            },
            error: function() {
                console.log("sndPos error");
            },
        });
        // return isMark;
        // setTimeout(function(){ return isMark }, 500);//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    },

   this.getPos = function() {
        // var that = this;
        // console.info(that.isMyturn);
       if (!that.isMyturn) {//isMyturn for client           
            var color = that.isBlack === true ? 1 : -1;
            $.ajax({
                url: "http://localhost:8001/chessGame_ttalk/getPos.php?callback=?",
                type: "get",
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                data: {
                    "color": color,
                    "getPos": true,
                },
                success: function(rival) {
                    console.log(rival);
                    if (rival[0]===0) {//continue Game
                        var chessX = parseInt(rival[1].posX);
                        var chessY = parseInt(rival[1]["posY"]);
                        for(var pos in that.chessArr){
                            if ([chessX, chessY].toString == pos.toString) {
                                console.info("duplicate position getPos");
                                return false;
                            }
                        }
                        that.chessArr.push([chessX, chessY]);
                        var chessColor = that.isBlack === true ? false : true;
                        that.drawChess(chessX, chessY, chessColor);
                        that.isMyturn = true;
                    } else if (rival[0]==1) {//Game over
                        that.playerWin(rival[2] == -1 ? true : false);
                    } else if(rival=="askBackChess"){
                        var isAllow = confirm("Dou you allow backChess ?");
                        if(isAllow){
                            that.backChess("1");
                        }
                    } else {//not isMyturn in server
                        console.log(rival);//duplicate or markChess failed
                    }
                },
                error: function() {
                    console.log("getPos failed");
                },
            });
       }
    },

    this.drawChess = function(chessX, chessY, chessColor) {
        // var that = this;
        var canvas = that.canvas;
        var ctx = canvas.getContext("2d");
        ctx.beginPath();
        ctx.strokeStyle = "grey";
        var circle = {
            x: chessX * 25, //圆心的x轴坐标值
            y: chessY * 25, //圆心的y轴坐标值
            r: 10 //圆的半径
        };
        ctx.arc(circle.x, circle.y, circle.r, 0, Math.PI * 2, false);
        ctx.stroke();
        if (chessColor === false) {
            ctx.fillStyle = "white";
        } else if (chessColor === true) {
            ctx.fillStyle = "black";
        }
        ctx.fill();
    },

    this.delChess = function(pos){

        // if(that.chessArr.includes(pos)){
        //     that.chessArr.splice(that.chessArr.indexOf(pos), 1);
        // }       
        that.chessArr.splice(that.chessArr.indexOf(pos), 1);

        var posX = (parseInt(pos[0])-1)*25;//25
        var posY = (parseInt(pos[1])-1)*25;//50
        var ctx = that.canvas.getContext("2d");
        ctx.clearRect(posX+12,posY+12,25,25);//clear then reline
        ctx.lineWidth=1;
        ctx.strokeStyle = "#a0a0a0";
        ctx.beginPath();
        ctx.moveTo(posX+12,posY+25);
        ctx.lineTo(posX+12+25,posY+25);
        ctx.moveTo(posX+25,posY+12);
        ctx.lineTo(posX+25,posY+12+25);
        ctx.stroke();
    },

    this.askBack = function(){
        if (that.backCount>0 && that.isMyturn===true) {
            that.backCount = that.notZero===false ? that.backCount-1 : that.backCount;
            that.notZero = true;
            var bw = that.isBlack === true ? 1 : 0;
            $.ajax({
                url: "http://localhost:8001/chessGame_ttalk/backChess.php?callback=?",
                type: "get",
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                data: {
                    "askBack":true,
                    "isBlack": bw,
                },
                success: function(data) {
                    // console.log(data);
                    var posX=parseInt(data["posX"]);
                    var posY=parseInt(data["posY"]);
                    var pos=[posX,posY];
                    that.delChess(pos);//delete rival last chess firstly
                    that.isMyturn = false; 
                }
            });
        } else if(that.notZero===true) {
            console.info("not first post");
        } else {
            alert("bad askBack");
            return;
        }
    },

    this.backChess = function(isAllow){
        // var that = this;
        console.log(that.backCount, "this: ",this);
        var bw = that.isBlack === true ? 1 : 0;
        if (that.backCount>0 && that.isMyturn===true) {//get rival last chess            
            $.ajax({
                url: "http://localhost:8001/chessGame_ttalk/backChess.php?callback=?",
                type: "get",
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                data: {
                    "isBlack": bw,
                    "backChess": true,
                },
                success: function(data) {
                    if(data=="keep_wait"){
                        console.log(data);
                    }else{
                        // console.log("backChess: ", data);
                        // that.chessArr.pop();
                        // data=$.parseJSON(data);
                        var posX=parseInt(data["posX"]);
                        var posY=parseInt(data["posY"]);
                        var pos=[posX,posY];
                        that.delChess(pos);
                        backTimer = null;
                        clearInterval(backTimer);
                        that.notZero = false;               
                    }
                }
            });
        } else if(that.notZero===true) {
            console.info("not first post");
        } else if (that.backCount>0 && that.isMyturn===false) {//allow backChess
            $.ajax({
                url: "http://localhost:8001/chessGame_ttalk/backChess.php?callback=?",
                type: "get",
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                data: {
                    "isBlack": bw,
                    "backChess": true,
                    "isAllow":isAllow
                },
                success: function(data) {
                    if(data=="keep_wait"){
                        console.log(data);
                    }else{
                        // console.log("backChess: ", data);
                        // that.chessArr.pop();
                        // data=$.parseJSON(data);
                        var posX=parseInt(data["posX"]);
                        var posY=parseInt(data["posY"]);
                        var pos=[posX,posY];
                        that.delChess(pos);
                        backTimer = null;
                        clearInterval(backTimer);
                        that.notZero = false;
                        that.isMyturn = true;//mark chess again after backChess         
                    }
                }
            });
        } else {
            alert("At most back 3 times!");
            return;
        }
    },

    this.playerWin = function(chessColor) {
        switch (chessColor) {
            case false:
                alert("white chess win!");
                break;
            case true:
                alert("black chess win!");
                break;
            default:
                alert("Game over!");
                break;
        }
        // window.location.reload(); //refresh the borad
    }

}

var chess = new Chess();
var backTimer;//backChess timer
var lastPos=[];//my temp last position
var isPut = false;//put chess or not
// chess.init();
chess.Board();
// chess.Init();
chess.choiceColor();
// setTimeout(chess.setPanel(), 500);
// setTimeout(chess.markChess, 500);
setInterval(chess.getPos, 1000);
document.getElementById("myCanvas").onclick = function(e) {
    console.info(lastPos.length);
    if (chess.isMyturn === true && lastPos.length === 0) {
        e = e ? e : window.event;
        var chessX = Math.round(e.offsetX / 25);
        var chessY = Math.round(e.offsetY / 25);
        chess.drawChess(chessX, chessY, that.isBlack);
        lastPos.push(chessX, chessY);
        // isPut = true;
        // chess.sndPos(chessX, chessY);
    }
};
$("#backBtn").bind("click", function(){
    // setTimeout(chess.askBack, 100);
    chess.askBack();
    backTimer = setInterval(chess.backChess, 1000);
});
$("#okBtn").bind("click", function(){
    if(lastPos.length !== 0){
        chess.sndPos(lastPos);
        lastPos.splice(0, 2);
    }
});
$("#noBtn").bind("click", function(){
    if(lastPos.length !== 0){
        chess.delChess(lastPos);
        lastPos=[];//clear last position
        // lastPos.splice(0, 2);
        isPut = false; 
    }   
});