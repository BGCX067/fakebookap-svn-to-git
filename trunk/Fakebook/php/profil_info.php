<?php
$output .= '<table style="width:100%;">';
if(isset($allgemein) && count($allgemein) > 0){
	$output .= 
	'<tr>
		<td colspan=2 class="infounderlined">Allgemeines</td>
	</tr>';
	for ($i = 0; $i < count($allgemein); $i++){
		$output .= 
		'<tr>
			<td class="infotitle">'.$allgemein[$i]['bezeichnung'].':</td>
			<td>'.$allgemein[$i]['wert'].'</td>
		</tr>';
	}
}
if(isset($persoenlich) && count($persoenlich) > 0){
	$output .= 
	'<tr>
		<td colspan=2 class="infounderlined">Persönliches</td>
	</tr>';
	for ($i = 0; $i < count($persoenlich); $i++){
		$output .= 
		'<tr>
			<td class="infotitle">'.$persoenlich[$i]['bezeichnung'].':</td>
			<td>'.$persoenlich[$i]['wert'].'</td>
		</tr>';
	}
}
$output .= 
'<tr>
	<td colspan=2 class="infounderlined">Kontakt</td>
</tr>
<tr>
	<td class="infotitle">E-Mail:</td>
	<td>'.$data['email'].'</td>
</tr>';

if(isset($ausbildung) && count($ausbildung) > 0){
	$output .= 
	'<tr>
		<td colspan=2 class="infounderlined">Ausbildung & Beruf</td>
	</tr>';
	for ($i = 0; $i < count($ausbildung); $i++){
		$output .= 
		'<tr>
			<td class="infotitle">'.$ausbildung[$i]['bezeichnung'].':</td>
			<td>'.$ausbildung[$i]['wert'].'</td>
		</tr>';
	}
}
if(isset($groups) && count($groups) > 0){
	$gruppen = "";
	for ($i = 0; $i < count($groups); $i++ ){
		if($i == 0){
			$gruppen = '<a href="index.php?site=gruppe&id='.$groups[$i]['idGruppe'].'">'.$groups[$i]['name'].'</a>';
		} else {
			$gruppen .= ', <a href="index.php?site=gruppe&id='.$groups[$i]['idGruppe'].'">'.$groups[$i]['name'].'</a>';
		}
	}
	$output .= 
	'<tr>
		<td colspan=2 class="infounderlined">Gruppen</td>
	</tr>
	<tr>
		<td class="infotitle">Mitglied von:</td>
		<td>'.$gruppen.'</td>
	</tr>';
}
$output .= '</table>';
?>