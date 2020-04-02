<?php
require("/var/www/db.php");
$conn = db_connect_100();

$file = file_get_contents("cc-index.paths");
$delimiter = "\n";
$splitcontents = explode($delimiter, $file);
//print_r($splitcontents);
foreach($splitcontents as $val) {
    $result = $val;
    $title = "NULL";
    if ($stmt = mysqli_prepare($conn, "INSERT IGNORE INTO `scraper`.`commoncrawl` (`url`, `check_url`) VALUES (?,?)")); {
        mysqli_stmt_bind_param($stmt, "ss", $result, $title);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        }
}
?>
