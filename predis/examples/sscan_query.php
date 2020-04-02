<?php
//error_reporting(0);
//@ini_set('display_errors', 0);
require '/var/www/html/predis/examples/shared.php';

use Predis\Collection\Iterator;

$client2 = new Predis\Client($single_server2, array('profile' => '2.8'));


//$client2->set($json_array, $json_array); 

//$client2 = $client2->zscan(1, 0);

        //$response = $client2->sscan("key", 0);
        $response = $client2->sscan('1', '101', 'MATCH', '*:*', 'COUNT', 100);

	print_r($response);
	        print_r($client2);


?>

