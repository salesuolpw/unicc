<?php
class jobanddep extends MVC_controller{
	public function __construct(){
		parent::__construct();
		if(islogin()==true){if(isadmin()!=true){redirect('users');}}else{redirect('main');}
	}
	
	public function index(){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$data['deps'] =$dpr = $this->crud->read("select * from departments");
	if(isset($_POST['modPos'])){
		$dep = $_POST['new_pos'];
				$id = $_POST['id'];
				//echo $dep . "=".$id;

				$a = $this->crud->update('jobs',array('job_name'=>$dep),array('id'=>$id));
				//$a = $this->crud->update('departments',array('id:id','dep_name:dep_name'),array('id'=>$id,'dep_name'=>$dep,));
				if($a==true || $a == 1){
					echo "Position was successfully updated.";
				}
		return false;
	}
	if(isset($_POST['mod'])){
				$dep = $_POST['new_dep'];
				$id = $_POST['id'];
				$a = $this->crud->update('departments',array('dep_name'=>$dep),array('id'=>$id));
				//$a = $this->crud->update('departments',array('id:id','dep_name:dep_name'),array('id'=>$id,'dep_name'=>$dep,));
				if($a==true || $a == 1){
					echo "Department was successfully updated.";
				}

		return false;
		}
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

	if(isset($_POST['addposition'])){
		$dep_id = $_POST['dep_id'];
		$pos = $_POST['pos'];

		foreach ($pos as $key) {
			# code...
			$b = $this->db->prepare('INSERT INTO jobs(dep_id,job_name) VALUES(:id,:job)');
			$a = $b->execute(array('id'=>$dep_id,'job'=>$key));
		}
		$data['addpstsuccess'] = "<div class='success'>Position has been successfully added.</div>";

	}
		
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/jad_',$data);
		$this->load->render('common/footer_',$data);
		
		
	}
	
	public function department($id = false){
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$data['current_id'] = $id[1];
	if(!isset($id[0]) || !isset($id[1])){redirect('jobanddep');}
	
			if($id[0]=='view'){
			$data['current'] =$c = $this->crud->read('select id,dep_name from departments where id=:id',array('id'=>$id[1]));
			$data['jobs'] =$c = $this->crud->read('select * from jobs where dep_id=:id',array('id'=>$id[1]));
				
			$data['gdep'] = $dept = $this->crud->read('select * from departments');
			}

			if(isset($id[2])){

				$res = $this->crud->delete('jobs',array('id'=>$id[3]));

					if($res==true){
						redirect('jobanddep/department/view/'.$id[1]);
						$data['successremove'] = "<div class='success'>Position was successfully remove.</div>";
					}
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
					redirect('jobanddep/');

				}else{
					$data['errordel'] = "<div class='error'>Ooops...You can't remove this Department.Please remove Position under of this Department</div>"; 
				}
				
		$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/jad_',$data);
		$this->load->render('common/footer_',$data);
		
	}

	public function removeposition($id = false){
	echo $id[0];
	$data['info'] = $this->user->who('employees',$this->session->_get('uid'));
	$data['deps'] = $this->crud->read("select * from departments");
	$data['current'] =$c = $this->crud->read('select id,dep_name from departments where id=:id',array('id'=>$id[0]));
	$data['jobs'] =$j = $this->crud->read('select * from jobs where dep_id=:id',array('id'=>$id[0]));
		print_r($c);

	$this->load->render('common/adminheader_',$data);
		$this->load->render('admin/department_',$data);
		$this->load->render('common/footer_',$data);
	}

	public function addpos(){
	$data['deps'] = $this->crud->read("select * from departments");
	$data['current'] =$c = $this->crud->read('select id,dep_name from departments where id=:id',array('id'=>$id[0]));
	$data['jobs'] =$j = $this->crud->read('select * from jobs where dep_id=:id',array('id'=>$id[0]));
	$this->load->render('admin/add_position',$data);
	}
			
	
}