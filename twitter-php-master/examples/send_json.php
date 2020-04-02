<?php

require_once '/var/www/html/twitter-php-master/src/twitter.class.php';

$consumerKey = "xelkRdm2xjVrT09PRhgEbN7Cb";
$consumerSecret = "tdjMRPjpZWXzqWzFAmusvV35Le0wBSN7MXDRJAd7akNjcA1Czv";
$accessToken = "2842289662-SNOy7HUJMEMYKLK2rulYuXCnDRROU9yygfokfCF";
$accessTokenSecret = "lytI4meqZuxUuVSNAwp68Ewz4MjeoCMZSXItpZpCdQ2zg";
$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
$tweet = "";
$date = $argv[1];
$date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$dir = "/var/www/html/searchs/".$date;
if (is_dir($dir)) {
$objects = scandir($dir);
foreach ($objects as $object) {
if ($object != "." && $object != "..") {
$object = str_replace(".html", "", $object);
$url = str_replace(" ", "%20", $object);
 $tweet = "RSS Feeds Search: ".$date." ".$object." http://feeds.blue/searchs/".$date."/".$url;

try {
        $tweet = $twitter->send($tweet); // you can add $imagePath or array of image paths as second argument

} catch (TwitterException $e) {
        echo 'Error: ' . $e->getMessage();
}


}
}
}

