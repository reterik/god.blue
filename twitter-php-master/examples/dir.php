<?php
$tweet = "";
$date = "2017-12-12";
$dir = "/var/www/html/search/".$date;
if (is_dir($dir)) {
$objects = scandir($dir);
foreach ($objects as $object) {
if ($object != "." && $object != "..") {
 $tweet = "http://feeds.blue/search/".$date."/".$object;
}
}
}
?>
