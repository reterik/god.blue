<?php
if(isset($_GET['search'])){
$search = strip_tags(stripslashes($_GET['search']));
}
else
{
$search = $argv[1];
}
if(isset($_GET['date'])){
$mysqldate = strip_tags(stripslashes($_GET['date']));
$mysqldater = strip_tags(stripslashes($_GET['date']));
$mysqldate = str_replace("-", "_", $mysqldate);
}
else
{
$mysqldate = date('Y-m-d');
$mysqldate = str_replace("-", "_", $mysqldate);
}

if(isset($_GET['page'])){
$page = strip_tags(stripslashes($_GET['page']));
}
else
{
$page = 0;
}
//$mysqldate = $argv[1];
$search = $argv[1];
$mysqldate  = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$mysqldate = str_replace("-", "_", $mysqldate);

ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);
include('/var/www/db.php');
$conn = db_connect_100();
//error_reporting(0);
//$search = "machine learning";
//$mysqldate = "2019_09_25";
$json = "";
$description = "";
$title = "";
$total = file_get_contents("/var/lib/mysql-files/2019_09_30.sql");
//echo $total;
$sys = "python3 /home/reterik/Automatic-Question-Generator/AutomaticQuestionGenerator/main.py inputText \"".$total."\"";
echo $sys;
$out = shell_exec($sys);

echo $out;

/*
$pattern = "/^.*\?$/";
$match = preg_match($pattern, $out);
echo $match;
*/
//$test = preg_match_all('/(Q-.*\?$)/', $out, $match);
$test = preg_match_all('/(?J)(?<match>:)|(.*)|(?<match>\?)/', $out, $match);
foreach($match as $matches => $value) {
	foreach($value as $val) {
		$strings = strpos($val, "Q-");
	//	echo $strings;
		if(strpos($val, "Q-") !== false) {
	//		echo $val;
			$json .= "{\"passage\": \"".$total."\", \"question\": \"".$val."\"}\r"; 
		}
	}
}
$file_folder_name = "/var/www/html/jsons/".$mysqldate;
mkdir($file_folder_name, 0777);
chmod($file_folder_name, 0777);
//print_r($test);
$file_folder_name_search = "/var/www/html/jsons/".$mysqldate."/".$search.".json";
$lfhandler = fopen($file_folder_name_search, "w");
fwrite($lfhandler, $json);
fclose ($lfhandler);

//	$file_folder_name_search = "/home/reterik/Automatic-Question-Generator/AutomaticQuestionGenerator/DB/db.txt";
//	$lfhandler = fopen($file_folder_name_search, "w");
//	fwrite($lfhandler, $conCats);
//	fclose ($lfhandler);



//	system("sudo python3 -m allennlp.run predict https://s3-us-west-2.amazonaws.com/allennlp/models/bidaf-model-2017.09.15-charpad.tar.gz '".$file_folder_name_search."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");
//	system("sudo python3 -m allennlp.run predict tmp5ek6hjly '".$cat."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");

?>
