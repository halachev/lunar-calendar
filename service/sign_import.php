<?php
	ini_set("display_errors", true);
	error_reporting(E_ALL | E_STRICT);
	
	include "connect.php";
	$fp = fopen("file/2025-last.csv", "r");

	while( !feof($fp) ) {
	  if( !$line = fgetcsv($fp, 1000, ';', '"')) {
		 continue;
	  }

		
		$date = strtotime($line[1]);
		$date = date('y.m.d H:i:s', $date);
		
		$degree = mysql_escape_string($line[2]);
		$zodiac = mysql_escape_string($line[3]);
		$short_text = mysql_escape_string($line[4]);
					
		$importSQL = "INSERT INTO signs (date, degree, zodiac, short_text)  
			VALUES('".$date."', '".$degree."' ,'".$zodiac."', '".$short_text."')";
		mysql_query($importSQL) or die(mysql_error());  

	}

	fclose($fp);
	
	echo "successful import";
?>