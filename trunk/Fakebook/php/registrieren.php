<?php
$page_title = "Registrierung";

$p_vorname = isset($p_vorname) ? trim($p_vorname) : "";
$p_nachname = isset($p_nachname) ? trim($p_nachname) : "";
$p_email = isset($p_email) ? trim($p_email) : "";
$p_pw_1 = isset($p_pw_1) ? trim($p_pw_1) : "";
$p_pw_2 = isset($p_pw_2) ? trim($p_pw_2) : "";

if(isset($p_registrieren)){
	if (empty($p_email) || strlen($p_email) <= 0) {
		$warning[] = "Bitte E-Mail Adresse eingeben";
	}
	if (empty($p_pw_1) || strlen($p_pw_1) <= 0) {
		$warning[] = "Bitte Passwort eingeben";
	}
	if (empty($p_pw_2) || strlen($p_pw_2) <= 0) {
		$warning[] = "Bitte zweites Passwort eingeben";
	}
	if(!empty($p_pw_1) && !empty($p_pw_2)){
		if($p_pw_2 != $p_pw_1){
	  		$warning[] = "Passwörter sind nicht gleich!";
		}
	}
	if (empty($p_vorname) || strlen($p_vorname) <= 0) {
		$warning[] = "Bitte Vorname eingeben";
	}
	if (empty($p_nachname) || strlen($p_vorname) <= 0) {
		$warning[] = "Bitte Nachname eingeben";
	}
	if(empty($warning)){
		$sql = "CALL sps_registerUser('$p_vorname', '$p_nachname', '$p_email', '".md5($p_pw_2)."')";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1){
			$bestaetigung = "Der Benutzer mit der E-Mail Adresse <b>{$p_email}</b> wurde erfolgreich registriert.<br/><br/>".
			"Sie können sich nun einloggen. Viel Spass";
			$page_title = "Bestätigung";
		} else {
			$bestaetigung = "Der Benutzer mit der E-Mail Adresse <b>{$p_email}</b> existiert bereits!<br/>".
			"<i>Bitte wählen Sie eine andere E-Mail Adresse.</i><br/><br/>".
			"<a href='".$_SERVER['PHP_SELF']."?site=".$site."'>Zurück zur Registrierung</a>";
			$page_title = "Fehler";
		}
	}
}

$output .= getH2("Registrierung");
$output .= 
'<div id="navcontainer">
	<ul id="navlist">
		<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
	</ul>
</div>
<div class="editor_panel clearfix">';
if(empty($warning) && !empty($bestaetigung)){
	$output .= "<div id='meldung'>$bestaetigung</div>";
} else {
	if(!empty($warning)) { 	
		$text = "<div id='meldung'><b>Ihre Eingaben enthalten Fehler:</b><br><ul>";
		foreach($warning as $warn) 
	    $text .= "<li>".$warn."</li>"; 
	    $text .= "</ul></div>";
	    $output .= $text;
	} 
	
	$output .= '<form name="registrierung" action="'.$_SERVER['PHP_SELF'].'?site='.$site.'" method="post">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="left" width="110px">E-Mail Adresse:</td>
				<td><input class="inputtext" name="email" type="text" value="'.$p_email.'" size="30"></td>
			</tr>
			<tr>
				<td class="left">Neues Passwort:</td>
				<td><input class="inputtext" name="pw_1" type="password" value="'.$p_pw_1.'" size="30" /></td>
			</tr>
			<tr>
				<td class="left">Neues Passwort:</td>
				<td><input class="inputtext" name="pw_2" type="password" value="'.$p_pw_2.'" size="30" /></td>
			</tr>
		</table>
		<br />
		<table>
			<tr>
				<td class="left" width="110px">Vorname:</td>
				<td><input class="inputtext" name="vorname" type="text" value="'.$p_vorname.'" size="30" /></td>
			</tr>
			<tr>
				<td class="left">Nachname:</td>
				<td><input class="inputtext" name="nachname" type="text" value="'.$p_nachname.'" size="30" /></td>
			</tr>
			<input type="hidden" name="registrieren" value="true" />
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<div style="height: 5px;"></div>
					<div class="buttonwrapper">
						<a class="boldbuttons" href="#" onclick="document.forms[\'registrierung\'].submit(); return;"><span>Registrieren</span></a>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>';
}
?>