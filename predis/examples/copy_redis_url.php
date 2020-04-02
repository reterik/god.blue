
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

include('/var/www/html/db.php');
$conn = db_connect_scraper_100();

$query = "SELECT `counter`, `url` FROM `scraper`.`results` WHERE `converted` IS NULL limit 1;";

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

?>
