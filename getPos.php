<?php
require_once("database.php");
// include_once('./debug/lib/debug.php');
include_once('chess.php');
session_start();
// $chess = $_SESSION["chess"];//share object $chess through session

if (!empty($_GET["callback"])) {
	$callback=$_GET["callback"];

	// for ($i = 0; $i < 20; $i++) {
	// 	for ($j = 0; $j < 20; $j++) {
	// 		if($chess->chessArr[$i][$j] != 0){
	// 			var_dump($i, $j, $chess->chessArr[$i][$j]);
	// 		}
	// 	}
	// }
	$src = mysql_query('select whoBackChess from flag');
	$row = mysql_fetch_array($src);
	// var_dump($row);
	$tmp = $_SESSION["chess"]->isBlack ? 1 : 0;
	if( intval($row[0]) != -1 && $tmp != intval($row[0]) ){
		mysql_query("update flag set whoBackChess=".-1);
		// $back = 'askBackChess';
		echo $callback.'('.json_encode('askBackChess').')';
		return;
	}

	if ($_GET["color"]==1){
		$pos = mysql_query("select id,posX,posY from white order by id DESC limit 0,1");
	} else if($_GET["color"]==-1) {
		$pos = mysql_query("select id,posX,posY from black order by id DESC limit 0,1");
	}
	$res = mysql_fetch_array($pos);
	// var_dump($res);
	if($res){
		$markRes = $_SESSION["chess"]->markChess((int)$res['posX'], intval($res['posY']), $_SESSION["chess"]->isBlack ? false : true);//$res = array("isMark"=>false,"isWin"=>false, "isMyturn"=>false);
		// $whoWin = $chess->whoWin;
		$back='duplicate position while mark chess';
		// var_dump($res, $chess->chessArr[19][1]);
		// var_dump($markRes);
		if($markRes['isMark']){
			if ($markRes['isMyturn']) {
				if(!$markRes['isWin']){
					$back = [0, $res, $_SESSION["chess"]->whoWin];//continue the game
				}elseif ($markRes['isWin']) {
					$back = [1, $res, $_SESSION["chess"]->whoWin];//game over
				}else {

				}
			}
		}
		echo $callback.'('.json_encode($back).')';

		exit();
	}

}
?>