<?php
class dailytimerecord extends MVC_controller{
	private $s = false;
	private $res = array();
	private $fr;
	private $to;
	private $c_off;
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}
	
	public function index(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		if(isset($_POST['s-dtr'])){
		//$month = array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
		$s = array('07',23);
		$e = array(24,'08');
		 $year = $_POST['yr'];
		 $coff = $_POST['c_off'];
		$c = explode('-',$coff);
		
		$start_date = $e[$c[1]];
		$start_month = $c[0];
		$end_month = ($e[$c[1]]==24)? $c[0] + 1 : $c[0];
		$end_month =  ($end_month==13) ? '01' : $end_month;

		$end_date = $s[$c[1]];
		$from = r_string($year."-".$start_month."-".$start_date);
		$year = ($start_month==12 && $start_date==24) ? $year + 1 : $year;
		$to = r_string($year."-".$end_month."-".$end_date);
		$query = "from search";
		$query = 'SELECT e.id, e.lastname,e.firstname,e.mid_name,d.p_status,d._in,d._out,d.date FROM dtr as d, employees as e WHERE (d._out!=\'00:00:00\' OR isOut=1) AND e.id=d.emp_id AND  date BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY date';
		$data['title'] = $from." to ".$to;
		$this->c_off = $from."/".$to;
		$data['i'] = $coff;
		}
		
		$cur_date = date('d');
		$cur_month = date('m');
		$year = date('Y');
		
		$fr = r_string($year."-".$cur_month."-24");
		$tto = r_string($year."-".(date('m')+1)."-07");
		$prev_month = $year."-".(date('m')-1)."-24";
		$curr_month = $year."-".$cur_month."-07";
		$curr_month2 = $year."-".$cur_month."-08";
		$curr_month3 = $year."-".$cur_month."-23";
		
		
		if($cur_date<=7){
			$s = '"'.$prev_month.'" AND "'.$curr_month.'"';
			
			}else{
			$s = '"'.$curr_month2.'" AND "'.$curr_month3.'"';
			
		}
		
		$data['fora'] =$this->c_off;
		$q = 'current';
		$q = 'SELECT e.id, e.lastname,e.firstname,e.mid_name,d.p_status,d._in,d._out,d.date FROM dtr as d, employees as e WHERE (d._out!=\'00:00:00\' OR isOut=1) AND e.id=d.emp_id AND date BETWEEN '.$s.' ORDER BY date';
		
		$query = (empty($query)) ? $q:$query;
		$data['dtr'] = $this->crud->read($query);

//$to_time = strtotime("2008-12-13 10:00:00");
//$from_time = strtotime("2008-12-13 12:00:00");
//$diff = $from_time - $to_time;
//echo round($diff/(60*60), 0, PHP_ROUND_HALF_DOWN). " hours<br />";
//echo round(abs($to_time - $from_time)/60,2). " minute";






		
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/dtr_',$data);
		$this->load->render('common/footer_',$data);
	}


	public function summary(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	
		if(isset($_POST['smry'])){

		 $data['fora'] = $d = r_string($_POST['dte']);
		$this->sumIt($d);
			foreach ($this->e as $key => $value) {
					$id =  $value[0]['id'];
					$query = "SELECT salary FROM employees WHERE id=:id";
					$res = $this->crud->read($query,array('id'=>$id));
					$basic = $res[0]['salary'];
					//rates
					$rphr = getRate($basic,'perhour');
					$rpmin = getRate($basic,'permin');
					
					//hours and mins by present
					$x = explode(':',$value[0]['total_hours']);
					$perhr = $x[0] * $rphr;
					$permin = $x[1] * $rpmin;

					//hours and mins by absent
					$y = explode(':',$value[0]['total_lates']);
					$aperhr = $y[0] * $rphr;
					$apermin = $y[1] * $rpmin;
					
					$total_abs =  round($aperhr + $apermin,2);
					$total =  round($perhr + $permin,2);
					$this->e[$id][0]['c_off'] = $d;
					$this->e[$id][0]['basic'] = number_format($basic);
					$this->e[$id][0]['absent'] = number_format($total_abs,2);
					$this->e[$id][0]['total'] = number_format($total,2);

				}


		$data['emp'] = $this->e;
	
		$data['d'] = $this->from." to ".$this->to;
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/dtrsummary_',$data);
		$this->load->render('common/footer_');
		}


		if(isset($_POST['submitpayroll'])){
		$d =  $_POST['sdte'];

			$this->sumIt($_POST['sdte']);
			foreach ($this->e as $key => $value) {

				$id =  $value[0]['id'];
					$query = "SELECT salary FROM employees WHERE id=:id";
					$res = $this->crud->read($query,array('id'=>$id));
					$basic = $res[0]['salary'];
					//rates
					$rphr = getRate($basic,'perhour');
					$rpmin = getRate($basic,'permin');
					
					//hours and mins by present
					$x = explode(':',$value[0]['total_hours']);
					$perhr = $x[0] * $rphr;
					$permin = $x[1] * $rpmin;

					//hours and mins by absent
					$y = explode(':',$value[0]['total_lates']);
					$aperhr = $y[0] * $rphr;
					$apermin = $y[1] * $rpmin;

					$total_abs =  round($aperhr + $apermin,2);
					$total =  round($perhr + $permin,2);
			
				$q = $this->crud->create('payroll',array(
					'emp_id'=>$value[0]['id'],
					'emp_name'=>$value[0]['fname'],
					'c_off'=>$d,
					'basic'=>number_format($basic),
					'total_lates'=>$value[0]['total_lates'],
					'absencesnlates'=>number_format($total_abs,2),
					'total_hours'=>$value[0]['total_hours'],
					'netpay'=>number_format($total,2)));


			}
		$z = explode('/', $d);
		$q = $this->db->prepare("UPDATE dtr SET p_status=1 WHERE date BETWEEN :fr AND :to");
		$res = $q->execute(array(':fr'=>$z[0],':to'=>$z[1]));
		$data['payrollsuccess'] = "<div class='success'>Payroll was successfully submited.</div>";

		$data['emp'] = $this->e;
		$data['d'] = $this->from." to ".$this->to;
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/pay_success',$data);
		$this->load->render('common/footer_');
		}		
	}

	private function sumIt($date){
		$dte = explode('/',$date);
		$this->from  = r_string($dte[0]);
		$this->to  = r_string($dte[1]);
		$query = 'SELECT DISTINCT e.id,e.firstname,e.lastname FROM employees as e, dtr as d WHERE e.id=d.emp_id';
		$ep = $this->crud->read($query);
		//get total lates later..code here
		$emps = array();
		$ctr = 0;
		foreach($ep as $key){
		$total_hours = $this->compute->total_hours($key['id'],$this->from,$this->to);
		$b = $this->compute->get_total_hours($key['id'],$this->from,$this->to);
		$this->e[$key['id']] = array();
			$add = array(
						'id'=>$key['id'],
						'total_hours'=>$total_hours,
						'total_lates'=>$b,
						'fname'=>$key['firstname']." ".$key['lastname']
						);
			array_push($this->e[$key['id']],$add);
		}
	}
	
}