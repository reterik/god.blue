<?php
require('shared.php');

//use Predis\Collection\Iterator;

//$client = new Predis\Client($single_server1, array('profile' => '2.8'));

/*
function fetchUrl($uri) {
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $uri);
    curl_setopt($handle, CURLOPT_POST, false);
    curl_setopt($handle, CURLOPT_BINARYTRANSFER, false);
    curl_setopt($handle, CURLOPT_HEADER, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
    $response = curl_exec($handle);
    $hlength  = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    $body     = substr($response, $hlength);
    // If HTTP response is not 200, throw exception
    return $body;
}
*/


include('/var/www/db.php');
$conn = db_connect_100();
function namefile()
{ 
    return time() ."_". substr(md5(microtime()), 0, mt_rand(10, 10));
}
$i = 0;
do {
        if($i <= 9) {
        $s = "0".$i;
        }
        if($i == 0) {
        $s = "0".$i;
        }
	$i++;

        $file = file_get_contents("/var/lib/mysql-files/parts".$s);

$file = file_get_contents("/var/lib/mysql-files/rss.sql");

preg_match_all('!(http)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $file, $match);
//print_r($match);
$match1 = array();
$match1 = array_unique($match);
foreach($match1[0] as $value2) {
$value2 = str_replace("%%", "", $value2);
$value2 = urldecode($value2);
$value2 = str_replace("%", "", $value2);

$mystring = $value2;
$findme   = '.xml';
$pos = strpos($mystring, $findme);
if($pos == true) {

/*
$remoteFile = $value2;
$ch = curl_init($remoteFile);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
$data = curl_exec($ch);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);
    if ($data === false) {
      echo 'cURL failed';
//      exit;
    }
$status = 'unknown';
echo $contentType;
*/

echo $value2;

    if ($stmt1 = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`html_url` (`url`) VALUES (?)")); {
        mysqli_stmt_bind_param($stmt1, "s", $value2);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
        }

/*
if(($contentType == "application/rss+xml") || ($contentType == "application/rdf+xml") || ($contentType == "application/atom+xml") || ($contentType == "application/xml") || ($contentType == "text/xml") || ($contentType == "text/rss+xml")) {
    if ($stmt1 = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`html_url1` (`url`) VALUES (?)")); {
        mysqli_stmt_bind_param($stmt1, "s", $value2);
        mysqli_stmt_execute($stmt1);
    	mysqli_stmt_close($stmt1);
        }
}
*/
}
}
} while ($i < 50);

?>
