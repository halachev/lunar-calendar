<?php
   
	include "connect.php";

	define ('moons', moons);
	define ('LoadMoonPhase', LoadMoonPhase);
	

	class moon 
	{
		
		private $state;
		private $method;
				
	    function __construct() {
		
			if (isset($_POST['state']))
				$this->state = $_POST['state'];		
				
			if (isset($_POST['method']))
				$this->method = $_POST['method'];
			
			if (isset($_POST['method']))
			switch ($this->method) {				
				case moons:
					$this->moons();  
				break;
				case LoadMoonPhase:
					$this->LoadMoonPhase();  
				break;
				default:
					throw new Exception('Invalid REQUEST_METHOD');
					break;
			}
			
		}
		
	
		function moons()
		{
		
			$sql = mysql_query("select * from moons where state = '$this->state'");
			
			$data = array();
			
			while($row=mysql_fetch_array($sql))
			{
				  $data[] = $row;
			} 
						
			echo json_encode($data);
		}
		
		
		function LoadMoonPhase()
		{
			$data = array();
			$data[] = array("title" => "moon phase", "descr" => "must be implement");			
			echo json_encode($data);
		}
		
				
	}
		
	$moon = new moon();
					
	
?>


