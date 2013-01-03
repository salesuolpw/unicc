<?php

class reports extends MVC_controller{
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	
	}

	public function index(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		

		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/reports_');

		$this->load->render('common/footer_',$data);
	}

	public function payslip(){
		$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
		$data['result'] = $this->reportsmodel->pslip();
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/reports_');
		$this->load->render('admin/payslip',$data);
		$this->load->render('common/footer_',$data);
	}
}