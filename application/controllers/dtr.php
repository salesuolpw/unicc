<?php
class dtr extends MVC_controller{
	private $s = false;
	public function __construct(){
		parent::__construct();

	}
	
	public function index(){
			echo 1;
	}

	public function summary(){
		if($_POST['smry']){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$d = r_string($_POST['dte']);
		$dte = explode('/',$d);
		$from  = r_string($dte[0]);
		$to  = r_string($dte[1]);
		$query = 'SELECT DISTINCT e.id,e.firstname,e.lastname FROM employees as e, dtr as d WHERE e.id=d.emp_id';
		$ep = $this->crud->read($query);
		//get total lates later..code here
		$emps = array();
		$e = array();
		$ctr = 0;
		foreach($ep as $key){
			 
		$a = $this->compute->lates($key['id'],$from,$to);
		$b = $this->compute->get_total_hours($key['id'],$from,$to);
			$e[$key['id']] = array();
			$add = array(
						'id'=>$key['id'],
						'lates'=>$a['hours'].":".$a['minutes'],
						'totalhours'=>$b,
						'fname'=>$key['firstname']." ".$key['lastname']
						);
			array_push($e[$key['id']],$add);
		}
		//print_r($e);
		$data['emp'] = $e;
		$data['d'] = $from." to ".$to;
		$this->load->render('common/adminheader_',$data);
		$this->load->render('dtrsummary_',$data);
		$this->load->render('common/footer_');
		}else{
			redirect('dtr');
		}
	}
	
}