<?php
class dtr extends MVC_controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
	$today = date('Y-m-d');
	$nextday = date('Y-m-d',strtotime('+1 day',strtotime($today)));
		if(isset($_POST['pass'])){
			$username = r_string($_POST['uname']);
			$pass = r_sha(r_string($_POST['passw']));
			$result = $this->validate->user($username,$pass);
			$id = $result['uid'];
			if($result==TRUE){	
					$logout = date('H:i:s');
					$a = $this->db->prepare("UPDATE dtr SET _out=:out, isOut=1 WHERE emp_id=:id AND date BETWEEN :today AND :nday");
					$array = array(':out'=>$logout,'id'=>$id,':today'=>$today,':nday'=>$nextday);
					$a->execute($array);

					echo true;
				}else{
					echo "Invalid Password";
				}
			return false;
		}
	
	$data['dtr']= $this->crud->read('SELECT e.id, e.lastname,e.firstname,e.mid_name,d._in,dd.dep_name,u.username FROM users as u,departments as dd,dtr as d, employees as e WHERE u.uid=e.id AND e.dep_id=dd.id AND e.id=d.emp_id AND (d._out=\'00:00:00\' OR isOut=0) AND date BETWEEN :today AND :nextday',array(':today'=>$today,'nextday'=>$nextday));
	$this->load->render('common/head_',$data);
	}

	public function login(){

		if(isset($_POST['dtrlogin'])){

			$uname = r_string($_POST['empusername']);
			$pass = r_sha(r_string($_POST['emppass']));

			$validate = $this->validate->user($uname,$pass);
			$uid = $validate['uid'];

			if($validate==TRUE){
				$result = $this->validate->dtr_validate($uid);	
					if($result==TRUE){
							$data['error'] = "<div class='error'>Employee was already Login.</div>";
					}else{
							$date = date('Y-m-d');
							$login = date('H:i:s');
							$q = $this->crud->create('dtr',array('emp_id'=>$uid,'_in'=>$login,'date'=>$date,'p_status'=>0,'isOut'=>0));
								
					}

			}else{
				$data['error'] = "<div class='error'>Account may not exists from database, Please check your username or password</div>";
		}
	}

	$today = date('Y-m-d');
	$nextday = date('Y-m-d',strtotime('+1 day',strtotime($today)));
	$data['dtr']= $this->crud->read('SELECT e.id, e.lastname,e.firstname,e.mid_name,d._in,dd.dep_name,u.username FROM users as u,departments as dd,dtr as d, employees as e WHERE u.uid=e.id AND e.dep_id=dd.id AND e.id=d.emp_id AND  isOut=0 AND date BETWEEN :today AND :nextday',array(':today'=>$today,'nextday'=>$nextday));
	$this->load->render('common/head_',$data);

	}
	
}