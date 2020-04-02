<?php 
//error_reporting(0); //max_execution_time=300; 
@ini_set('max_execution_time', 60); 

include('/var/www/db.php');
$conn = db_connect_100();
//$conn1 = db_connect_100();

$num = 0;

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

function object2array($object)
{
    $return = NULL;
      
    if(is_array($object))
    {
        foreach($object as $key => $value)
            $return[$key] = object2array($value);
    }
    else
    {
        $var = get_object_vars($object);
          
        if($var)
        {
            foreach($var as $key => $value)
                $return[$key] = ($key && !$value) ? NULL : object2array($value);
        }
        else return $object;
    }

    return $return;
} 


foreach($_POST as $post){
	echo $post;
	$title = $post;
	$description = $post;
$count = namefile();
$link = "https://god.blue/post/".$count;
$num = 1;
$mysqldate = date("Y-m-d");
$mysqldater = str_replace("-", "_", $mysqldate);

$sqler = "INSERT IGNORE INTO `scraper`.`".$mysqldater."_blog` (`url`, `title`, `timestamp`, `description`, `checked`) VALUES (?,?,?,?,?)";
//echo $sqler;
                if ($stmt1 = mysqli_prepare($conn, $sqler)); {
                        mysqli_stmt_bind_param($stmt1, "sssss", $link, $title, $mysqldate, $description, $count);
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_close($stmt1);
		}
}
?>
