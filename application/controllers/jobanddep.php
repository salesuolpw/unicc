<?php
class jobanddep extends MVC_controller{
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}
	
	public function index(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$data['deps'] = $this->crud->read("select * from departments");
	
	//add new department
	if(isset($_POST['adddep'])){
			$dep = $_POST['dep_n'];
			$pos = $_POST['pos'];
			if(empty($pos[0]) && empty($dep)){
				$data['error'] = "<div class='error'>Please input Department and atleast one Position</div>";
			}else{
				$q = $this->db->prepare('INSERT INTO departments(dep_name) VALUES(:dname)');
					$a = $q->execute(array('dname'=>$dep));
				$lastid= $this->db->lastInsertId();
					foreach($pos as $key){
						$b = $this->db->prepare('INSERT INTO jobs(dep_id,job_name) VALUES(:id,:job)');
						$a = $b->execute(array('id'=>$lastid,'job'=>$key));
					}
		
				$data['rs'] = "<div class='success'>Department and Position(s) was successfully add. <a href='".base_url()."jobanddep' >Reload page</a></div>";
			}
	}
		
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/jad_',$data);
		$this->load->render('common/footer_',$data);
		
		
	}
	
	public function department($id = false){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
			
			if($id[0]=='view'){
			$data['current'] =$c = $this->crud->read('select id,dep_name from departments where id=:id',array('id'=>$id[1]));
			$data['jobs'] =$c = $this->crud->read('select * from jobs where dep_id=:id',array('id'=>$id[1]));
				
			$data['gdep'] = $dept = $this->crud->read('select * from departments');
			}
			
			
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/department_',$data);
		$this->load->render('common/footer_',$data);
	}
	
	
	public function delete($id = false){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$data['deps'] = $this->crud->read("select * from departments");
			$id  = $id[0];
			$q = $this->db->prepare("SELECT dep_id FROM jobs WHERE dep_id=:id");
			$a = $q->execute(array('id'=>$id));
			$result = $q->fetch(PDO::FETCH_ASSOC);
			if(!is_array($result)){
					$c = $this->crud->delete('departments',array('id'=>$id));
					$data['successdel'] = "Department was successfully Remove.";
				}else{
					$data['errordel'] = "<div class='error'>Ooops...You can't remove this Department.Please remove Position under of this Department</div>"; 
				}
				
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/jad_',$data);
		$this->load->render('common/footer_',$data);
		
	}
			
	
}