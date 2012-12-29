<?php
class compute extends MVC_model{
	public $salary;
	public $query;
	public function __construct(){
		parent::__construct();
	}
	
	
	//get total hour or minutes 
	public function get_total_time($by,$time){
		if(is_array($time)){
				switch($by){
					case 'min':
						foreach($time as $k){
							$t = getmins($k);
							$to = $to + $t;
						}
						break;
						default:
						if(is_array($time)){
							foreach($time as $k){
								$t = $this->gethour($k);
								$to = $to + $t;
							}
				}
			}
		return $to;
		}
	}
	
	//get total lates by hour and minutes
	public function lates($id,$fr,$to){
	$a = $this->crud->read('SELECT * FROM dtr WHERE emp_id=:id AND date BETWEEN :fr AND :t',array('id'=>$id,'fr'=>$fr,'t'=>$to));
		$sphr = 60 * 60;
		$lates = array();
		$d = array();
		foreach($a as $key){
			$dtime = str_rem(':','07:15:00');
			$utime = str_rem(':','16:00:00');
			if(str_rem(':',$key['in']) >$dtime){
					//get total minutes
					$a = getmins($key['in']);
					$mins = $mins + $a;
					$lates['minutes'] = $mins;
					
					$start = strtotime($key['date']." 07:15:00");
					$end = strtotime($key['date']." ".$key['in']);
					$dif = $end - $start;
					//hours
					$hr = round($dif/$sphr,0);
					$hour = $hour + $hr;
					$lates['hours'] = $hour;
				
			}
			
			
		}
		return $lates;
	}
	//get total hours for paticular cutoff
	public function get_total_hours($id,$fr,$to){
	$a = $this->crud->read('SELECT * FROM dtr WHERE emp_id=:id AND date BETWEEN :fr AND :t',array('id'=>$id,'fr'=>$fr,'t'=>$to));
		$sphr = 60 * 60;
		foreach($a as $key){
			$dtime = str_rem(':','07:16:00');
			//hours
			$start = strtotime($key['date']." ".$key['in']);
					$end = strtotime($key['date']." "."16:00:00");
					$dif = $end - $start;
					$hr = round($dif/$sphr,0);
					$hour = $hour + $hr;
			
			
		}
		return $hour;
	}
	//get pay per day  basic * 12 / 365 = per day
	public function payperday($id){
	$a = $this->crud->read('SELECT salary FROM employees WHERE id=:id',array('id'=>$id));
	return $this->salary = round(($a[0]['salary'] * 12)/365 , 2);
	}
	//per hour basis
	public function perhour(){
		return round($this->salary / 8, 2);
	}
	//per minutes
	public function perminute(){
		return round($this->perhour()/60, 2);
	
		}
	
	public function gross_pay($var){
		return $total_hour = $this->get_total_hours($var);
		
	}
	

	
}