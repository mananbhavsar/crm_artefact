<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Salaryrequests extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
			$this->load->model('Requests_Model');
			$this->load->model('Mrequests_Model');
			$this->load->model('Material_Model');
			$this->load->model('Staff_Model');
			$this->load->model('Vendors_Model');
			$this->load->model('Billrequests_Model');
			$this->load->model('Leaverequests_Model');
			$this->load->model('Salaryrequests_Model');
			$this->load->helper('url'); 
			$this->load->model('Otherrequests_Model');
			$this->load->model('Notifications_Model');
			$this->load->model('Privileges_Model');
	if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} 
		
	}

	function index() {
		
		$path = $this->uri->segment( 3 );
		 if($path == 'app'){
			$status = 2;
		}
		else if($path == 'dec'){
			$status = 3;
		}else if($path == 'pend'){
			$status = 1;
		}else{
			$status = 0;
		}
		$data['employees'] = $this->Staff_Model->get_all_staff();
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'salaryrequests', 'all' ) ){
		$data['srequests'] = $this->Salaryrequests_Model->get_all_srequests($status);
		$data['app_count'] = $this->Salaryrequests_Model->get_appreq_count(2);
		$data['dec_count'] = $this->Salaryrequests_Model->get_decreq_count(3);
		$data['pend_count'] = $this->Salaryrequests_Model->get_pendreq_count(1);
		$data['all_count'] = $this->Salaryrequests_Model->get_allreq_count();
		}
		else{
			
			$data['srequests'] = $this->Salaryrequests_Model->get_user_all_srequests($status,$data['user_id']);
			$data['app_count'] = $this->Salaryrequests_Model->get_user_appreq_count(2,$data['user_id']);
			$data['dec_count'] = $this->Salaryrequests_Model->get_user_decreq_count(3,$data['user_id']);
			$data['pend_count'] = $this->Salaryrequests_Model->get_user_pendreq_count(1,$data['user_id']);
			$data['all_count'] = $this->Salaryrequests_Model->get_user_allreq_count($data['user_id']);
		}
		$data['maxvalue']=$this->Privileges_Model->has_approval('salaryrequests');
		$data[ 'title' ] = lang( 'salaryrequests' );  
		$data['pagename']='request';
		
		$this->load->view( 'salaryrequests/index', $data );
	}


	function create(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		
		$employeeids=array();
		$adminides=$this->Staff_Model->get_all_admin_ids();
		$tempemployeeids=$adminides;
		foreach($tempemployeeids as $eachId){
			if($eachId != $this->input->post( 'staff' )){
				$employeeids[]=array("id"=>$eachId);
			}
		}
		$employee_id  = $this->input->post( 'employee_id' );
		$type_of_salary = $this->input->post( 'type_of_salary' );
		$from_date = $this->input->post( 'from_date' );
		$to_date = $this->input->post( 'to_date' );
		$amount = $this->input->post( 'amount' );
		$remarks = $this->input->post( 'remarks' );
		$pagename = $this->input->post('pagename');
	
 		
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_salary' => $type_of_salary,
						'from_date' => $from_date,
						'to_date' => $to_date,
						'amount' => $amount,
						'remarks' => $remarks,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'salary_requests', $params );
					$oreq_id = $this->db->insert_id();
					$seriesid = "SLY-".$oreq_id;
					$this->db->where('salary_id', $oreq_id)->update( 'salary_requests', array('seriesid' => $seriesid ) );
					//Notification//
					$Notifyparams=array();
					$Notifyparams['staffList']=$employeeids;
					$Notifyparams['msg']=( '' .$seriesid.' '.lang('send').' By '. $this->session->staffname .'' );
					$Notifyparams['link']= base_url('salaryrequests/');
					$Notifyparams['staff_id']= '';
					$Notifyparams['img']=$this->session->staffavatar;
					$this->Notifications_Model->insertNotification($Notifyparams);

				$this->session->set_flashdata('success','Salary Request Added Successfully');
				if($pagename=='request'){
					redirect('salaryrequests','refresh'); 
				}else{
				redirect('salaryrequests','refresh'); 
				}
				
		}
	}
	
	
		
	function update(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		
		
		$data=$this->Salaryrequests_Model->update_status($id,$status);
		echo json_encode($data);
		//$this->session->set_flashdata();
		$this->session->set_flashdata('success', "Status  Updated Successfully"); 

		redirect('salaryrequests','refresh');
       // echo json_encode($data);
    }
	
	
}