<?php
if(isset($_GET['date'])){
$today = strip_tags(stripslashes($_GET['date']));
}
else
{
 $today = date('Y-m-d');
}
if(isset($_GET['date1'])){
$today1 = strip_tags(stripslashes($_GET['date1']));
}
else
{
 $today1 = date('Y-m-d');
}
echo "<input type='text' name='date' value='".$today."'>";
?>
  <input type="submit" value="Submit">
</form><br>
<table class="alternate_color">
<?php
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);

include('/var/www/html/db.php');
$conn = db_connect_scraper_100();
$conn1 = db_connect_100();

$search = "";

$i = 0;
$c = 10;

function strip_html_tags($str){
    $str = preg_replace(
        array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            ),
        "", //replace above with nothing
        $str );
    return $str;
}

if(isset($_GET['search'])){
$search = strip_tags(stripslashes($_GET['search']));
}
else
{
$search = 'artifical intelligence';
}
if(isset($_GET['page'])){
$page = strip_tags(stripslashes($_GET['page']));
$c = $page + c;
}
if(isset($_GET['date'])){
$today = strip_tags(stripslashes($_GET['date']));
}
else
{
 $today = date('Y-m-d');
}

        $query1 = "SELECT DISTINCT `url` FROM `scraper`.`html_url` WHERE `html_url`.`url` LIKE '%".$search."%';";
//echo $query1;
        if ($stmt1 = mysqli_prepare($conn1, $query1)) {
                        mysqli_stmt_execute($stmt1);
                mysqli_stmt_bind_result($stmt1, $url);
                while (mysqli_stmt_fetch($stmt1)) {
                
//$body = preg_replace("/<script\b[^>]*>(.*?)<\/script>/is", "", $body);

echo $url;


if($counter < 1) {

}
else
{
echo "<tr><td style='font-size:16px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$title."&nbsp;&nbsp;&nbsp;<a href='".$key."'>Link</a></td></tr>";
//echo "<td><textarea rows='10' cols='50'>".$body."</textarea></td>";
// Displays 3 and 10
echo "<tr><td>";

echo "</td></tr>";
}
//echo $i;
                }
                mysqli_stmt_close($stmt1);
        }      
       


?>
</table>
</body>
</html>

