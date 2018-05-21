<?
if (!function_exists('cd')) {
	function cd($var){
		echo "<pre>";
		var_dump($var);
		exit;
	}
}

if (!function_exists('xssc')) {
	function xssc($var){
		return htmlspecialchars($var);
	}
}
