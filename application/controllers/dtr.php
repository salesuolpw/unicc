<?php
class dtr extends MVC_controller{
	private $s = false;
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->render('common/head_');
	}

	public function login(){
		if(isset($_POST['dtrlogin'])){

			$uname = r_string($_POST['empusername']);
			$pass = r_sha(r_string($_POST['emppass']));
			$result = $this->validate->user($uname,$pass);	
				$uid = $result['uid'];
				$username = $result['username'];
				$usertype = $result['usertype'];
		
				if($result == TRUE){
				$date = date('Y-m-d');
				$login = date('H:i:s');
				$q = $this->crud->create('dtr',array('emp_id'=>$uid,'_in'=>$login,'date'=>$date,'p_status'=>0,'isOut'=>0));
				}else{
				$data['error'] = 'Invalid Username or Password';
				}
		}
		$query = 'SELECT e.id, e.lastname,e.firstname,e.mid_name,d._in,dd.dep_name FROM departments as dd,dtr as d, employees as e WHERE e.dep_id=dd.id AND e.id=d.emp_id AND (d.out=\'00:00:00\' OR isOut=0)';

		$data['dtr']= $this->crud->read($query);
		//print_r($dtr);

		$this->load->render('common/head_',$data);

	}
	
}