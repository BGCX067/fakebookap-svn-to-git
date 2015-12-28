<?php
$page_title = "Profil";
$site_forward = "profil";

include 'includes/checkLogin.php';

$profil_id = isset($g_id) ? $g_id : $user_id;
$p_user_status = isset($p_user_status) ? trim($p_user_status) : "";
$g_tab = isset($g_tab) ? trim($g_tab) : "";
$url_wt = $_SERVER['PHP_SELF'].'?site='.$site.'&id='.$profil_id;
$url = $url_wt.(!empty($g_tab) ? "&tab=$g_tab": "");

if(isset($p_status_hidden) && !empty($p_user_status)){
	$datum = date("Y-m-d H:i:s");
	$sql = "CALL sps_createMeldung($user_id, '$p_user_status', '$datum')";
	$result = mysql_query($sql);
	$p_user_status = "";
}
if(isset($g_accfr)){
	$sql = "CALL sps_acceptFriend($user_id, $g_accfr)";
	mysql_query($sql);
	mysql_close($connection);
	$connection = getConnection();
}
if(isset($g_addfr)){
	$sql = "CALL sps_addFriend($user_id, $g_addfr)";
	mysql_query($sql);
	mysql_close($connection);
	$connection = getConnection();
}
if($profil_id != $user_id){
	if(isset($p_addFriend)){
		$sql = "CALL sps_addFriend($user_id, $profil_id)";
		$result = mysql_query($sql);
	} elseif(isset($p_acceptFriend)){
		$sql = "CALL sps_acceptFriend($user_id, $profil_id)";
		$result = mysql_query($sql);
	} else {
		$sql = "CALL sps_getFriendship($profil_id, $user_id)";
		$result = mysql_query($sql);
	}
	if(empty($result)){
		$friendship = NULL;
	} else {
		while($row = mysql_fetch_assoc($result)){
			$friendship = $row;
		}
	}
	mysql_close($connection);
	$connection = getConnection();
} else {
	$friendship['status'] = 1;
}

if($friendship['status'] != NULL && $friendship['status'] != 0) {
	$sql = "CALL sps_getUserInformations($profil_id)";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		switch ($row['bezeichnung']) {
			case "Geschlecht":
			case "Geburtstag":
			case "Heimatstadt":
			case "Interessiert an":
			case "Politische Einstellung":
			case "Religiöse Ansichten":
				$allgemein[] = $row;
				break;
			case "Über mich":
				$persoenlich[] = $row;
				break;
			case "Schule":
			case "Arbeitgeber":
				$ausbildung[] = $row;
				break;
		}
	}
	mysql_free_result($result);
	mysql_close($connection);
	$connection = getConnection();

	$sql = "CALL sps_getUserGroups($profil_id)";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$groups[] = $row;
	}
	mysql_close($connection);
	$connection = getConnection();
}

$sql = "CALL sps_getUserData($profil_id)";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$data = $row;
}
mysql_close($connection);
$connection = getConnection();

$sql = "CALL sps_getFriends($profil_id, $user_id)";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$friends[] = $row;
}

if(!empty($friends))
	shuffle($friends);

$output .= 
'<table width="100%" colspan="0" cellpadding="0">
	<tr>
		<td style="vertical-align:top; width: 200px;">
			<table width="100%" colspan="0" cellpadding="0">
				<tr>
					<td colspan="2"><img src="'.getImage($profil_id).'"></img></td>
				</tr>
				<tr>
					<td colspan="2">
						<a href="#" class="underlined">'.$data['vorname'].' eine Nachricht schreiben</a>
					</td>
				</tr>
				<tr style="height:20px;">
				</tr>
				<tr height="24px" style="border-right: 1px solid #d8dfea;">
					<td class="widget" colspan="2">Freunde</td>
				</tr>
				<tr height="18px" style="border-right: 1px solid #d8dfea; border-bottom: 1px solid #eceff5;">
					<td><a href="" class="link_small" style="padding-left: 4px;">'.count($friends).' Freunde</a></td>
					<td align="right"><a href="'.$url_wt.'&tab=freunde" class="link_small" style="padding-right: 4px;">Alle anzeigen</a></td>
				</tr>
				<tr class="friend"><td colspan="2"><table width="100%"><tr>';
				for($i = 0; $i < (count($friends) > 6 ? 6 : count($friends)); $i++){
					$output .= 
					'<td class="friends">
						<a href="'.$_SERVER['PHP_SELF'].'?site=profil&id='.$friends[$i]["idFriend"].'">
							<img src="'.getImageSmall($friends[$i]["idFriend"]).'" border=0></img><br>
							'.$friends[$i]["Vorname"]." ".$friends[$i]["Nachname"].'
						</a>
					</td>';
					if(($i + 1) % 3 == 0 && $i != 8 && $i != 0){
						$output .= '</tr></tr>';
					}
				}
				$output .= '</tr><tr height="10px"></tr></table></td></tr>';
				$output .= 
			'</table>
		</td>
		<td style="width:20px;"></td>
		<td style="vertical-align:top;">
			<form name="profil_form" action="'.$url.'" method="post">
				<table style="width:100%;">';
					if($friendship['status'] == NULL){
						$output .= 
						'<tr>
							<td colspan=2>'.getProfileHeader($data['vorname'].' '.$data['nachname'].' <input type="submit" class="inputsubmit" name="addFriend" value="Als FreundIn hinzufügen"></input>').'
							</td>
						</tr>';
					} elseif($friendship['status'] == 0){
						if($friendship['idBenutzerTo'] == $user_id) {
							$output .= 
							'<tr>
								<td colspan=2>'.getProfileHeader($data['vorname'].' '.$data['nachname'].' <input type="submit" class="inputsubmit" name="acceptFriend" value="Freundschaftsanfrage akzeptieren"></input>').'</td>
							</tr>';
						} else {
							$output .= 
							'<tr>
								<td colspan=2>'.getProfileHeader($data['vorname'].' '.$data['nachname'], "Freundschaftsanfrage anhängig").'</td>
							</tr>';
						}
					} else {
						$output .= 
						'<tr>
							<td colspan=2>'.getProfileHeader($data['vorname']." ".$data['nachname']).'</td>
						</tr>';
					}
					if($user_id == $profil_id){
						$output .=
						'<tr>
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
												<input name="user_status" type="text" value="'.$p_user_status.'" class="inputtext" style="width: 568px; margin-top: 1px" />
												<input type="hidden" name="status_hidden" value="true" />
											</td>
											<td>
												<a class="boldbuttons" href="#" onclick="document.forms[\'profil_form\'].submit(); return;"><span>Veröffentlichen</span></a>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>';
					}
					$output .= 
				'</table>
			</form>
			<div id="navcontainer">
				<ul id="navlist">
					<li id="active" class="first"><a href="'.$url_wt.'" '.($g_tab != "info" && $g_tab != "freunde" ? 'id="current"' : '').'>Meldungen</a></li>
					<li id="active"><a href="'.$url_wt.'&tab=info" '.($g_tab == "info" ? 'id="current"' : '').'>Informationen</a></li>
					<li id="active"><a href="'.$url_wt.'&tab=freunde" '.($g_tab == "freunde" ? 'id="current"' : '').'>Freunde</a></li>
				</ul>
			</div>
			<div class="editor_panel clearfix">';
				if($g_tab == "freunde")
					include 'profil_freunde.php';
				elseif($g_tab == "info")
					include 'profil_info.php';
				else
					include 'profil_meldungen.php';
			$output .= 
			'</div>
		</td>
	</tr>
</table>';
?>