<?php
unset($_SESSION["logged_in"]);
unset($_SESSION["user_vorname"]);
unset($_SESSION["user_nachname"]);
unset($_SESSION["user_id"]);
header("Location: ".$_SERVER['PHP_SELF']);
?>