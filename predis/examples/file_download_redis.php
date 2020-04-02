
<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/shared.php';

use Predis\Collection\Iterator;

// Starting from Redis 2.8, clients can iterate incrementally over collections
// without blocking the server like it happens when a command such as KEYS is
// executed on a Redis instance storing millions of keys. These commands are:
//
//   - SCAN (iterates over the keyspace)
//   - SSCAN (iterates over members of a set)
//   - ZSCAN (iterates over members and ranks of a sorted set)
//   - HSCAN (iterates over fields and values of an hash).

// Predis provides a specialized abstraction for each command based on standard
// SPL iterators making it possible to easily consume SCAN-based iterations in
// your PHP code.
//
// See http://redis.io/commands/scan for more details.
//

// Create a client using `2.8` as a server profile (needs Redis 2.8!)
$client = new Predis\Client($single_server1, array('profile' => '2.8'));
$client1 = new Predis\Client($single_server2, array('profile' => '2.8'));


// Prepare some keys for our example

//include('db.php');
//$conn = db_connect_scraper_100();

include('/var/www/html/db.php');
$conn = db_connect_100();

function namefile()
{
    return time() ."_". substr(md5(microtime()), 0, mt_rand(10, 10));
}

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

$d = 0;
do {
$count = namefile();
$d = $d + 1;
echo $d;
//$value = $client->get($count);
$value = $client->executeRaw(["RANDOMKEY"]);
//var_dump($value);
$url = $value;

echo $url;

$date = date("Y-m-d");
$file_folder_name = "/home/remote/rss/".$date;
mkdir($file_folder_name, 0777);
chmod($file_folder_name, 0777);
$destination_file = "/home/remote/rss/".$date."/".$count;
mkdir($destination_file, 0777);
chmod($destination_file, 0777);
$destination_file = "/home/remote/rss/".$date."/".$count."/".$count;
//$curl = "curl -L ".$url." > ".$destination_file;
//system($curl);
$lfhandler = fopen($destination_file, "w");
$filepage = fetchUrl($url);
fwrite($lfhandler, $filepage);
fclose ($lfhandler);
echo $destination_file;

$rss = simplexml_load_file($destination_file);

if($rss) {
        $items = $rss->channel->item;
        foreach($items as $item) {
                $title = $item->title;
                $link = $item->link;

		$client1->set($link, $link); 

        }
}

$file_size = "";
$mysqltime = date("Y-m-d H:i:s");
$file_mime_type = "application/xml";
$file_extension = "xml";
$file_title = "";
$urlfixed = $url;
$seoterm = "";
$short_file_name = "rss";
$file_extension = "";


if ($stmt = mysqli_prepare($conn, "INSERT INTO `docunator`.`file` (`system_file_name`,`file_size`,`file_timestamp`,`file_mime_type`,`file_extension`, `file_title`, `url`, `seoterm`, `short_name`) VALUES (?,?,?,?,?,?,?,?,?)")); {
mysqli_stmt_bind_param($stmt, "sssssssss", $count, $file_size, $mysqltime, $file_mime_type, $file_extension, $file_title, $urlfixed, $seoterm, $short_file_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
}


}  while ($d < 80000);
/*
$query = "SELECT `counter`, `url` FROM `scraper`.`html_url` WHERE `counter` = '".$rand."' `checked` IS NULL limit 1;";

if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count, $url);
    while (mysqli_stmt_fetch($stmt)) {
$client->set($count, $url); 
$value = $client->get($count);
//var_dump($value);
print_r($value);
    }
    mysqli_stmt_close($stmt);
}
*/

?>
