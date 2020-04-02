<?php
//error_reporting(0);
//@ini_set('display_errors', 0);
require '/var/www/html/predis/examples/shared.php';

use Predis\Collection\Iterator;

$client1 = new Predis\Client($single_server1, array('profile' => '2.8'));
$client2 = new Predis\Client($single_server2, array('profile' => '2.8'));
$client3 = new Predis\Client($single_server3, array('profile' => '2.8'));

/*
$single_server1 = 'database' => 14;
$single_server2 = 'database' => 13;
$single_server3 = 'database' => 12;
*/

//include('/var/www/html/db.php');
//$conn = db_connect_100();


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
    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($handle);
    $hlength  = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    $body     = substr($response, $hlength);
    // If HTTP response is not 200, throw exception
    return $body;
}

$d = 0;
do {
$d = $d + 1;
//echo $d;
//$value = $client->get($count);
$value = $client1->executeRaw(["RANDOMKEY"]);
//var_dump($value);

//$red = "redis-cli -n 14 DEL ".$value;  
//system($red);

$date = date("Y-m-d");
//$url = "/home/rss/".$date."/".$value."/".$value;
//echo $url;
$url = $value;
$rss = simplexml_load_file($url);
if($rss) {
        //echo '<h1>'.$rss->channel->title.'</h1>';
        //echo '<li>'.$rss->channel->pubDate.'</li>';
        $items = $rss->channel->item;
        foreach($items as $item) {
                $title = $item->title;
                $link = $item->link;
				if($link == ""){
				$link = $item->guid;
				}
                $description = $item->description;
                                if($description == ""){
                                $description = "none";
                                }
				$mysqldate = date("Y-m-d");
$count = namefile();


//$value1 = $client2->executeRaw(["RANDOMKEY"]);

$redistime = date("Y-m-d H:i:s");

$multi = array(
"count" => $count,
"link" => $link,
"title" => $title,
"date" => $redistime,
"description" => $description,
);
//print_r($multi);
$json_array = json_encode($multi);
//$client2->set($json_array, $json_array); 
//	$client2->set($json_array, $json_array)
	//$client3->set($count, $count);
        //$set = $client2->sadd($json_array, $members = $json_array);
        //$set = $client2->sadd($json_array);
	//$response = $client2->sscan($json_array, 0);

//        $set = $client2->hmset($json_array);

	//$client2->sadd($redistime, $json_array, $members = $json_array);

//$red = "redis-cli -n 13 SADD ".$redistime." "Hello"

$red = "redis-cli -n 12 SADD ".$redistime." '".$json_array."'";
system($red);

/*
		if ($stmt = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`rss_xml_1` (`url`, `title`, `timestamp`, `description`, `checked`) VALUES (?,?,?,?,?)")); {
                        mysqli_stmt_bind_param($stmt, "sssss", $link, $title, $mysqldate, $description, $count);
                        mysqli_stmt_execute($stmt);
//			mysqli_stmt_store_result($stmt);
//			$num =mysqli_stmt_affected_rows($stmt);
			mysqli_stmt_close($stmt);

/*
if($num > 0){
$file_folder_name = "/home/html/".$date;
mkdir($file_folder_name, 0777);
chmod($file_folder_name, 0777);
$destination_file = "/home/html/".$date."/".$count;
mkdir($destination_file, 0777);
chmod($destination_file, 0777);
$destination_file = "/home/html/".$date."/".$count."/".$count;
$lfhandler = fopen($destination_file, "w");
$filepage = fetchUrl($link);
fwrite($lfhandler, $filepage);
fclose ($lfhandler);
echo $count;
}

                }
*/
        }
}
}  while ($d < 100);

?>

