<?php
class compensation extends MVC_controller{
	private $s = false;
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}

	public function index(){
	
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$c = r_string($this->countleave());
		$data['leavecnt'] = ($c!=0) ? $c : null;
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/compensation_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	private function countleave(){
			$l = $this->db->prepare('SELECT COUNT(*) as count FROM leave_request WHERE status=0');
			$l->execute();
			return $l->fetch(PDO::FETCH_ASSOC); 
		
	}
	
	public function leave(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$data['leave'] =$ab= $this->crud->read('SELECT 
		lvr.emp_id,emp.firstname,emp.lastname,emp.mid_name,jb.job_name,emp.salary,lvr.leave_apply,lvr.reason,lvr.fr,lvr.tod,lvr.date,lvr.id, lvr.status
		FROM employees AS emp, leave_request AS lvr,jobs AS jb WHERE lvr.emp_id=emp.id AND emp.position=jb.id');
		
		//dependencies : adminheader_.php, leave_.php {view leave reason}
		if($_POST['pst']){
			$id = explode('/',$_POST['id']);
			//print_r($id);
			$a = $this->crud->read('SELECT em.lastname,em.firstname,em.mid_name,lr.leave_apply,lr.fr,lr.tod,lr.reason,lr.id,lr.status FROM leave_request as lr,employees as em WHERE em.id=:id AND lr.id=:mid',array('id'=>$id[1],'mid'=>$id[2]));
			$data['nme'] = $a[0]['lastname'].", ".$a[0]['firstname']." ".$a[0]['mid_name'];
			$data['leave'] = $a[0]['leave_apply'];
			$data['from'] = $a[0]['fr'];
			$data['to'] = $a[0]['tod'];
			$data['reason'] = $a[0]['reason'];
			$data['lrid'] = $a[0]['id'];
			$data['st'] = $a[0]['status'];
			
			$this->load->render('admin/leave_view_spec',$data);
			return false;
		}
		//dependencies : adminheader_.php, leave_.php {accep leave request for particular request}
		if($_POST['accpt']){
				$id =  $_POST['id'];
				$this->crud->update('leave_request',array('status'=>1),array('id'=>$id));
				echo "<div id='sc'><h1>Congratulation!</h1><h2>Leave request is successfully accept</h2>";
				echo "<a href='".base_url()."compensation/leave' class='g-button blue'>Ok</a>";
				
				
		return false;
		}
		
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/leave_',$data);
		$this->load->render('common/footer_',$data);
	}
}