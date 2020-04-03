<?php
//$mysqldate = $argv[1];
$search = $argv[1];
$mysqldate  = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$mysqldate = str_replace("-", "_", $mysqldate);

ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);

$file_folder_name = "/var/www/html/json/".$mysqldate;
mkdir($file_folder_name, 0777);
chmod($file_folder_name, 0777);
//print_r($test);
$file_folder_name_search = "/var/www/html/json/".$mysqldate."/".$search.".json";
//$lfhandler = fopen($file_folder_name_search, "w");
//fwrite($lfhandler, $json);
//fclose ($lfhandler);

//	$file_folder_name_search = "/home/reterik/Automatic-Question-Generator/AutomaticQuestionGenerator/DB/db.txt";
//	$lfhandler = fopen($file_folder_name_search, "w");
//	fwrite($lfhandler, $conCats);
//	fclose ($lfhandler);

//	system("sudo python3 -m allennlp.run predict https://s3-us-west-2.amazonaws.com/allennlp/models/fine-grained-ner-model-elmo-2018.12.21.tar.gz '".$file_folder_name_search."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");
	system("sudo python3 -m allennlp.run predict https://s3-us-west-2.amazonaws.com/allennlp/models/bidaf-model-2017.09.15-charpad.tar.gz '".$file_folder_name_search."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");
//	system("sudo python3 run.py predict /home/reterik/model4/model.tar.gz '".$file_folder_name_search."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");
//	system("sudo python3 -m allennlp.run predict tmp5ek6hjly '".$cat."' | grep -o -P '.{0,0}best_span_str.{0,1000}' | sed 's/\", \"/ /g' | sed 's/,/ /g' | sed 's/passage_tokens.*//g' | sed 's/:/,/g' | sed 's/question_tokens//g' | sed 's/best_span_str\"//g' >> '".$file_folder_name_search.".txt'");

?>
