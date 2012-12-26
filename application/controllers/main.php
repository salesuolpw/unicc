<?php

class main extends MVC_controller{
	
	public function __construct(){
		parent::__construct();
			if(islogin()==true){
				if(isadmin()==true){
					redirect('admin');
				}else{
					redirect('users');
				}
			}
		
	}
	public function index(){
		$this->load->render('common/header_');
		$this->load->render('login_');
		$this->load->render('common/footer_');
	}
	
	public function login(){
		if($_POST['userlogin']){
				$uname = r_string($_POST['username']);
				$pass = r_sha(r_string($_POST['password']));
				$result = $this->validate->user($uname,$pass);	
				$uid = $result['uid'];
				$username = $result['username'];
				$usertype = $result['usertype'];
		
				if($result == TRUE){
						$this->session->_set(array('uid'=>$uid,'username'=>$username,'usertype'=>$usertype,'islogin'=>true));
						if($usertype==0){
							redirect('admin');
						}else{
							redirect('users');
						}
				}else{
				$data['error'] = 'Invalid Username or Password';
				}
				
		}
		$this->load->render('common/header_');
		$this->load->render('login_',$data);
		$this->load->render('common/footer_');
	}
	
	public function forgot(){
			if($_POST['userforgot']){
			$uname = r_string($_POST['username']);
			echo $uname;
		}
		
		$this->load->render('common/header_');
		$this->load->render('forgot_');
		$this->load->render('common/footer_');
	}
	
	public function logout(){
		$this->session->_destroy();
		redirect('main');
	
	}
	
}