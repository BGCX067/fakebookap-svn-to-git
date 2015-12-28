<?php
$output .= 
'<table width="250px" cellpadding="0" cellspacing="0">
	<tr style="border-bottom: 1px solid #cccccc;">
		<td class="sidebar_title">Anfragen</td>
		<td class="small" align="right">
			<a href="'.$_SERVER['PHP_SELF'].'?site=anfragen">Alle anzeigen</a>
		</td>
	</tr>
	<tr>
		<td colspan="2">';
			mysql_close($connection);
			$connection = getConnection();
			$sql = "CALL sps_getAnfragen($user_id)";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					if($row['Typ'] == "f")
						$request_friends[] = $row;
					elseif($row['Typ'] == "g")
						$request_groups[] = $row;
				}
				$count_friends = count($request_friends);
				$count_groups = count($request_groups);
				$output .= '<table width="100%" cellpadding="0" cellspacing="0">';
					if($count_friends > 0)
						$output .=	'<tr><td width="10px"><img src="media/images/friend.jpg" border="" alt="" /></td>
						<td><span style="font-size: 11px"><b>'.$count_friends.'</b> Freundschaftsanfrage'.($count_friends == 1 ? '' : 'n').'</span></td></tr>';
					if($count_groups > 0)
						$output .=	'<tr><td width="20px"><img src="media/images/group.jpg" border="" alt="" /></td>
						<td><span style="font-size: 11px"><b>'.$count_groups.'</b> Gruppen-Einladung'.($count_groups == 1 ? '' : 'en').'</span></td></tr>';
				$output .= '</table>';
			} else {
				$output .= 'Keine offenen Anfragen vorhanden';
			}
		$output .= 
		'</td>
	</tr>
</table>
';
?>