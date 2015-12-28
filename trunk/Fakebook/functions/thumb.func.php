<?php
function thumbImage($file, $save, $width, $height, $prop = true) {
	if(is_file($file)){
		@unlink($save);
		$infos = getimagesize($file);
		if($prop) {
			// Proportionen erhalten
			$image_width = $infos[0];
			$image_height = $infos[1];
			$ratio_width = $width / $image_width;
			$ratio_height = $height / $image_height;
			if ($ratio_width < $ratio_height) {
				$new_width = $image_width * $ratio_width;
				$new_height = $image_height * $ratio_width;
			} else {
				$new_width = $image_width * $ratio_height;
				$new_height = $image_height * $ratio_height;
			}
		} else {
			// Strecken und Stauchen auf Grφίe
			$new_width = $width;
			$new_height = $height;
		}
		if($infos[2] == 2) { // jpg
			$image_a = imagecreatefromjpeg($file);
			$image_b = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($image_b, $image_a, 0, 0, 0, 0, $new_width, $new_height, $infos[0], $infos[1]);
			imagejpeg($image_b, $save);
			return true;
		}
	}
	return false;
}

function cutImage($file, $save_path, $save_name, $width, $height){
	$ext = ".jpg";
	$infos = getimagesize($file.$ext);
	if($infos[0] < 200)
		return false;
	if($infos[0] > $infos[1]){
		thumbImage($file.$ext, $save_path.$save_name.$ext, 500, 51);
		$infos_small = getimagesize($save_path.$save_name.$ext);
		$x = $infos_small[0] > 50 ? ($infos_small[0] - 50) / 2 : 0;
		$point = array($x, 0); // Koordinaten, ab wo kopiert werden soll (erst X, dann Y).
	} else {
		thumbImage($file.$ext, $save_path.$save_name.$ext, 51, 500);
		$infos_small = getimagesize($save_path.$save_name.$ext);
		$y = $infos_small[1] > 50 ? ($infos_small[1] - 50) / 2 : 0;
		$point = array(0, $y); // Koordinaten, ab wo kopiert werden soll (erst X, dann Y).
	}
	$size = array(50, 50); // Breite und Hφhe des Auschnitts
	
	$image = imagecreatefromjpeg($save_path.$save_name.$ext); // Original einlesen
	$new = imagecreatetruecolor($size[0],$size[1]); // Neues Bild leer erstellen
	imagecopyresampled($new, $image, 0, 0, $point[0], $point[1], $size[0], $size[1], $size[0], $size[1]); // Ausschnitt rόberkopieren
	imagejpeg($new, $save_path."small/".$save_name.$ext ,100); // Neues Bild speichern
	unlink($save_path.$save_name.$ext);
	
	$width = 200;
	$height = $width * 10;
	thumbImage($file.$ext, $save_path.$save_name.$ext, $width, $height);
	return true;
}
?>