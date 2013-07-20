<?php

	require('moonphase.inc.php');
	define ('do_phase', do_phase);
	
	class calc_phase 
	{
		
		private $date;
		private $method;
				
	    function __construct() {
		
		
			if (isset($_POST['date']))
				$this->date = $_POST['date'];	
			
			
			if (isset($_POST['method']))
				$this->method = $_POST['method'];	
			
			if (isset($_POST['method']))
			switch ($this->method) {
				case do_phase:
					$this->do_phase();  
				break;
				
				break;
				default:
					throw new Exception('Invalid REQUEST_METHOD');
					break;
			}
			
		}
		
		
		function do_phase()
		{			
			$date = strtotime($this->date);
			$today = date('Y-m-d', $date);
			$date = $today;
			$time = "00:00:00";
			$tzone = "PST";		
			 
			$data = $this->calc_phase( $date, $time, $tzone );			
			echo json_encode($data);				
		}
		
		
		function calc_phase( $date, $time, $tzone )  
		{
			$moondata = phase(strtotime($date . ' ' . $time . ' ' . $tzone));

			$MoonPhase	= $moondata[0];
			$MoonIllum	= $moondata[1];
			$MoonAge	= $moondata[2];
			$MoonDist	= $moondata[3];
			$MoonAng	= $moondata[4];
			$SunDist	= $moondata[5];
			$SunAng		= $moondata[6];

			$phase = 'Waxing';
			if ( $MoonAge > SYNMONTH/2 )  {
				$phase = 'Waning';
			}

			// Convert $MoonIllum to percent and round to whole percent.
			$MoonIllum = round( $MoonIllum, 2 );
			$MoonIllum *= 100;
			
			if ( $MoonIllum == 0 )  {
				$phase = "New Moon";
			}
			if ( $MoonIllum == 100 )  {
				$phase = "Full Moon";
			}
			$data = array("phase"=>"$phase", "percent"=>"$MoonIllum");
			
			return $data;
		}

						
	}
		
	$calc_phase = new calc_phase();
						
?>
