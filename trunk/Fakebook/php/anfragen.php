<?php
$url = $_SERVER['PHP_SELF'].'?site='.$site;

if(isset($g_accF) && !empty($g_accF)){
	$sql = "CALL sps_acceptFriend($user_id, $g_accF)";
	mysql_query($sql);
}
if(isset($g_decF) && !empty($g_decF)){
	$sql = "CALL sps_deleteFriend($user_id, $g_decF)";
	mysql_query($sql);
}
if(isset($g_accG) && !empty($g_accG)){
	$sql = "CALL sps_setUserRightsInGroup($g_accG, $user_id, 0)";
	mysql_query($sql);
}
if(isset($g_decG) && !empty($g_decG)){
	$sql = "CALL sps_deleteUserFromGroup($g_decG, $user_id)";
	mysql_query($sql);
}

mysql_close($connection);
$connection = getConnection();

$output .= getH2("Anfragen");
$output .= 
'<div id="navcontainer">
	<ul id="navlist">
		<li id="active" class="first"><a href="#" id="current">Offene Anfragen</a></li>
	</ul>
</div>
<div class="editor_panel clearfix">';

$sql = "CALL sps_getAnfragen($user_id)";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0){
	while($row = mysql_fetch_array($result)){
		if($row['Typ'] == "f")
			$request_friends[] = $row;
		elseif($row['Typ'] == "g")
			$request_groups[] = $row;
	}
	$output .= '<table width="100%" cellpadding="0" cellspacing="0">';
		if(count($request_friends) > 0){
			$output .=
			'<tr>
				<td colspan="3" class="infounderlined">Freundschaftsanfragen</td>
			</tr>';
			foreach($request_friends as $anfrage){
				$output .= renderFriendOutput($anfrage['idAnfrage'], $anfrage['Name'], 3);
			}
		} if(count($request_groups) > 0) {
			$output .=
			'<tr>
				<td colspan="3" class="infounderlined" '.(count($request_friends) > 0 ? "style=\"padding-top: 20px\"" : "").'">Gruppen-Einladungen</td>
			</tr>';
			foreach($request_groups as $anfrage){
				$output .= renderFriendOutput($anfrage['idAnfrage'], $anfrage['Name'], 3, true);
			}
		}
		$output .= '</table>';
} else {
	$output .= 'Keine offenen Anfragen vorhanden';
}
$output .= '</div>';
?>