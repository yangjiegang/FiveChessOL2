<?php
require_once("database.php");
// include_once('./debug/lib/debug.php');
include_once('chess.php');
session_start();
// $chess = new Chess();
// $chess = $_SESSION["chess"];

if (!empty($_GET["callback"])) {
	$callback=$_GET["callback"];	
	$pos = $_GET["pos"];
	if ($_GET["clr"]==1) {
		$res = mysql_query("insert into black(posX,posY) values($pos[0],$pos[1])");
	}else if($_GET["clr"]==-1) {
		$res = mysql_query("insert into white(posX,posY) values($pos[0],$pos[1])");
	}
	$_SESSION["chess"]->isMyturn=false;
	// $res = $chess->markChess($pos[0],$pos[1], $chess->isBlack ? false : true);	
	// $whoWin = $chess->whoWin;
	// $res = $chess->isWin($pos[0],$pos[1],$chess->isBlack);
	// if ($whoWin==null) {
	// 	if ($res["isMark"]==true) {
	// 		$back=[1, true];
	// 	} else if ($res["isMark"]==false) {
	// 		$back=[0, false];
	// 	}
	// } else if ($whoWin==1||$whoWin==-1) {
	// 	$back = [2, $whoWin];
	// }

	echo $callback.'('.json_encode($res).')';
	exit();
	// var_dump($back, $_POST['clr']);
}

?>