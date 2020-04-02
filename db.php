<?php

function db_connect_100()
{
   $result = new mysqli('localhost', 'root', '', 'scraper'); 
   if (!$result) 
     throw new Exception('Could not connect to database server');
   else
     return $result;
}

?>
