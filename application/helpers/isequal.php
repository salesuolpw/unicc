<?php

function isequal($frdb,$sval){
		if($frdb==$sval){
			return 'selected="selected"';
		}else{
			return false;
		}
}

function str_rem($del,$subject){
	return str_replace($del,"",$subject);
}


function get_hm($in,$date){
		$tin = str_rem(':',$in);
		$span = str_rem(':','07:15:00');
		$sphr = 60 * 60;
		if($tin <$span){
			return "---";
		}else{
			$a = getmins($in);
			$mins = $mins + $a;
			$lates['mins'] = $mins;
				
				$start = strtotime($date." 07:15:00");
					$end = strtotime($date." ".$in);
					$dif = $end - $start;
					//hours
					$hr = round($dif/$sphr,0);
					$hour = $hour + $hr;
					$lates['hours'] = $hour;
		}
		return $lates['hours'].":".$lates['mins'];
	}

function udr_time($out,$date){
		$sphr = 60 * 60;
		$utime = str_rem(':','16:00:00');
		$cn = str_rem(':',$out);
		
		if($out < $utime){
					
					$a =  60 - getmins($out) ;
					$mins = $mins + $a;
					
					
					
					//hours
					$start = strtotime($date." ".$out);
					$end = strtotime($date." 16:00:00");
					$dif = $end - $start;
					
					
					
					$hr = round($dif/$sphr,0);
					$hour = $hour + ($hr - 1);
					return $hour.":".$mins;
		}else{
			return "-";
		}
			
}
	
//get minutes of time
function getmins($time){
		$time = explode(':',$time);
		return $time[1];
}
	
//get hour
function gethour($time){
	$time = explode(':',$time);
	return $time[0];
}

function selected($i,$e){
	if(empty($i)){
	$i = 00;
	}
	return ($i==$e) ? "selected=selected" : null;
}

