<?php

require('shared.php');

include('/var/www/html/db.php');
$conn = db_connect_100();

use Predis\Collection\Iterator;

$client = new Predis\Client($single_server1, array('profile' => '2.8'));

$date = date("Y-m-d");

// Prepare some keys for our example

//$red = "redis-cli -n 14 flushdb";
//system($red);

//$rm = "rm /home/rss/".$date."/output.txt";
//system($rm);

//$ls = "ls -1 -f /home/rss/".$date." > /home/rss/".$date."/output.txt" ;
//$file = system($ls);
$file = file_get_contents("/var/lib/mysql-files/export2.csv");
$delimiter = "\n";
$splitcontents = explode($delimiter, $file);
//print_r($splitcontents);
foreach($splitcontents as $val) {
//    $client->set($val, $val); 

    if ($stmt1 = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`html_url1` (`url`) VALUES (?)")); {
        mysqli_stmt_bind_param($stmt1, "s", $val);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
        }

}

?>

