<?php
require_once("database.php");
mysql_query("DELETE FROM white");
mysql_query("DELETE FROM black");
mysql_query("DELETE FROM backChess");
echo "all clear!";
?>