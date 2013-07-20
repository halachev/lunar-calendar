<?php
   
	include "connect.php";
	
	define ('intiPhase', intiPhase);
	
	class phase 
	{
		
		private $date;
		private $time;
		private $method;
				
	    function __construct() {
		
					
				
			if (isset($_POST['date']))
				$this->date = $_POST['date'];

			if (isset($_POST['time']))
				$this->time = $_POST['time'];					
								
			if (isset($_POST['method']))
				$this->method = $_POST['method'];
			
			if (isset($_POST['method']))
			switch ($this->method) {
				case intiPhase:
					$this->intiPhase();  
				break;
				
				break;
				default:
					throw new Exception('Invalid REQUEST_METHOD');
					break;
			}
			
		}
		
		
		function intiPhase()
		{
			
			$date = strtotime($this->date);
			$year = date('Y', $date);
			$month = date('m', $date);
						
			$sql = mysql_query("select * from phases where year(date) = '$year' and month(date) = '$month'");
							
			$data = array();
			
			while($row=mysql_fetch_array($sql))
			{				 
				  $data[] = $row;
			} 
			
						
			echo json_encode($data);
		}
						
	}
		
	$phase = new phase();
					
	
?>


