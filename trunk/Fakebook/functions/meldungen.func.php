<?php
function getMeldungText($type, $values){
	GLOBAL $user_vorname;
	switch($type){
		case "Kommentar":
			$user = split(",", $values);
			return "$user_vorname hat ".getProfilLink($user[0], $user[1]).getS($user[1])." Meldung kommentiert.";
	}
	return "";
}

function getS($username){
	$lastChar = substr($username, -1, 1);
	if($lastChar == "s" || $lastChar == "z")
		return "";
	return "s";
}

function getProfilLink($user_id, $username){
	return '<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$user_id.'" >'.$username.'</a>';
}

function getMeldung($user, $user_id, $datum, $text, $idMeldung, $kommentar, $url){
	GLOBAL $site, $connection;
	$text =
	'<tr style="border-top: 1px solid #eeeeee;">
		<td align="left" valign="top" width="55px" style="padding-top: 7px">
			<img src="'.getImageSmall($user_id).'" border="0" />
		</td>
		<td align="left" valign="top" style="padding-top: 9px; padding-bottom: 10px">
			<div>
				<b><a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$user_id.'">'.$user.'</a></b>
				<span style="font-size: 11px; color: #777777">'.convertMessageDate($datum).'</span>
			</div>
			<div style="color: #333333; padding-top: 2px;">'.$text.'</div>
			<div>
				<a href="'.$url.'&tc='.$idMeldung.'" class="link_small">Kommentieren</a>';
				mysql_close($connection);
				$connection = getConnection();
	
				$sql = "CALL sps_getKommentare($idMeldung);";
				$result = mysql_query($sql);
				if(mysql_num_rows($result) > 0 || $kommentar){
					$text .= '<div id="image_comment_top"></div><div style="width: 375px;">';
					while($row = mysql_fetch_array($result)){
						$text .= 
						'<div class="comment">
							<div>
								<b><a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$row['idBenutzer'].'" style="font-size: 11px">'.$row['Vorname'].' '.$row['Nachname'].'</a></b>
								<span style="font-size: 11px; color: #777777">'.convertMessageDate($row['Datum']).'</span>
							</div>
							<div style="color: #333333; padding: 2px 0 2px 0; font-size: 11px">'.$row['Kommentar'].'</div>
						</div>';
					}
					$text .= 
					'<div class="comment">
						<table>
							<tr>
								<form name="kommentieren" action="'.$url.'" method="post">
									<td><input id="kommentar_'.$idMeldung.'" type="text" name="kommentar" class="inputtext" size="42" /></td>
									<input type="hidden" name="message_id" value="'.$idMeldung.'" />
									<input type="hidden" name="message_user" value="'.$user_id.','.$user.'" />
									<td><input type="submit" class="inputsubmit" value="Kommentieren"/></td>
								</form>
							</tr>
						</table>
					</div>
				</div>';
				}
			$text .= '	
			</div>
		</td>
	</tr>';	
	return $text;
}
?>