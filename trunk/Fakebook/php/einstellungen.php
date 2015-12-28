<?php
$output .= getH2("Mein Konto");
$output .= 
'<div id="navcontainer">
	<ul id="navlist">
		<li id="active" class="first"><a href="#" id="current">Einstellungen</a></li>
		<li><a href="#">Netzwerke</a></li>
		<li><a href="#">Facebook-Werbeanzeigen</a></li>
	</ul>
</div>
<div class="editor_panel clearfix">
	Bitte drücken Sie den folgenden Button nicht, da er sehr gefährlich ist.
	<br><br>
	<input id="save_alternate_name" class="inputsubmit" type="submit" value="Alternativen Namen ändern" name="save_alternate_name" onclick="return change_alternate_name();"/>
</div>';
?>