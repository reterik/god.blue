<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require('shared.php');

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

// Prepare some keys for our example


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



//include('/var/www/html/db.php');
//$conn = db_connect_scraper_100();
function namefile()
{ 
    return time() ."_". substr(md5(microtime()), 0, mt_rand(10, 10));
}
$file = file_get_contents("/var/www/html/predis/examples/rss_xml.csv");

preg_match_all('!(http)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $file, $match);
//print_r($match);
$match1 = array();
$match1 = array_unique($match);
foreach($match1[0] as $value2) {
$value2 = str_replace("%%", "", $value2);
$value2 = urldecode($value2);
$value2 = str_replace("%", "", $value2);

echo $value2;
$mystring = $value2;
$findme   = 'feedproxy';
$pos = strpos($mystring, $findme);
$findme   = 'feedproxy';  
$pos1 = strpos($mystring, $findme);
$findme   = 'feedproxy';  
$pos2 = strpos($mystring, $findme);
$pos = true;
if (($pos === true) or ($pos1 === true) or ($pos2 === true)) {
//        echo $value2;
    $client->set($value2, $value2); 
}
else
{
}
}
/*
$delimiter = "\n";
$splitcontents = explode($delimiter, $file);
//print_r($splitcontents);
$i = 0;
foreach($splitcontents as $val) {
$i = $i + 1;
$client->set($i, $val); 
$value = $client->get($i);
}
*/

?>
