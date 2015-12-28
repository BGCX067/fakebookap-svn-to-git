<?php
function getMessageDetail($id, $user, $user_id, $datum, $betreff, $nachricht, $gelesen, $geantwortet){
	$nachricht = substr($nachricht, 0, 90);
	$nachricht .= strlen($nachricht) >= 90 ? " ..." : "";
	
	$image_left_name = $gelesen ? ($geantwortet ? "geantwortet.png" : "") : "ungelesen.png";
	$image_left = empty($image_left_name) ? '' : '<img src="media/images/'.$image_left_name.'" border="0" style="padding-left:6px" />';
	$background_color = $gelesen ? "" : "background-color: #eceef4";
	
	return 
	'<table width="100%" cellspacing="0" cellpadding="0">
		<tr style="border-bottom: 1px solid #e5e5e5; '.$background_color.'">
			<td width="20px">
				'.$image_left.'
			</td>
			<td align="left" width="55px">
				<img src="'.getImageSmall($user_id).'" border="0" />
			</td>
			<td align="left" width="180px">
				<div style="font-size: 11px;"><a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$user_id.'">'.$user.'</a></div>
				<div style="font-size: 10px; color: #808080">'.convertMessageDate($datum, true).'</div>
			</td>
			<td align="left">
				<div style="font-size: 11px;"><a href="'.$_SERVER['PHP_SELF'].'?site=nachrichten&id='.$id.'&idBt='.$user_id.'">'.($gelesen ? "" : "<b>").$betreff.($gelesen ? "" : "</b>").'</a></div>
				<div style="font-size: 11px; color: #808080">'.$nachricht.'</div>
			</td>
			<td align="right" width="20px" style="padding-right: 6px">
				<a href="'.$_SERVER['PHP_SELF'].'?site=postfach&dlMsg='.$id.'">
					<div id="image_msg_delete"></div>
				</a>
			</td>
		</tr>
	</table>';
}

function getMessageOfParentDetail($user, $user_id, $datum, $nachricht){
	return
	'<table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 4px;">
		<tr style="border-top: 1px solid #dddddd;">
			<td align="left" valign="top" width="55px" style="padding-top: 8px">
				<img src="'.getImageSmall($user_id).'" border="0" />
			</td>
			<td align="left" valign="top" style="padding-top: 9px">
				<div>
					<b><a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$user_id.'">'.$user.'</a></b>
					<span style="font-size: 11px; color: #777777">'.convertMessageDate($datum).'</span>
				</div>
				<div style="color: #333333; padding-top: 5px; padding-bottom: 15px">'.nl2br($nachricht).'</div>
			</td>
		</tr>
	</table>';	
}

function getDropDownFriends($user_id, $friend, $width){
	$result = mysql_query("CALL sps_getOwnFriends($user_id)");
	$text = '<select name="friends_list" style="width: '.$widthpx.';">';
	while ($row = mysql_fetch_array($result)) {
		$friend_name = $row['Nachname'].", ".$row['Vorname'];
		$friends[$row['idFriend']] = $row['Nachname']."_".$row['Vorname'];
		if($friend == $friend_name)
			$text .= '<option selected>'.$friend_name.'</option>';
		else
			$text .= '<option>'.$friend_name.'</option>';
	}
	foreach($friends as $key => $value)
		$text .= '<input type="hidden" value="'.$key.'" name="'.$value.'" />';
	mysql_free_result($result);
	$text .= '</select>';
	return $text;
}
?>