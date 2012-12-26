<?php
class account extends MVC_controller{
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}
	
	public function index(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
			$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/admin_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	public function settings(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$uid = $this->session->_get('uid');

		//if change password
		if(isset($_POST['change'])){
				$old = r_sha($_POST['oldpass']);
				$new = r_sha($_POST['newpass']);
				$retype = r_sha($_POST['retypepass']);
				
				if(empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['retypepass'])){
					$data['error'] = "All fields are required";
				}else{
					if($new==$retype){
							if($new=="" || $retype==""){
							$data['error'] = "Please input your password";
							}else{
								$ps = $this->crud->read('SELECT password FROM users WHERE uid=:id',array('id'=>$uid));
							
									if($old == $ps[0]['password']){
										
										if($new==$retype){
												$this->crud->update('users',array('password'=>$new),array('uid'=>$uid));
												$data['success'] = 'You have sucessfully changed your password';
										}else{
										
											$data['error'] = "Old password is not match";
										}	
								}
							}
					}else{
					$data['error'] = "New password is not match";
					}
				}
			}
		
		//if change information
		
		if($_POST['acc_info']){
			$last_name = r_string($_POST['lname']);
			$first_name =r_string($_POST['fname']);
			$mid_name =  r_string($_POST['mname']);
			$bdy = r_string($_POST['bday']);
			$age = r_string($_POST['age']);
			$sex = r_string($_POST['gender']);
			$cv = r_string($_POST['cv_stat']);
			$addrs = r_string($_POST['address']);
			$religion = r_string($_POST['religion']);
			$contact =  r_string($_POST['cnumber']);
			$update = array(
			'lastname' => $last_name,
			'firstname' => $first_name,
			'mid_name' => $mid_name,
			'bday' => $bdy ,
			'age' => $age,
			'sex' =>  $sex,
			'civil_status' => $cv ,
			'address' => $addrs,
			'religion' =>  $religion,
			'contact' => $contact,'id'=>$uid);
			$y = $this->db->prepare('UPDATE employees SET 
														lastname=:lastname,
														firstname=:firstname,
														mid_name=:mid_name,
														bday=:bday,
														age=:age,
														sex=:sex,
														civil_status=:civil_status,
														address=:address,
														religion=:religion,
														contact=:contact WHERE id=:id');
			 $y->execute($update);
			 
			 $data['success'] = "Informaton was successfully modify.";
			
		}
		$query = $this->db->prepare('SELECT * FROM employees WHERE id=:id');
		$query->execute(array('id'=>$uid));
		$data['a_info'] = $query->fetch(PDO::FETCH_ASSOC);
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/settings_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	
	public function changepass(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$uid = $this->session->_get('uid');


		print_r($s);
		if(isset($_POST['change'])){
				$old = r_sha($_POST['oldpass']);
				$new = r_sha($_POST['newpass']);
				$retype = r_sha($_POST['retypepass']);
				
				if(empty($old) || empty($new) || empty($retype)){
					$data['error'] = "All fields are required";
				}else{
					if($new==$retype){
							$ps = $this->crud->read('SELECT password FROM users WHERE uid=:id',array('id'=>$uid));
						
						if($old == $ps[0]['password']){
							
							if($new==$retype){
									$this->crud->update('users',array('password'=>$new),array('uid'=>$uid));
									$data['success'] = 'You have sucessfully changed your password';
							}else{
							
								$data['error'] = "Your new password is not match";
							}	
					}else{
					$data['error'] = "New password is not match";
					}
				}
		}
	}
	
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/changepassword_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	public function benefits(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$uid = $this->session->_get('uid');
			
		
		
			if($_POST['ssss']){
			$sss = r_string($_POST['sss']);
			$this->crud->update('employees',array('sss'=>$sss),array('id'=>$uid));
									$data['success'] = 'SSS is successfully changed';
			}
		
			if($_POST['philhealthtbn']){
			$philhealth = r_string($_POST['philhealth']);
				$this->crud->update('employees',array('philhealth'=>$philhealth),array('id'=>$uid));
									$data['success'] = 'Philhealth is successfully changed';
			}
			
			if($_POST['pagibigbtn']){
			$pagibig = r_string($_POST['pagibig']);
			$this->crud->update('employees',array('pagibig'=>$pagibig),array('id'=>$uid));
									$data['success'] = 'Pagibig is successfully changed';
			}
			
			
			if($_POST['tinbtn']){
				$tin = r_string($_POST['tin']);
				$this->crud->update('employees',array('tin'=>$tin),array('id'=>$uid));
									$data['success'] = 'TIN is successfully changed';
			}
			
		
		
		$query = $this->db->prepare('SELECT * FROM employees WHERE id=:id');
		$query->execute(array('id'=>$uid));
		$data['a_info'] = $query->fetch(PDO::FETCH_ASSOC);
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/benefits_',$data);
		$this->load->render('common/footer_',$data);
	}
}