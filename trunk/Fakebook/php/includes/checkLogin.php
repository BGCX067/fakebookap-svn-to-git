<?php
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
	$session_vorname = $_SESSION['vorname'];
	$session_nachname = $_SESSION['nachname'];
} else {
	header("Location: ".$_SERVER['PHP_SELF']."?site=login&forward=$site_forward");
}
?>