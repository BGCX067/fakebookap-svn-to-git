<?php
$site_forward = "upload";
$page_title = "Upload";

// Überprüfen, ob Benutzer eingeloggt ist
include 'includes/checkLogin.php';

// Begrenzung des Bildes auf max. 200px
$height = 200;
$width = $height * 4;

// Steuerung ob für Benutzer oder Gruppe
$isUserImage = isset($g_groupId) ? false : true;
$group_id = isset($g_groupId) ? $g_groupId : ""; // TODO Gruppe-ID
$type = $isUserImage ? "users/" : "groups/";
$save_name = $isUserImage ? $user_id : $group_id;
$erw = isset($g_groupId) ? "&groupId=".$g_groupId : "";

$image_path = "media/images/";
$file_name = isset($_FILES["file"]["name"]) ? $_FILES["file"]["name"] : "";
$file_type = isset($_FILES["file"]["type"]) ? $_FILES["file"]["type"] : "";
$file_tmp_name = isset($_FILES["file"]["tmp_name"]) ? $_FILES["file"]["tmp_name"] : "";
$file_error = isset($_FILES["file"]["error"]) ? $_FILES["file"]["error"] : "";

if(isset($p_upload)){
	if(!empty($file_name)){
		if ($file_type == "image/jpeg") {
			if ($file_error > 0) {
				$warning[] = "Fehler beim Uploaden des Bildes (Error: $file_error)";
			} else {
				if (file_exists($image_path.$file_name)) {
					unlink($image_path.$file_name);
				}
				move_uploaded_file($file_tmp_name, $image_path.$file_name);
				
				$parts = explode('.', $file_name);
				$endung = array_pop($parts);
				$name = join('.', $parts);
				if(!cutImage($image_path.$name, $image_path.$type, $save_name, $width, $height))
					$warning[] = "Das Bild muss mind. 200 Pixel breit sein";
				else
					$bestaetigung = "Das Bild <b>$file_name</b> wurde erfolgreich hochgeladen";
			}
		} else { $warning[] = "Nur Bilder des Typs 'jpg' gültig"; }
	} else { $warning[] = "Sie müssen ein Bild ausgewählt haben"; }
}

if($isUserImage){
	$output .= getH2("Profilbild wechseln");
} else {
	$output .= getH2("Gruppenbild wechseln");
}
$output .= 
'<div id="navcontainer">
	<ul id="navlist">
		<li id="active" class="first"><a href="#" id="current">'.$page_title.'</a></li>
	</ul>
</div>
<div class="editor_panel clearfix">';
	if(empty($warning) && !empty($bestaetigung)){
		$output .= "<div id='meldung'>$bestaetigung</div>";
	}
	if(!empty($warning)) { 	
		$text = "<div id='meldung'><b>Ihre Eingaben enthalten Fehler:</b><br><ul>";
		foreach($warning as $warn) 
	    $text .= "<li>".$warn."</li>"; 
	    $text .= "</ul></div>";
	    $output .= $text;
	} 
	$output .= '<table cellpadding="0" cellspacing="0">';
	if(empty($bestaetigung)){
		$output .= '
		<form name="upload" action="'.$_SERVER['PHP_SELF'].'?site='.$site.$erw.'" method="post" enctype="multipart/form-data">
			<tr>
				<td class="left" width="80px" valign="top">Datei:</td>
				<td><input type="file" name="file" id="file" /></td>
			</tr>
			<input type="hidden" name="upload" value="true" />
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<div style="height: 5px;"></div>
					<div class="buttonwrapper">
						<a class="boldbuttons" href="#" onclick="document.forms[\'upload\'].submit(); return;"><span>Hochladen</span></a>
					</div>
				</td>
			</tr>
		</form>';
	}
	
	$output .= 
		'<tr>
			<td class="left" valign="top">Aktuelle Bilder:</td>
			<td>';
				if(is_file($image_path.$type.$save_name.'.jpg')){
					$output .= 
					'<img src="'.$image_path.$type.$save_name.'.jpg" style="margin: 0 5px 5px 0; border: 1px solid #c1c1c1; padding: 5px" alt="" />
					<img src="'.$image_path.$type."small/".$save_name.'.jpg" style="margin: 0 5px 5px 0; border: 1px solid #c1c1c1; padding: 5px" alt="" />';
				} else {
					$output .= 
					'<img src="'.$image_path.$type.'default.jpg" style="margin: 0 5px 5px 0; border: 1px solid #c1c1c1; padding: 5px" alt="" />
					<img src="'.$image_path.$type.'small/default.jpg" style="margin: 0 5px 5px 0; border: 1px solid #c1c1c1; padding: 5px" alt="" />';
				}
			$output .=  '</td>
		</tr>';
	$output .= '</table>';
$output .= '</div>';


?>
