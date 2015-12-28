<?php
function convertMessageDate($date, $use_today = false){
	$day = convertDate($date, "d");
	$month = convertDate($date, "m");
	$year = convertDate($date, "Y");
	$hour = convertDate($date, "H");
	$minute = convertDate($date, "i");
	$today = date("Ymd");
	
	if((date("Ymd") == $year.$month.$day) || !$use_today)
		$formatted_date = "$day. ".getMonth($month)." um $hour:$minute";
	else
		$formatted_date = "$day. ".getMonth($month)." $year";
	return $formatted_date;
}

function getMonth($month){
	switch($month){
		case 1:	return "Januar"; break;
		case 2: return "Februar"; break;
		case 3: return "März"; break;
		case 4: return "April"; break;
		case 5: return "Mai"; break;
		case 6: return "Juni"; break;
		case 7: return "Juli"; break;
		case 8: return "August"; break;
		case 9: return "September"; break;
		case 10: return "Oktober"; break;
		case 11: return "November"; break;
		case 12: return "Dezember"; break;
		default: return "not available";
	}
}

function convertDate($date, $format){
	$stamp = strtotime($date);
	$newDate = date($format, $stamp);
	return $newDate;
}
?>