<?php
$site_forward = "postfach";

// Überprüfen, ob Benutzer eingeloggt ist
include 'includes/checkLogin.php';

$user = $user_id;
if(isset($g_dlMsg)){
	$sql = "CALL sps_deleteMessages($user, $g_dlMsg);";
	$result = mysql_query($sql);
	header("Location: ".$_SERVER['PHP_SELF'].'?site='.$site);
}

$sql = "CALL sps_getMessages($user);";
$result = mysql_query($sql);
$id_array = array();

$output .= 
'<table width="100%" cellspacing="0" cellpadding="0">
	<tr style="border-top: 1px solid #cccccc; background-color: #f2f2f2;">
		<td align="left">
			<a style="margin: 4px 0 4px 4px" class="boldbuttonsgray" href="'.$_SERVER['PHP_SELF'].'?site=nachrichtErfassen"><span>Nachricht verfassen</span></a>
		</td>
	</tr>
</table>';

$output .= 
'<table cellpadding="0" cellspacing="0" width="100%" height="25px">
	<tr style="border-bottom: 1px solid #e5e5e5;">
		<td><span style="font-size: 11px; color: #777777; font-weight: bold;">Nachrichten:</span></td>
	</tr>
</table>';

if(mysql_num_rows($result) > 0){
	while($row = mysql_fetch_array($result)){
		$idNachricht = $row['idNachricht'];
		$idParent = isset($row['idParent']) ? $row['idParent'] : "";
		$id = !empty($idParent) ? $idParent : $idNachricht;
		
		if(!empty($idParent))
			$id_array[] = $idParent;
			
		if(checkParent($id_array, $idNachricht)){
			if($user == $row['idBenutzerFrom']){
				$user_id = $row['idBenutzerTo'];
				$username = $row['VornameTo']." ".$row['NachnameTo'];
			} else {
				$user_id = $row['idBenutzerFrom'];
				$username = $row['VornameFrom']." ".$row['NachnameFrom'];
			}
			$output .= getMessageDetail($id, $username, $user_id, $row['Datum'], $row['Betreff'], $row['Nachricht'], $row['Gelesen'], $row['Geantwortet']);
		}
	}
} else {
	$output .= "<p>Keine Nachrichten vorhanden</p>";
}


function checkParent($id_array, $idNachricht){
	foreach($id_array as $id){
		if($id == $idNachricht)
			return false;
	}
	return true;
}
?>