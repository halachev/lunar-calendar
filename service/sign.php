<?php
   
	include "connect.php";
	
	define ('Todaysign', Todaysign);
	define ('moon_without_course', moon_without_course);
	
	
	class sign 
	{
		
		private $state;
		private $date;
		private $time;
		private $method;
				
	    function __construct() {
		
			if (isset($_POST['state']))
				$this->state = $_POST['state'];		
				
			if (isset($_POST['date']))
				$this->date = $_POST['date'];

			if (isset($_POST['time']))
				$this->time = $_POST['time'];					
								
			if (isset($_POST['method']))
				$this->method = $_POST['method'];
			
			if (isset($_POST['method']))
			switch ($this->method) {
				
				case Todaysign:
					$this->Todaysign();  
				break;
				
				case moon_without_course:
					$this->moon_without_course();  
				break;
				
				break;
				default:
					throw new Exception('Invalid REQUEST_METHOD');
					break;
			}
			
		}
		
		
		function Todaysign()
		{
			$date = strtotime($this->date);
			$date = date('Ymd', $date);
			
			$time = $this->time;
						
			$sql = mysql_query("select * from signs where date(date) = '$date' and time(date) > '$time'");
			
			$total_rows = mysql_num_rows($sql); 
			
			if (!$total_rows)
				$sql = mysql_query("select * from signs where date(date) = '$date' and time(date) <= '$time'");
			
			
			$data = array();
			
			while($row=mysql_fetch_array($sql))
			{
				  $data[] = $row;
			} 
						
			echo json_encode($data);
		}
		
		
		function moon_without_course(){
		
			$date = strtotime($this->date);
			$date = date('Ymd', $date);
						
			$sql = mysql_query("select * from signs where date(date) = '$date'");
			
			$data = array();
			
			while($row = mysql_fetch_array($sql))
			{
				$data[] = $row;
			} 
						
			echo json_encode($data);
		}
		

				
	}
		
	$sign = new sign();
					
	
?>


