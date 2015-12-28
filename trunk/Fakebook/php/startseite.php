<?php
$site_forward = "startseite";
$page_title = "Neuigkeiten";

$p_user_status = isset($p_user_status) ? trim($p_user_status) : "";

// Überprüfen, ob Benutzer eingeloggt ist
include 'includes/checkLogin.php';

if(isset($p_message_id)){
	if(!empty($p_kommentar)){
		$datum = date("Y-m-d H:i:s");
		$sql = "CALL sps_addKommentar($user_id, '$p_kommentar', '$datum', $p_message_id)";
		mysql_query($sql);
		mysql_query("CALL sps_createMeldung($user_id, '".getMeldungText("Kommentar", $p_message_user)."', '$datum')");
		header("Location: ".$_SERVER['PHP_SELF']."?site=$site");
	}
}
if(isset($p_status_hidden) && !empty($p_user_status)){
	$datum = date("Y-m-d H:i:s");
	$sql = "CALL sps_createMeldung($user_id, '$p_user_status', '$datum')";
	$result = mysql_query($sql);
	$p_user_status = "";
}

$output .= getH2("Startseite");

$output .=
'<form name="status_form" action="'.$_SERVER['PHP_SELF'].'" method="post">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan=2 style="padding: 0; padding-bottom: 10px">
				<div class="editor_panel clearfix" style="border-top: 1px solid #D7D7D7; padding-bottom: 3px">
					<table>
						<tr>
							<td colspan="2" style="padding-bottom: 6px">
								<span style="font-size: 13px; color: #777777; font-weight: bold">Was machst du gerade?</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<input name="user_status" type="text" value="'.$p_user_status.'" class="inputtext" style="width: 534px; margin-top: 1px" />
								<input type="hidden" name="status_hidden" value="true" />
							</td>
							<td>
								<a class="boldbuttons" href="#" onclick="document.forms[\'status_form\'].submit(); return;"><span>Veröffentlichen</span></a>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</form>';

$sql = "CALL sps_getFriendsMeldungen($user_id);";
$result = mysql_query($sql);

if(mysql_num_rows($result) > 0){
	$output .= '<table width="100%" cellspacing="0" cellpadding="0">';
	while($row = mysql_fetch_array($result)){
		$user = $row['Vorname']." ".$row['Nachname'];
		$url = $_SERVER['PHP_SELF']."?site=".$site;
		$output .= getMeldung($user, $row['idBenutzer'], $row['Datum'], $row['Meldung'], $row['idMeldung'], $g_tc==$row['idMeldung'], $url);
	}
	$output .= '</table>';
} else {
	$output .= '<p>Keine Meldungen vorhanden</p>';
}
?>