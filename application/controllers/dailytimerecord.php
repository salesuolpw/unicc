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
		$s = array(7,23);
		$e = array(24,8);
		$year = $_POST['yr'];
		$coff = $_POST['c_off'];
		$c = explode('-',$coff);
	
		$start_date = $e[$c[1]];
		$start_month = $c[0];
		$end_month = ($e[$c[1]]==24)?$c[0] + 1 : $c[0];
		$end_date = $s[$c[1]];
		$from = r_string($year."-".$start_month."-".$start_date);
		$to = r_string($year."-".$end_month."-".$end_date);
		$query = "from search";
		$query = 'SELECT e.id, e.lastname,e.firstname,e.mid_name,d.in,d.out,d.date FROM dtr as d, employees as e WHERE e.id=d.emp_id AND date BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY date';
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
		$q = 'SELECT e.id, e.lastname,e.firstname,e.mid_name,d.in,d.out,d.date FROM dtr as d, employees as e WHERE e.id=d.emp_id AND date BETWEEN '.$s.' ORDER BY date';
		
		$query = (empty($query)) ? $q:$query;
		$data['dtr'] = $this->crud->read($query);
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/dtr_',$data);
		$this->load->render('common/footer_',$data);
	}


	public function summary(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	
		if(isset($_POST['smry'])){

		$data['fora'] = $d = r_string($_POST['dte']);
		$this->sumIt($d);
		//print_r($e);
		$data['emp'] = $this->e;
		$data['d'] = $this->from." to ".$this->to;
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/dtrsummary_',$data);
		$this->load->render('common/footer_');
		}


		if(isset($_POST['submitpayroll'])){
			//echo $_POST['sdte'];
				$this->sumIt($_POST['sdte']);

				print_r($this->e);
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
			 
		$a = $this->compute->lates($key['id'],$this->from,$this->to);
		$b = $this->compute->get_total_hours($key['id'],$this->from,$this->to);
			$this->e[$key['id']] = array();
			$add = array(
						'id'=>$key['id'],
						'lates'=>$a['hours'].":".$a['minutes'],
						'totalhours'=>$b,
						'fname'=>$key['firstname']." ".$key['lastname']
						);
			array_push($this->e[$key['id']],$add);
		}
	}
	
}