<?php
function getConnection(){
	GLOBAL $db_server, $db_username, $db_password, $db_name;
	$connection = mysql_connect($db_server, $db_username, $db_password, false, 65536) or die ("Fehler 1: ".mysql_error());
	mysql_select_db($db_name, $connection) or die ("Fehler 2: ".mysql_error());
	return $connection;
}
?>