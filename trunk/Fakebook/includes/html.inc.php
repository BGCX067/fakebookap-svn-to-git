<?php
function html_header($title){
	$output = "<?xml version='1.0' encoding='ISO-8859-1' ?>\n";
	$output .= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
          'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
	$output .= "<html xmlns='http://www.w3.org/1999/xhtml' lang='de' xml:lang='de'>\n";
	$output .= "<head>\n";
	$output .= "<title>{$title}</title>\n";
	$output .= "<link rel='stylesheet' type='text/css' href='media/style.css' />";
	$output .= "</head>\n";
	$output .= "<body>\n";
	return $output;
}

function html_footer(){
	$output = "\n</body>\n";
	$output .= "</html>";
	return $output;
}
?>