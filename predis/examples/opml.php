<opml version="1.0"><head>
<title>Sample OPML file</title></head><body>
<?php
include('/var/www/html/db.php');
$conn = db_connect_scraper_100();
$query = "SELECT `url` FROM `scraper`.`html_url` limit 1000;";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $url);
    while (mysqli_stmt_fetch($stmt)) {
    echo "<outline title='".$url."' text='".$url."' type='rss' version='RSS' xmlUrl='".$url."' htmlUrl='".$url."'/>";
    
    }
    mysqli_stmt_close($stmt);
}
?>
</body></opml>

