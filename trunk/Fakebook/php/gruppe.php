<?php
include 'includes/checkLogin.php';
$page_title = "Details";
$group_id = isset($g_id) ? $g_id : "";
$tab = isset($g_tab) ? $g_tab : "home";
$url_wt = $_SERVER['PHP_SELF'].'?site='.$site.'&id='.$group_id;
$url = $url_wt.(!empty($g_tab) ? "&tab=$g_tab": "");

if(isset($p_joinGroup)){
	$sql = "CALL sps_setUserRightsInGroup($group_id, $user_id, 0)";
	mysql_query($sql);
	$member = true;
} elseif (isset($g_inviteFr)) {
	$sql = "CALL sps_setUserRightsInGroup($group_id, $g_inviteFr, -1)";
	mysql_query($sql);
	$member = true;
}
else {
	$sql = "CALL sps_isUserInGroup($user_id, $group_id)";
	$result = mysql_query($sql);
	$member = (mysql_num_rows($result) > 0 ? true : false);
}
mysql_close($connection);
$connection = getConnection();

$sql = "CALL sps_getGroupInformations($group_id)";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$data = $row;
}

mysql_close($connection);
$connection = getConnection();

if(!empty($data) && $group_id != "") {
	$sql = "CALL sps_getGroupMembers($group_id)";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$members[] = $row;
	}

	mysql_close($connection);
	$connection = getConnection();

	shuffle($members);

	$output .= '<table width="100%" colspan="0" cellpadding="0">
					<tr>
						<td style="vertical-align:top; width: 200px;">
							<table width="100%" colspan="0" cellpadding="0">
								<tr>
									<td colspan="2"><img src="'.getGroupImage($group_id).'"></img></td>
								</tr>
								<tr style="height:20px;">
								</tr>
								<tr height="24px" style="border-right: 1px solid #d8dfea;">
									<td class="widget" colspan="2">Mitglieder</td>
								</tr>
								<tr height="18px" style="border-right: 1px solid #d8dfea; border-bottom: 1px solid #eceff5;">
									<td><a href="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'&tab=members" class="link_small" style="padding-left: 4px;">'.count($members).' Mitglieder</a></td>
									<td align="right"><a href="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'&tab=members" class="link_small" style="padding-right: 4px;">Alle anzeigen</a></td>
								</tr>
								<tr class="friend"><td colspan="2"><table width="100%"><tr>';
	for($i = 0; $i < (count($members) > 6 ? 6 : count($members)); $i++){
		$output .= '				<td class="friends">
										<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$members[$i]["idBenutzer"].'">
											<img src="'.getImageSmall($members[$i]["idBenutzer"]).'" border=0></img><br>
											'.$members[$i]["vorname"]." ".$members[$i]["nachname"].'
										</a>
									</td>';
		if(($i + 1) % 3 == 0 && $i != 8 && $i != 0){
			$output .= '				</tr></tr>';
		}
	}
	$output .= '				</tr><tr height="10px"></tr></table></td></tr>
							</table>
						</td>
						<td style="width:20px;"></td>
						<td style="vertical-align:top;">
						<form action="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'" method="post">
							<table style="width:100%;">';
	if(!$member){
		$output .= '				<tr>
										<td colspan=2>'.getProfileHeader($data['name'].' <input type="submit" class="inputsubmit" name="joinGroup" value="Gruppe beitreten"></input>').'
										</td>
									</tr>
								</table>
							</form>';
	} else {
		$output .= '				<tr>
										<td colspan=2>'.getProfileHeader($data['name']).'</td>
									</tr>
								</table>
							</form>';
	}

	$output .=				'<div id="navcontainer">
								<ul id="navlist">
									<li id="active" class="first"><a href="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'" '.($tab == "home" ? 'id="current"' : '').'>'.$page_title.'</a></li>
									<li><a href="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'&tab=members" '.($tab == "members" ? 'id="current"' : '').'>Mitglieder</a></li>
									<li><a href="'.$_SERVER['PHP_SELF'].'?site=gruppe&id='.$group_id.'&tab=invite" '.($tab == "invite" ? 'id="current"' : '').'>Einladen</a></li>
								</ul>
							</div>
							<div class="editor_panel clearfix">
								<table style="width:100%;">';
	if($tab == "home"){
		$output .= '				<tr>
										<td colspan=2 class="infounderlined">Allgemeines</td>
									</tr>
									<tr>
										<td class="infotitle">Name:</td>
										<td>'.$data['name'].'</td>
									</tr>
									<tr>
										<td class="infotitle">Kategorie:</td>
										<td>'.$data['typ'].'</td>
									</tr>
									<tr>
										<td class="infotitle">Beschreibung:</td>
										<td>'.$data['beschreibung'].'</td>
									</tr>';
	} else if ($tab == "members") {
		$members = sortArray($members, "vorname");
		$output .= '				<tr>
										<td colspan=2 class="infounderlined">Mitglieder</td>
									</tr>';
		for($i = 0; $i < count($members); $i++) {
			$output .= '			<tr class="friendList">
										<td width="60px">
											<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$members[$i]["idBenutzer"].'">
												<img src="'.getImageSmall($members[$i]["idBenutzer"]).'" border=0></img>
											</a>
										</td>
										<td class="profilName">
											<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$members[$i]["idBenutzer"].'">
												'.$members[$i]['vorname'].' '.$members[$i]['nachname'].'
											</a>
										</td>
									</tr>';
				
		}
	} else if($tab == "invite"){
		$inGroup = false;
		for ($x = 0; $x < count($members); $x++){
			if($members[$x]['idBenutzer'] == $user_id){
				$inGroup = true;
				break;
			}
		}
		if($inGroup){
			$sql = "CALL sps_getOwnFriends($user_id)";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$friends[] = $row;
			}
			$friends = sortArray($friends, "Vorname");
			$output .= '			<tr>
										<td colspan=3 class="infounderlined">Freunde</td>
									</tr>';
			for($i = 0; $i < count($friends); $i++) {
				$output .= '		<tr>
										<td style="width:60px;">
											<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$friends[$i]["idFriend"].'">
												<img src="'.getImageSmall($friends[$i]["idFriend"]).'" border=0></img>
											</a>
										</td>
										<td class="profilName">
											<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$friends[$i]["idFriend"].'">
												'.$friends[$i]['Vorname'].' '.$friends[$i]['Nachname'].'
											</a>
										</td>
										<td align="right" width="150px">';
				$inGroup = false;
				for ($x = 0; $x < count($members); $x++){
					if($members[$x]['idBenutzer'] == $friends[$i]["idFriend"]){
						$inGroup = true;
						break;
					}
				}
				if(!$inGroup){
					$output .= '			<div style="padding-left: 30px">
												<a class="boldbuttonsgray" href="'.$url."&inviteFr=".$friends[$i]["idFriend"]."".'">
													<span>FreundIn Einladen</span>
												</a>
											</div>';
				}

				$output .= '			</td>
									</tr>';		
			}
		} else {
			$output .= 'Sie müssen in der Gruppe sein um Freunde einzuladen!';
		}
	} else {
		$output .= '<tr><td>Dieser tab existiert nicht!</td></tr>';
	}
	$output .= '				</table>
							</div>
						</td>
					</tr>
				</table>';
} else {
	$output .= getH2("Gruppe existiert nicht");
	$output .= '<p>Die Gruppe mit der ID \'<b>'.$group_id.'</b>\' extistiert nicht und kann somit nicht angezeigt werden</p>';
}
?>