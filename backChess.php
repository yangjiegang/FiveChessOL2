<?php
require_once("database.php");
// include_once('./debug/lib/debug.php');
include_once('chess.php');
session_start();
// $chess = $_SESSION["chess"];//share object $chess through session

if(isset($_GET['askBack'])){
    $isBlack = $_GET["isBlack"];
    $_SESSION["chess"]->askBackChess = true;
    mysql_query('update flag set whoBackChess='.$isBlack);
    $callback=$_GET["callback"];
    if ($_SESSION["chess"]->isBlack==false) {//get black last chess position for white to backChess
        $pos = mysql_query("SELECT posX,posY FROM black order by id DESC LIMIT 0,1");
    }else if($_SESSION["chess"]->isBlack==true) {
        $pos = mysql_query("SELECT posX,posY FROM white order by id DESC LIMIT 0,1");
    }
    $_SESSION["chess"]->chessArr[(int)$pos['posX']][(int)$pos['posY']] = 0;
    $row = mysql_fetch_array($pos);
    echo $callback.'('.json_encode($row).')';
}

if (isset($_GET["backChess"]) && $_GET["backChess"]==true) {
    $callback=$_GET["callback"];
    if(isset($_GET["isAllow"]) && $_GET['isAllow']=='1'){
        if ($_SESSION["chess"]->isBlack==true) {//black side allow back->delete black chess
            $pos = mysql_query("SELECT posX,posY FROM black order by id DESC LIMIT 0,1");
            $res = mysql_query("DELETE FROM black ORDER BY id DESC LIMIT 1");
        }else if($_SESSION["chess"]->isBlack==false) {
            $pos = mysql_query("SELECT posX,posY FROM white order by id DESC LIMIT 0,1");
            $res = mysql_query("DELETE FROM white ORDER BY id DESC LIMIT 1");
        }
        // array_splice($chess->chessArr, array_search($pos,$chess->chessArr), 1);
        $_SESSION["chess"]->chessArr[(int)$pos['posX']][(int)$pos['posY']]= 0;
        $row = mysql_fetch_array($pos);
        echo $callback.'('.json_encode($row).')';
        // mysql_query("update flag set whoBackChess=2");//back chess success
    }else{
        echo $callback.'('.json_encode("keep_wait").')';
    }
}

?>