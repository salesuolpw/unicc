<?php
class users extends MVC_controller{
	public function __construct(){
		parent::__construct();
		if(islogin()==true){
				if(isadmin()==true){
						redirect('admin');
				}
			
			}else{
				redirect('main');
			}
		
	}
	public function index(){
	
		$info = $this->validate->identify_user($this->session->_get('uid'));
		$data['user'] = $info['fullname'];
		
		$count = $this->crud->read('SELECT * FROM leave_request WHERE status=1 AND Emp_id=:id',array('id'=>$this->session->_get('uid')));
		$data['accept'] = count($count);
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/usermain_',$data);
		$this->load->render('common/footer_');
	}
	
	public function settings(){
	$info = $this->validate->identify_user($this->session->_get('uid'));
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$data['user'] = $info['fullname'];
		$info = $this->validate->identify_user($this->session->_get('uid'));
		
				if($_POST['cpass']){
					$old = r_sha($_POST['oldpass']);
					$new = r_sha($_POST['newpass']);
					$rtp = r_sha($_POST['retypepass']);
					
					if(empty($old) || empty($new) || empty($rtp)){
						$data['error'] = "All fields are required";
					}else{
						$ps = $this->crud->read('SELECT password FROM users WHERE uid=:id',array('id'=>$this->session->_get('uid')));
						
						if($old == $ps[0]['password']){
							
							
							if($new==$rtp){
									$this->crud->update('users',array('password'=>$new),array('uid'=>$this->session->_get('uid')));
									$data['success'] = 'You have sucessfully changed your password';
							}else{
							
								$data['error'] = "Your new password is not match";
							}
						}else{
							$data['error'] = "Your password is not match";
						
						}
					
						
					}
					
				}
		$data['user'] = $info['fullname'];
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/usersettings_',$data);
		$this->load->render('common/footer_');
	}
	
	public function leave($id = false){
	
	$uid = $this->session->_get('uid');
		$info = $this->validate->identify_user($uid);
		$a = $this->crud->read('SELECT lctr FROM leave_request WHERE emp_id=:id',array('id'=>$uid));
		
		foreach($a as $key){
			$c = $c + $key['lctr'];
		}
		$tlctr = 2 - $c;
		if($tlctr==0){
		$data['lct'] = $tlctr;
		$data['dis'] = true;
		}else{
		$data['lct'] = $tlctr;
			
		}
		$data['user'] = $info['fullname'];
		
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/userleave_',$data);
		$this->load->render('common/footer_');
	
	}
	
	public function request($id = false){
		$info = $this->validate->identify_user($this->session->_get('uid'));
		$uid = $this->session->_get('uid');
		if($_POST['reqleave']){
					$rson = r_string($_POST['reason']);
					$leave = r_string($_POST['leave']);
					$fr = str_replace('/','-',r_string($_POST['fr']));
					$to = str_replace('/','-',r_string($_POST['to']));
			
				//to continue {request leave}
				
				if(empty($rson) || empty($leave) ||	empty($fr) || empty($to)||$leave=='null'){
				$data['error'] = "All fields are required, Please fill-out";
				}else{
				$date = date("Y-m-d");
				$vals = array('emp_id'=>$uid,'leave_apply'=>$leave,'lctr'=>1,'reason'=>$rson,'fr'=>$fr,'tod'=>$to,'date'=>$date);
				$this->crud->create('leave_request',$vals);
				$data['success'] = "Your Request was successfuly sent.";
				}
		
		}

			$data['lreq'] = ($id[0]=='sick') ? 'Sick' : 'Vacation';

			
		
		$data['user'] = $info['fullname'];
		$data['date'] = $info['date'];
		$data['position'] = $info['position'];
		$data['salary'] = $info['salary'];
		$data['uid'] = $uid;
		
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/userleaverequest_',$data);
		$this->load->render('common/footer_');
	}
	public function contributions(){

		$info = $this->validate->identify_user($this->session->_get('uid'));
		
		$this->load->render('common/userheader_',$data);
			$this->load->render('users/usercompensation_');
		$this->load->render('common/footer_');
	}
	
	public function sick(){
	
		$info = $this->validate->identify_user($this->session->_get('uid'));
		$data['user'] = $info['fullname'];
		
		$data['sick'] = $this->crud->read('SELECT * FROM leave_request WHERE leave_apply=:la AND Emp_id=:id',array('la'=>'sick','id'=>$this->session->_get('uid')));
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/userleavesick_',$data);
		$this->load->render('common/footer_');
	
	}
	
		public function vacation(){
	
		$info = $this->validate->identify_user($this->session->_get('uid'));
		$data['user'] = $info['fullname'];
		
		$data['vacation'] = $this->crud->read('SELECT * FROM leave_request WHERE leave_apply=:la AND Emp_id=:id',array('la'=>'vacation','id'=>$this->session->_get('uid')));
		$this->load->render('common/userheader_',$data);
		$this->load->render('users/userleavevacation_',$data);
		$this->load->render('common/footer_');
	
	}
	
}

/*
	if(empty($rson) || empty($leave) ||	empty($fr) || empty($to)||$leave=='null'){
				$data['error'] = "All fields are required, Please fill-out";
				}else{
				$date = date("Y-m-d");
				$vals = array('emp_id'=>$uid,'leave_apply'=>$leave,'lctr'=>1,'reason'=>$rson,'fr'=>$fr,'tod'=>$to,'date'=>$date);
				//$this->crud->create('leave_request',$vals);
				echo 1;
				}
*/