<?php
set_time_limit(0);
ini_set("pcre.recursion_limit", "524");
$amz = "https://commoncrawl.s3.amazonaws.com/";
include('/var/www/db.php');
$conn = db_connect_100();
$i = 0;

do {
    $i++;

$query = "SELECT `url`, `count` FROM `scraper`.`commoncrawl` WHERE `check_url` = 'NULL' limit 1;";

if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $count);
    while (mysqli_stmt_fetch($stmt)) {
echo $count;
echo $name;
    }
    mysqli_stmt_close($stmt);
}
$query = "UPDATE `scraper`.`commoncrawl` SET `check_url` = 'Y' WHERE `commoncrawl`.`count` = '".$count."';";
if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
$file = substr(strrchr($name,'/'),1);
$warcurl = $amz.$name;
echo $warcurl;
$wget = "wget ".$warcurl;
echo $wget;
system($wget);
$gunzip = "gunzip ";
$gunzipcommand = $gunzip.$file;
echo $gunzipcommand;
system($gunzipcommand);
$file_name = str_replace(".gz", "", $file);
$file_name_mv = "cat ".$file_name." | grep rss >> xml3.txt";
system($file_name_mv);

system("rm ".$file_name);

//# Search for relative path documents
//$split = "split file.txt -d -b 100M parts";
//system($split);
$page_contents = "";
} while ($i < 303)

?>
