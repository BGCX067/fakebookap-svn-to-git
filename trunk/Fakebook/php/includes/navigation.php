<?php
$output .= '
<div id="navigation-bg">
	<div id="navigation">
		<div id="menubar">
			<ul id="menu_list" class="menu_list">
				<li class="menu">
					<a class="logo_link" title="Zur Fakebook-Startseite gehen" href="'.$_SERVER['PHP_SELF'].'?site=startseite">
						<div id="image_logo"></div>
					</a>
				</li>
				<li class="menu">
					<a class="menu_link" href="'.$_SERVER['PHP_SELF'].'?site=startseite">Startseite</a>
				</li>
				<li class="menu">
					<a class="menu_link" href="'.$_SERVER['PHP_SELF'].'?site=profil">Profil</a>
				</li>
				<li class="menu">
					<a class="menu_link" href="'.$_SERVER['PHP_SELF'].'?site=profil&tab=freunde">Freunde</a>
				</li>';
				if($logged_in){
					$output .=
					'<li class="menu">
						<a class="menu_link" href="'.$_SERVER['PHP_SELF'].'?site=postfach">Postfach</a>
					</li>
					<li class="menu">
						<a class="menu_link" href="'.$_SERVER['PHP_SELF'].'?site=logout">Logout</a>
					</li>';
				}
			$output .= '
			</ul>
		</div>
	</div>
</div>';
?>