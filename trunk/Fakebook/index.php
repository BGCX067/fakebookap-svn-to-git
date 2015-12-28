<?php
// Benötigte Dateien einbinden
require_once 'includes/html.inc.php';
require_once 'includes/util.inc.php';
require_once 'includes/database.inc.php';

require_once 'functions/util.func.php';
require_once 'functions/thumb.func.php';
require_once 'functions/date.func.php';
require_once 'functions/meldungen.func.php';
require_once 'functions/messages.func.php';
require_once 'functions/database.func.php';

// Session starten
session_start();

// Extrahieren der POST & GET Variablen
extract($_GET, EXTR_PREFIX_ALL, "g");
extract($_POST, EXTR_PREFIX_ALL, "p");

// Allgemein benötigte Variablen deklarieren
$home = "startseite";
$site = isset($g_site) ? $g_site : $home;

// Session Variablen abfüllen
$logged_in = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
$user_vorname = isset($_SESSION['user_vorname']) ? $_SESSION['user_vorname'] : "";
$user_nachname = isset($_SESSION['user_nachname']) ? $_SESSION['user_nachname'] : "";

$title = "Fakebook";
$sidebar = "_without";
if($site == $home){
	$sidebar = "";
}

$output = "";

// Datenbankverbindung aufbauen
$connection = getConnection();

// Anzeigen des HTML-Header
$output .= html_header($title);

// Einbinden der Navigation
include 'php/includes/navigation.php';

// Anzeigen des Content-Bereiches (einbinden der Seite)
$output .= 
'<div id="content" class="content clearfix">
	<div class="container">
		<div id="home_left_column'.$sidebar.'">';
			if(is_file('php/'.$site.'.php')){
				include('php/'.$site.'.php');
			} else {
				include('php/error.php');
			}
		$output .= '</div>';
		if($sidebar != "_without"){
			$output .= '<div id="home_sidebar">';
				include('php/sidebar.php');
			$output .= '</div>';
		}
	$output .= 
	'</div>
</div>';

// Anzeigen des HTML-Footer
$output .= html_footer();

// Datenbank-Connection schliessen
mysql_close($connection);

// Ausgabe des Codes
echo $output;
?>