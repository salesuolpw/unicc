<?php

class admin extends MVC_controller{
	
	public function __construct(){
		parent::__construct();
			if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}
	public function index(){

		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		
		
		$l = $this->db->prepare('SELECT COUNT(*) as count FROM leave_request WHERE status=0');
		$l->execute();
		$a = $l->fetch(PDO::FETCH_ASSOC); 
		$data['leavecnt'] = ($a['count']==0) ? null : $a['count'];
		
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/admin_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	private function info(){
	if($this->session->_get('islogin')==true){
				if($this->session->_get('utype')!=0){
					redirect('main');
				}
			}
	

	}
	
	
}
