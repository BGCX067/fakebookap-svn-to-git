<?php
function getH2($title){
	return
	'<div class="clearfix header_bottom">
		<h2 class="header_title">'.$title.'</h2>
	</div>';
}

function getProfileHeader($title, $anhang = ""){
	return
	'<div class="clearfix profile_header">
		<font class="header_title">'.$title.'</font>
		<font class="anhang">&nbsp;'.$anhang.'</font>
	</div>';
}

function getImage($user_id){
	$image = 'media/images/users/'.$user_id.'.jpg';
	if(is_file($image))
		return $image;
	return 'media/images/users/default.jpg';
}

function getImageSmall($user_id){
	$image = 'media/images/users/small/'.$user_id.'.jpg';
	if(is_file($image))
		return $image;
	return 'media/images/users/small/default.jpg';
}

function getGroupImage($group_id){
	$image = 'media/images/groups/'.$group_id.'.jpg';
	if(is_file($image))
		return $image;
	return 'media/images/groups/default.jpg';
}

function getGroupImageSmall($group_id){
	$image = 'media/images/groups/small/'.$group_id.'.jpg';
	if(is_file($image))
		return $image;
	return 'media/images/groups/small/default.jpg';
}

function renderFriendOutput($id, $name, $isFriend, $renderGroup=false){
	$site = $renderGroup ? "gruppe" : "profil";
	$image = $renderGroup ? getGroupImageSmall($id) : getImageSmall($id);
	$text = 
	'<tr class="friendList">		
		<td width="60px">
			<a href="'.$_SERVER['PHP_SELF'].'?site='.$site.'&id='.$id.'">
				<img src="'.$image.'" border=0></img>
			</a>
		</td>
		<td class="profilName">
			<a href="'.$_SERVER['PHP_SELF'].'?site='.$site.'&id='.$id.'">
				'.$name.'
			</a>
		</td>';
		if($isFriend == 0)
			$text .= getFriendButton("add", $id);
		elseif($isFriend == 2)
			$text .= getFriendButton("accept", $id);
		elseif($isFriend == 3){
			$text .= getAnfrageButtons($id, $renderGroup ? "G" : "F");
		}
		else
			$text .= '<tr><td></td></tr>';
	$text .= '</tr>';
	return $text;
}

function getAnfrageButtons($id, $typ){
	GLOBAL $url;
	return 
	'<td align="right" width="180px">
		<div style="padding-left: 25px">
			<a class="boldbuttonsgray" href="'.$url.'&acc'.$typ.'='.$id.'">
				<span>Akzeptieren</span>
			</a>
			<a class="boldbuttonsgray" href="'.$url.'&dec'.$typ.'='.$id.'" style="margin-left: 5px">
				<span>Ablehnen</span>
			</a>
		</div>
	</td>';
}

function getFriendButton($typ, $id){
	GLOBAL $url;
	if($typ == "add"){
		$padding_left = 30;
		$friend_url = $url."&addfr=$id";
		$text = "Als FreundIn hinzufügen";
	} elseif($typ == "accept"){
		$padding_left = 24;
		$friend_url = $url."&accfr=$id";
		$text = "Als FreundIn akzeptieren";
	}
	return 
	'<td align="right" width="180px">
		<div style="padding-left: '.$padding_left.'px">
			<a class="boldbuttonsgray" href="'.$friend_url.'">
				<span>'.$text.'</span>
			</a>
		</div>
	</td>';
}

/**
 * Sorting two dimensional array by sub-key's value
 * @param $array array
 * @param $by string //Sub-key name
 * @param $type string //asc,desc
 * @return array
 */
function sortArray($arr, $index, $direction='asc') {
    $i_tab = array();
    foreach ($arr as $key => $ele) {
    	$i_tab[$key] = $arr[$key][$index];
    }
    $sort = 'asort';
    if (strtolower($direction) == 'desc') {
    	$sort = 'arsort';
    }   
    $sort($i_tab);
    $n_ar = array();
    foreach ($i_tab as $key => $ele) {
    	array_push($n_ar, $arr[$key]);
	}
	return($n_ar);
} 
?>