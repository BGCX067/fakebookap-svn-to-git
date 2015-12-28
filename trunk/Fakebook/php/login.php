<?php
$page_title = "Login";
$home = "startseite";

$p_email = isset($p_email) ? trim($p_email) : "";
$p_passwort = isset($p_passwort) ? trim($p_passwort) : "";

//Überprüfung, ob schon eine Benutzer eingeloggt ist
if($logged_in){
	if(isset($_GET["forward"]))
		$site = $_GET["forward"];
	else
		$site = $home;
	header("Location: ".$_SERVER['PHP_SELF'].'?site='.$site);
} else {
	if(isset($p_login)){
		if(!empty($p_email) && !empty($p_passwort)){
			if ($p_email != "" && $p_passwort != ""){
				$sql = "CALL sps_checkLogin('$p_email', '".md5($p_passwort)."')";
				$result = mysql_query($sql);
				if(mysql_num_rows($result) == 1){
					while ($row = mysql_fetch_array($result)) {
						$vorname = $row['vorname'];
						$nachname = $row['nachname'];
						$idBenutzer = $row['idBenutzer'];
					}
					$_SESSION["logged_in"] = true;
					$_SESSION["user_vorname"] = $vorname;
					$_SESSION["user_nachname"] = $nachname;
					$_SESSION["user_id"] = $idBenutzer;
					if(isset($_GET["forward"])){
						$site = $_GET["forward"];
					} else {
						$site = $home;
					}
					header("Location: ".$_SERVER['PHP_SELF'].'?site='.$site);
				} else {
					$meld = "Der angegebene Benutzer/Passwort ist ungültig.";
				}
			}
		} else { 
			$meld = "Bitte Benutzername & Passwort eingeben."; 
		}
	}
	
	//Ausgabe der Loginmaske
	$output .= getH2("Login");
	$output .= 
	'<div id="navcontainer">
		<ul id="navlist">
			<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
		</ul>
	</div>
	<div class="editor_panel clearfix">';
	
	if(!empty($meld)) { 	
		$text = "<div id='meldung'><b>Ihre Eingaben enthalten Fehler:</b><br><ul>";
	    $text .= "<li>".$meld."</li>"; 
	    $text .= "</ul></div>";
	    $output .= $text;
	} 
	if(isset($_GET["forward"])){
		$output .= "<form name='login' action='".$_SERVER['PHP_SELF']."?site=".$site."&forward=".$_GET["forward"]."' method='post'>";
	}else{
		$output .= "<form name='login' action='".$_SERVER['PHP_SELF']."?site=".$site."' method='post'>";
	}
	$output .= '<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="left" width="110px">E-Mail Adresse:</td>
				<td><input class="inputtext" name="email" type="text" size="30" value="'.$p_email.'"></td>
			</tr>
			<tr>
				<td class="left">Passwort:</td>
				<td><input class="inputtext" name="passwort" type="password" size="30" ></td>
			</tr>
			<input type="hidden" name="login" value="true" />
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<div style="height: 5px;"></div>
					<div class="buttonwrapper">
						<a class="boldbuttons" href="#" onclick="document.forms[\'login\'].submit(); return;"><span>Einloggen</span></a>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<br/>Sie sind noch nicht registriert? Dann können Sie sich <b><a href="'.$_SERVER['PHP_SELF'].'?site=registrieren">hier</a></b> registrieren.
				</td>
			</tr>
		</table>
	</form>
</div>';
}
?>