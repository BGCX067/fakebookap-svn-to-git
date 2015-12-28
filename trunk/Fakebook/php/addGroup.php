<?php
include 'includes/checkLogin.php';
$page_title = "Gruppe gründen";

$name = isset($p_gruppenname) ? $p_gruppenname : "";
$beschreibung = isset($p_beschreibung) ? htmlentities($p_beschreibung) : "";
$gruppentyp = isset($p_gruppentyp) ? $p_gruppentyp : "";

$output .= getH2('Gruppe gründen');
if(!(isset($p_add) && $name != "" && $beschreibung != "" && $gruppentyp != "" && $gruppentyp != "-")){
	$output .=
	'<div id="navcontainer">
		<ul id="navlist">
			<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
		</ul>
	</div>
	<div class="editor_panel clearfix">';

	$sql = "CALL sps_getGruppentyp()";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$typ[] = $row;
	}

	$output .= '<div style="height: 10px"></div>
						<form name="addGroup" action="index.php?site=addGroup" method="post">
						<center>
							<table width="45%" cellspacing="0" cellpadding="0">
								<tr>
									<td align="left" valign="top" width="100px">
										<span style="font-size: 11px; color: #777777; font-weight: bold">Gruppenname:</span><br>
										<span style="font-size: 9px; color: #999999; font-weight: bold">(Pflichtfeld)</span>
									</td>
									<td align="left" valign="top">
										<input class="inputtext" type="text" name="gruppenname" style="width:305px;" value="'.$name.'"></input>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" width="100px">
										<span style="font-size: 11px; color: #777777; font-weight: bold">Beschreibung:</span><br>
										<span style="font-size: 9px; color: #999999; font-weight: bold">(Pflichtfeld)</span>
									</td>
									<td align="left" valign="top">
										<textarea class="textarea" name="beschreibung" style="width:305px; height:75px;">'.$beschreibung.'</textarea>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="height:13px;">
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" width="100px">
										<span style="font-size: 11px; color: #777777; font-weight: bold">Art der Gruppe:</span><br>
										<span style="font-size: 9px; color: #999999; font-weight: bold">(Pflichtfeld)</span>
									</td>
									<td align="left" valign="top">
										<select name="gruppentyp" size="1">
											<option value="-">Kategorie wählen:</option>';
	for ($i = 0; $i < count($typ); $i++){
		$output .= '						<option value="'.$typ[$i]['idGruppentyp'].'">'.$typ[$i]['typ'].'</option>';
	}
	$output .= '						</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<div style="float: right;">
											<input class="inputsubmit" type="submit" name="add" value="Gruppe gründen"></input>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</form>';
	$output .= '</div></div>';
} else {
	$page_title = "Bestätigung";
	$output .=
	'<div id="navcontainer">
		<ul id="navlist">
			<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
		</ul>
	</div>
	<div class="editor_panel clearfix">';
	$sql = "CALL sps_createGroup('".htmlspecialchars($name)."', '$beschreibung', $gruppentyp, $user_id)";
	mysql_query($sql);
	$output .= "<p>Deine Gruppe wurde erfolgreich erstellt.</p>";
}
$output .= '</div>';
?>