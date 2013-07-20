<?php

 //
 // File: moonphase.php
 //     Sample code for using moonphase.inc.php
 //	http://www.sentry.net/~obsid/moonphase
 //

 require( 'moonphase.inc.php' );

 // phasehunt() Example
 print "Example: phasehunt()<br/>";
 do_phasehunt();
 print "<br/><br/>";


 // phaselist() Example
 print "Example: phaselist()<br/>";
 $today = '2013-01-01';//date("Y-m-d 00:00:00 PST");
 $start = strtotime($today);
 $stop = strtotime($today)+60*60*24*365;
 do_phaselist( $start, $stop );
 print "<br/><br/>";


 // phase() Example
 $date = $today;
 $time = "00:00:00";
 $tzone = "PST";
 print "Example: phase() ($date $time $tzone)\n";
 do_phase( $date, $time, $tzone );
 print "<br/><br/>";



 // phasehunt() Example
 function do_phasehunt()  {
	$phases = array();
	$phases = phasehunt();
	print date("D M j G:i:s T Y", $phases[0]) . "<br/>";
	print date("D M j G:i:s T Y", $phases[1]) . "<br/>";
	print date("D M j G:i:s T Y", $phases[2]) . "<br/>";
	print date("D M j G:i:s T Y", $phases[3]) . "<br/>";
	print date("D M j G:i:s T Y", $phases[4]) . "<br/>";
 }



 // phaselist() Example
 function do_phaselist( $start, $stop )  {
	$name = array ( "New Moon", "First quarter", "Full moon", "Last quarter" );
	$times = phaselist( $start, $stop );

	foreach ( $times as $time )  {

		// First element is the starting phase (see $name).
		if ( $time == $times[0] )  {
			print $name["$times[0]"] . "<br/>";
		}
		else  {
			print date("D M j G:i:s T Y", $time) . "<br/>";
		}
	}
 }



 // phase() Example
 function do_phase ( $date, $time, $tzone )  {
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

	print "Moon Phase: $phase<br/>";
	print "Percent Illuminated: $MoonIllum%<br/>";
 }



?>
