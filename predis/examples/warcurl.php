<?php
set_time_limit(0);
ini_set("pcre.recursion_limit", "524");
$amz = "https://commoncrawl.s3.amazonaws.com/";
include('/var/www/db.php');
$conn = db_connect_100();

$ar = $argv[1];

$page_contents = "";
$i = 0;
do {
    $i++;
	if($i <= 9) {
	$i = "0".$i;
	}
	$page_contents = file_get_contents($ar);

//echo $page_contents;
//$regex_2 = "/[a-zA-Z0-9_-]*\/*[a-zA-Z0-9_-]+\.pdf/";
//$regex_2 = '/http[^\s]+\//';
preg_match_all('!(http)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $page_contents, $match);
//preg_match_all($regex_2, $page_contents, $match);
//print_r($match);
$match = array_unique($match);
foreach($match[0] as $value2) {
	$value2 = str_replace("%%", "", $value2);
        $value2 = urldecode($value2);
        $value2 = str_replace("%", "", $value2);
    $result = $value2;
    $title = $value2;
    $keyurl = substr($value2, 0, 200);
    $host = "";
    $search_string = "";
    $mysqltime = "";
	//echo $result;

$mystring = $result;
 

    if ($stmt = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`html_url` (`url`) VALUES (?)")); {
        mysqli_stmt_bind_param($stmt, "s",$result);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        }

/*
    if ($stmt = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`results` (`urlcounter`, `title`, `url`, `host`, `seoterm`, `date`) VALUES (?,?,?,?,?,?)")); {
        mysqli_stmt_bind_param($stmt, "ssssss", $keyurl, $title, $result, $host, $search_string, $mysqltime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        }
*/

//if($result != "s" || $result != "" || $result != "http") {
//		if ($stmt = mysqli_prepare($conn, "INSERT INTO `scraper`.`html_url` (`url`) VALUES (?)")); {
//			mysqli_stmt_bind_param($stmt, "s", $result);
//			mysqli_stmt_execute($stmt);
//			mysqli_stmt_close($stmt);
//			echo $result;
//		}
//	}

}
} while ($i < 1);
mysqli_close($conn);
?>
