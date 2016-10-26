<?php
require_once("database.php");
// include_once('./debug/lib/debug.php');
include_once('chess.php');
session_start();

/*if (!empty($_POST["choiceColor"])&&$_POST["choiceColor"]==true) {
$query = mysql_query("select mark from flag order by id DESC limit 0,1");
$row = mysql_fetch_array($query);
$flag = $row["mark"];
//var_dump($flag);
if($flag=='b'){
mysql_query("update flag set mark='w' where id=1");
echo ("true");
}else if($flag=='w'){
mysql_query("update flag set mark='b' where id=1");
echo ("false");
}
}*/

$chess = new Chess();
$chess->init();
$_SESSION["chess"] = $chess;
// $GLOBALS["chess"] = $chess;

if (!empty($_GET["callback"])) {
    $callback=$_GET["callback"];
    $query = mysql_query("select mark from flag order by id DESC limit 0,1");
    $row = mysql_fetch_array($query);
    $flag = $row["mark"];
    // echo $callback.'('.json_encode($row).')';
    if($flag=='black'){
        mysql_query("update flag set mark='white' where id=1");
        $_SESSION["chess"]->isBlack=true;
        $_SESSION["chess"]->isMyturn = true;
        echo $callback.'('.'true'.')';
        // exit();
    }else if($flag=='white'){
        mysql_query("update flag set mark='black' where id=1");
        $_SESSION["chess"]->isBlack = false;
        $_SESSION["chess"]->isMyturn = false;
        echo $callback.'('.'false'.')';
    }
    // print_r($chess->isBlack, $_SESSION["chess"]->isBlack);
}

/*if (!empty($_GET["sndPos"])) {
$sndPos=$_GET["sndPos"];
$pos = $sndPos["pos"];
if ($_GET["clr"]==1) {
$back = mysql_query("insert into black(posX,posY) values($pos[0],$pos[1])");
}else if($_GET["clr"]==-1) {
$back = mysql_query("insert into white(posX,posY) values($pos[0],$pos[1])");
}
echo $sndPos.'('.'sndBack'.')';
}

if (!empty($_GET["getPos"])) {
$getPos=$_GET["getPos"];
if ($_POST["color"]==1){
$pos = mysql_query("select id,posX,posY from white order by id DESC limit 0,1");
} else if($_POST["color"]==-1) {
$pos = mysql_query("select id,posX,posY from black order by id DESC limit 0,1");
}
$res = mysql_fetch_array($pos);
echo $getPos.'('.json_encode($res).')';
}*/

/*if (isset($_POST["backChess"])&&$_POST["backChess"]==true) {
//$data = $_POST["data"];
//$No = $data["No"];
$isBlack = $_POST["isBlack"];
if ($isBlack==1) {
$pos = mysql_query("SELECT posX,posY FROM black order by id DESC LIMIT 0,1");
$res=mysql_query("DELETE FROM black ORDER BY id LIMIT 1");
}else if($isBlack==-1) {
$pos = mysql_query("SELECT posX,posY FROM white order by id DESC LIMIT 0,1");
$res=mysql_query("DELETE FROM white ORDER BY id LIMIT 1");
}
$row=mysql_fetch_array($pos);
echo json_encode($row);
//echo $res;
}*/


?>