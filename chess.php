<?php

class Chess{

	public $isBlack=null;//private
	public $sequence= -1;
	public $isMyturn=true;
	public $chessArr=[];
	public $backCount= 3;
	public $whoWin = null;
	// public $askBackChess = false;
	// private $allowBackChess = false;

	function __construct(){
		$this->isBlack=null;
		$this->sequence= -1;
		$this->isMyturn=true;
		$this->chessArr=[];
		$this->backCount= 3;
		$this->whoWin= null;
	}

	public function init() {
		for ($i = 0; $i < 20; $i++) {
			$this->chessArr[$i] = [];
			for ($j = 0; $j < 20; $j++) {
				$this->chessArr[$i][$j] = 0;
			}
		}
/*		$i=20;
		$j=20;
		$this->chessArr=array_fill(0, $i, array_fill(0, $j, array()));*/
	}

	public function markChess($chessX , $chessY, $isBlack){
		$res = array("isMark"=>false,"isWin"=>false, "isMyturn"=>false);
		// var_dump($chessX , $chessY, $this->chessArr[$chessX][$chessY]);
		if ($this->chessArr[$chessX][$chessY] == 0) {//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		
			$flag = $this->isBlack?1:-1;//judge the chess color now
			$this->chessArr[$chessX][$chessY] = $flag;
			// $this->isWin($chessX, $chessY, 1);
			$res["isMark"] = true;
			$res["isWin"] = $this->isWin($chessX, $chessY, $flag);
			$res['isMyturn'] = true;//combine them
			$this->isMyturn == true;
			if ($res["isWin"]) {//is anyone win or not?
				$this->whoWin=$flag;
			}
		} 
		// else if ($this->isBlack == false && $this->chessArr[$chessX][$chessY] == 0) {
		// 	$this->chessArr[$chessX][$chessY] = -1;
		// 	$res["isMark"] = true;
		// 	$res["isWin"] = $this->isWin($chessX, $chessY, -1);
		// 	if ($res["isWin"]==true) {
		// 		$this->whoWin="white";
		// 	}
		// } 
		return $res;
	}

	public function isWin($i, $j, $chessColor) {
        $nums = 1; //连续棋子个数
        $m;
        $n;
        $flag=false;
        //x方向
        for ($m = $j - 1; $m >= 0; $m--) {
        	if ($this->chessArr[$i][$m] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        for ($m = $j + 1; $m < 20; $m++) {
        	if ($this->chessArr[$i][$m] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        if ($nums >= 5) {
        	$flag=true;
        	// playerWin($chessColor);
        	// return true;
        } else {
        	$nums = 1;
        }
        //y方向
        for ($m = $i - 1; $m >= 0; $m--) {
        	if ($this->chessArr[$m][$j] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        for ($m = $i + 1; $m < 20; $m++) {
        	if ($this->chessArr[$m][$j] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        if ($nums >= 5) {
        	$flag=true;
        	// playerWin($chessColor);
        	// return true;
        } else {
        	$nums = 1;
        }
        //左斜方向
        for ($m = $i - 1, $n = $j - 1; $m >= 0 && $n >= 0; $m--, $n--) {
        	if ($this->chessArr[$m][$n] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        for ($m = $i + 1, $n = $j + 1; $m < 20 && $n < 20; $m++, $n++) {
        	if ($this->chessArr[$m][$n] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        if ($nums >= 5) {
        	$flag=true;
        	// playerWin($chessColor);
        	// return true;
        } else {
        	$nums = 1;
        }
        //右斜方向
        for ($m = $i - 1, $n = $j + 1; $m >= 0 && $n < 20; $m--, $n++) {
        	if ($this->chessArr[$m][$n] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        for ($m = $i + 1, $n = $j - 1; $m < 20 && $n >= 0; $m++, $n--) {
        	if ($this->chessArr[$m][$n] === $chessColor) {
        		$nums++;
        	} else {
        		break;
        	}
        }
        if ($nums >= 5) {
        	$flag=true;
        	// playerWin($chessColor);
        	// return true;
        }
        return $flag;
    }

}

?>