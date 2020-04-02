<?php
$search_input = strip_tags(stripslashes($_GET['doc']));
$search = preg_replace('/[^A-Za-z\.]/', '', $search_input);
$red = "redis-cli -n 13 SSCAN myset 0 MATCH *".$search."* COUNT 1000";
system($red);
?>
