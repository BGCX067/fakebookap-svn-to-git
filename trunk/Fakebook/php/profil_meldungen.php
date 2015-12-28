<?php
if(isset($p_message_id)){
	if(!empty($p_kommentar)){
		mysql_close($connection);
		$connection = getConnection();
		$datum = date("Y-m-d H:i:s");
		$sql = "CALL sps_addKommentar($user_id, '$p_kommentar', '$datum', $p_message_id)";
		mysql_query($sql);
		mysql_query("CALL sps_createMeldung($user_id, '".getMeldungText("Kommentar", $p_message_user)."', '$datum')");
		header("Location: ".$url);
	}
}

mysql_close($connection);
$connection = getConnection();

$sql = "CALL sps_getUserMeldungen($profil_id);";
$result = mysql_query($sql);

if(mysql_num_rows($result) > 0){
	$output .= '<table width="100%" cellspacing="0" cellpadding="0">';
	while($row = mysql_fetch_array($result)){
		$user = $row['Vorname']." ".$row['Nachname'];
		$output .= getMeldung($user, $row['idBenutzer'], $row['Datum'], $row['Meldung'], $row['idMeldung'], $g_tc==$row['idMeldung'], $url);
	}
	$output .= '</table>';
} else {
	$output .= '<p>Keine Meldungen vorhanden</p>';
}
?>