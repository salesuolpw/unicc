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
		$this->load->libraries(array('fpdf'));
		$this->fpdf->AddPage();
		$this->fpdf->SetFont('Arial','B',16);
		$this->fpdf->Cell(40,10,'Pay Slip');
		$this->fpdf->Output();
		//$this->load->render('common/adminheader_',$data);
		//$this->load->render('admin/reports_');
		//$this->load->render('admin/pay_slip');
		//$this->load->render('common/footer_',$data);
	}
}