<?php
$site_forward = 'nachrichten';
$info_text = 'Keine Nachrichten vorhanden';

// Überprüfen, ob Benutzer eingeloggt ist
include 'includes/checkLogin.php';

$betreff_written = false;
$id = isset($g_id) ? $g_id : 0;
$idBenutzerTo = isset($g_idBt) ? $g_idBt : 0;
$url = '?site='.$site.'&id='.$id.'&idBt='.$idBenutzerTo;

$p_antwort = isset($p_antwort) ? trim($p_antwort) : "";
$p_id_user_to = isset($p_id_user_to) ? trim($p_id_user_to) : "";

if($p_delete){
	$sql = "CALL sps_deleteMessages($user_id, $id)";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 1){
		$info_text = "Die Nachrichten wurden erfolgreich gelöscht";
	} else {
		$info_text = "Die Nachrichten konnten nicht gelöscht werden";
	}
}
if(isset($p_antworten)){
	if (empty($p_antwort) || strlen($p_antwort) <= 0) {
		$meld = "Bitte eine Nachricht eingeben";
	} else {
		$datum = date("Y-m-d H:i:s");
		$sql = "CALL sps_createMessageAnswer($user_id, $idBenutzerTo, '$p_antwort', '$datum', $id)";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1){
			header("Location: ".$_SERVER['PHP_SELF'].$url);
		} else {
			$meld = "Die Nachricht konnte nicht gesendet werden";
		}
	}
}

$sql = "CALL sps_getMessagesOfParent($user_id, $id);";
$result = mysql_query($sql);

$output .= '<div style="width: 700px">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr style="border-top: 1px solid #cccccc; background-color: #f2f2f2;">
			<td align="left">
				<a style="margin: 4px 0 4px 4px" class="boldbuttonsgray" href="'.$_SERVER['PHP_SELF'].'?site=postfach"><span>Zurück zu Nachrichten</span></a>';
if(mysql_num_rows($result) > 0){
			$output .= '
				<form name="delete" action="'.$_SERVER['PHP_SELF'].$url.'" method="post">
					<input type="hidden" name="delete" value="true" />
				</form>
				<a style="margin: 4px 0 4px 4px" class="boldbuttonsgray" onclick="document.forms[\'delete\'].submit(); return;" href="#"><span>Löschen</span></a>
			</td>
		</tr>
	</table>';
	while($row = mysql_fetch_array($result)){
		if(!$betreff_written && !empty($row['Betreff']) && $row['Betreff'] != "(kein Betreff)"){
			$output .= '<div class="betreff">'.$row['Betreff'].'</div>';
			$betreff_written = true;
		}
		$idBenutzer = $row['idBenutzer'];
		$username = $row['Vorname']." ".$row['Nachname'];
		$output .= getMessageOfParentDetail($username, $idBenutzer, $row['Datum'], $row['Nachricht']);
	}
	mysql_free_result($result);
	
	$output .= '<div style="height: 10px"></div>';
	
	if(!empty($meld)){
		$output .= "<div id='meldung' style='font-size: 0.8em'>".$meld."</div>";
	}
	$output .= '
	<form name="antworten" action="'.$_SERVER['PHP_SELF'].$url.'" method="post">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" valign="top" width="55px">
					<span style="font-size: 11px; color: #777777; font-weight: bold">Antwort:</span>
				</td>
				<td align="left" valign="top">
					<textarea id="antwort" name="antwort" class="textarea" name="status" style="width: 100%">'.$p_antwort.'</textarea>
				</td>
			</tr>
			<input type="hidden" name="antworten" value="true" />
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<div style="height: 5px;"></div>
					<div class="buttonwrapper">
						<a class="boldbuttons" href="#" onclick="document.forms[\'antworten\'].submit(); return;"><span>Antworten</span></a>
					</div>
				</td>
			</tr>
		</table>
	</form>';
	$output .= '</div>';
} else {
	$output .= '</td></tr></table>';
	$output .= '<div style="height: 5px"></div>';
	$output .= '<span style="font-size: 12px;">'.$info_text.'</span>';
	$output .= '</div>';
}
?>