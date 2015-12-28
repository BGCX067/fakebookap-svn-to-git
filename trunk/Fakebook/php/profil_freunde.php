<?php
mysql_close($connection);
$connection = getConnection();

if($profil_id == $user_id){
	$sql = "CALL sps_getOwnFriends($user_id);";
	$result = mysql_query($sql);
	$array_friends = array();
	$array_friends_open = array();
	while($row = mysql_fetch_array($result)){
		if($row['status'] == 1){ 
			$row['isFriend'] = 1;
			$array_friends[] = $row;
		} else $array_friends_open[] = $row;
	}
	$members = sortArray($array_friends_open, "Nachname");
} else {
	$sql = "CALL sps_getFriends($profil_id, $user_id);";
	
	$array_friends = array();
	$array_friends_open = array();
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$array_friends[] = $row;
	}
}

$members = sortArray($array_friends, "Nachname");

$output .= '<table width="100%" cellpadding="0" cellspacing="0">';

if($profil_id == $user_id){
	$output .= 
	'<tr>
		<td colspan="3" class="infounderlined">Offene Freundschaftsanfragen</td>
	</tr>';
	if(empty($array_friends_open))
		$output .= '<tr><td colspan="3">Keine offenen Freundschaftsanfragen vorhanden</td></tr>';
	foreach($array_friends_open as $friend){
		$output .= renderFriendOutput($friend['idFriend'], $friend['Vorname']." ".$friend['Nachname'], ($friend['status'] == 0 ? 1 : $friend['status']));
	}
	$style = 'style="padding-top: 20px"';
}

	$output .=
	'<tr>
		<td colspan="3" class="infounderlined" '.(!empty($style) ? $style : '').'>Bestehende Freundschaften</td>
	</tr>';
	if(empty($array_friends))
		$output .= '<tr><td colspan="3">Keine Freunde vorhanden</td></tr>';
	foreach($array_friends as $friend){
		$output .= renderFriendOutput($friend['idFriend'], $friend['Vorname']." ".$friend['Nachname'], $friend['isFriend']);
	}
	$output .=
'</table>';
?>