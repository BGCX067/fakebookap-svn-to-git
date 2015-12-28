<?php
$site_forward = "nachrichtErfassen";

// Überprüfen, ob Benutzer eingeloggt ist
include 'includes/checkLogin.php';

$page_title = "Neue Nachricht";

$p_empfaenger = isset($p_friends_list) ? trim($p_friends_list) : "";
$p_betreff = isset($p_betreff) ? trim($p_betreff) : "";
$p_nachricht = isset($p_nachricht) ? trim($p_nachricht) : "";

if($p_send_message){
	if (empty($p_nachricht) || strlen($p_nachricht) <= 0) {
		$warning[] = "Bitte eine Nachricht eingeben";
	}
	if (empty($p_empfaenger)) {
		$warning[] = "Sie müssen einen Empfänger auswählen";
	}
	if(empty($warning)){
		$datum = date("Y-m-d H:i:s");
		$fname = split(", ", $p_empfaenger);
		$p_betreff = empty($p_betreff) ? "(kein Betreff)" : $p_betreff;
		$sql = "CALL sps_createMessage($user_id, ".$_POST[$fname[0]."_".$fname[1]].", '$p_nachricht', '$p_betreff', '$datum')";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1){
			$bestaetigung = "Die Nachricht wurde erfolgreich gesendet.";
			$p_empfaenger = 0;
			$p_betreff = "";
			$p_nachricht = "";
		} else {
			$bestaetigung = "Die Nachricht konnte nicht gesendet worden.<br/><br/>".
			"<i>Es könnte sein, dass Sie sich selber eine Nachricht senden wollten.</i>";
		}
	}
}

//Ausgabe der Maske
$output .= getH2("Erfassen");
$output .= 
'<div id="navcontainer">
	<ul id="navlist">
		<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
	</ul>
</div>
<div class="editor_panel clearfix">';
	if(empty($warning) && !empty($bestaetigung)){
		$output .= "<div id='meldung'>$bestaetigung</div>";
	}
	if(!empty($warning)) { 	
		$text = "<div id='meldung'><b>Ihre Eingaben enthalten Fehler:</b><br><ul>";
		foreach($warning as $warn) 
	    $text .= "<li>".$warn."</li>"; 
	    $text .= "</ul></div>";
	    $output .= $text;
	} 
	$output .= 
	'<form name="nachrichtErfassen" action="'.$_SERVER['PHP_SELF'].'?site='.$site.'" method="post">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="left" width="110px">Empfänger:</td>
				<td>'.getDropDownFriends($user_id, $p_empfaenger, 200).'<input type="hidden" value="1" name="oneone" /></td>
			</tr>
			<tr>
				<td class="left">Betreff:</td>
				<td><input name="betreff" class="inputtext" type="text" size="50" value="'.$p_betreff.'"></td>
			</tr>
			<tr>
				<td class="left">Nachricht:</td>
				<td><textarea class="textarea" name="nachricht" style="width: 100%; height: 80px">'.$p_nachricht.'</textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<input id="send_message" class="inputsubmit" type="submit" value="Nachricht senden" name="send_message"/>
				</td>
			</tr>
		</table>
	</form>
</div>';
//<input name="empfaenger" class="inputtext" type="text" size="50" value="'.$p_empfaenger.'">
?>
