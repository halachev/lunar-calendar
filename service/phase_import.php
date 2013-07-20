<?php
	ini_set("display_errors", true);
	error_reporting(E_ALL | E_STRICT);
	
	include "connect.php";
	$fp = fopen("phase.csv", "r");

	while( !feof($fp) ) {
	  if( !$line = fgetcsv($fp, 1000, ';', '"')) {
		 continue;
	  }

		
		$title = mysql_escape_string($line[1]);
		$date = strtotime($line[2]);
		$date = date('y.m.d H:i:s', $date);
		
		$importSQL = "INSERT INTO phases (title, date)  
			VALUES('".$title."', '".$date."')";
		mysql_query($importSQL) or die(mysql_error());  

	}

	fclose($fp);
	
	echo "successful import";
?>