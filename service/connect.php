﻿<?php		$db_host = "localhost"; // Database Host         $db_user = "root"; // Database User         $db_password = "root"; // Database password         $db_name = "lunar"; // Database name         $connection = @mysql_connect($db_host, $db_user, $db_password) or die("Fatal MySQL Error");        mysql_select_db($db_name);   		mysql_query("SET NAMES UTF8");		?>