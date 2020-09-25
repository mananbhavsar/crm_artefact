<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Recruitment extends CIUIS_Controller {
	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
		$this->load->model('Recruitment_Model');
	}
	function index() {
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} else {
			$data[ 'title' ] = lang( 'candidates' );
			//$data[ 'candidates' ] = $this->Recruitment_Model->get_all_candidates();
			//$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			//$data[ 'departments' ] = $this->Settings_Model->get_departments();
			$path = $this->uri->segment( 1 );
			if ( !$this->Privileges_Model->has_privilege( $path ) ) {
				$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
				redirect( 'panel/' );
				die;
			}
			$this->load->view( 'recruitment/index', $data );
		}
	} 
	function recruitmenttype()
	{
		$statuss = array(
			['id'=>1, 'name'=> 'AwaitingReview'],
			['id'=> 2, 'name'=> 'Reviewed'] ,
			[ 'id'=> 3, 'name'=> 'Screened' ],
			[ 'id'=> 4, 'name'=> 'Interviewed'],
			[ 'id'=> 5, 'name'=> 'Hired'],
			[ 'id'=> 6, 'name'=> 'Rejected']
		);
		foreach($statuss as $status){
			
			$name=$status['name'];
			$tasksbusiness = $this->Recruitment_Model->get_all_candidates($status['id']);
			$data[$name] =count($tasksbusiness );
		}
		$tasksall =$this->Recruitment_Model->get_all_candidates(0);
		$data['total'] =count($tasksall );
		
		$data['success'] = true;
		$data['message'] = 'success';
		echo json_encode($data); 
	}
	function get_Recruitment($type="") {
        $tasks = array();
		$tasks = $this->Recruitment_Model->get_all_candidates($type);
        $data_tasks = array();
        foreach ($tasks as $task) {
            $settings = $this->Settings_Model->get_settings_ciuis();
            $data_tasks[] = array('id' => $task['candidate_id'], 'name' => $task['applicant_name'], 'position' => $task['position_applied_for'], 'status' => $task['status'], 'entered_date' => $task['entered_date'], 'location' => $task['location'], 'file_name' => $task['file_name'], 'user_id' => $task['user_id'],'filetype' => $task['filetype'],'rejected_remarks' => $task['rejected_remarks']
            );
        };
        echo json_encode($data_tasks);
        return $data_tasks;
    }
    
	function createcandidate() {
		if ( $this->Privileges_Model->check_privilege( 'recruitment', 'create' ) ) {
			$data[ 'title' ] = 'Create Candidates';
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$applicant_name = $this->input->post( 'applicant_name' );
				$position_applied_for = $this->input->post( 'position_applied_for' );
				$status = $this->input->post( 'status' );
				$entered_date = $this->input->post('entered_date');
				$location = $this->input->post( 'location' );
				$appconfig = get_appconfig();
				$params = array(
					'applicant_name' => $applicant_name,
					'position_applied_for' => $position_applied_for,
					'status' => $status,				
					'entered_date' => $entered_date,
					'location' => $location,
					'user_id' => $this->session->userdata( 'usr_id' ),
					
				);
				$this->db->insert( 'recruitment_candidates', $params );
				$candidate_id = $this->db->insert_id();
				if (!is_dir('uploads/files/candidates/'.$candidate_id)) { 
					mkdir('./uploads/files/candidates/'.$candidate_id, 0777, true);
				}
				if(!empty($_FILES['file']['name'])){
					$_FILES['file']['name'] = $_FILES['file']['name'];
					$_FILES['file']['type'] = $_FILES['file']['type'];
					$_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
					$_FILES['file']['error'] = $_FILES['file']['error'];
					$_FILES['file']['size'] = $_FILES['file']['size'];
					$config[ 'upload_path' ] = './uploads/files/candidates/'.$candidate_id.'';
					$config['allowed_types'] = 'docx|doc|pdf';
					//$config['max_size'] = '20000';
					$config['file_name'] = $_FILES['file']['name'];
					$this->load->library('upload',$config); 
					if($this->upload->do_upload('file')){
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						$filetype = $uploadData['file_type'];
						$this->Recruitment_Model->update_file($candidate_id,$filename,$filetype);
					} 
				}
				redirect('recruitment','refresh'); 
			}
		}
	}
	function GetRecruitment( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'recruitment', 'all' ) ) {
			$data['recruitment'] = $this->Recruitment_Model->GetRecruitment( $id );
		}else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('recruitment'));
		}
		if($data['recruitment']) {
			//$data[ 'title' ] = $data['recruitment'][ 'candidate_name' ];
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view( 'recruitment/detail', $data );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('recruitment'));
		}
	}
	function update($candidate_id){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$applicant_name = $this->input->post( 'applicant_name' );
			$position_applied_for = $this->input->post( 'position_applied_for' );
			$entered_date = date('Y-m-d',strtotime($this->input->post('entered_date')));
			$location = $this->input->post( 'location' );
			$appconfig = get_appconfig();
			$params = array(
				'applicant_name' => $applicant_name,
				'position_applied_for' => $position_applied_for,				
				'entered_date' => $entered_date,
				'location' => $location
			);
			$response = $this->Recruitment_Model->update($candidate_id,$params);
		}
   		redirect(base_url().'recruitment/GetRecruitment/'.$candidate_id);
   
    
}
	function update_reject_remark(){
		$id = $this->input->post('id');
		$remarks = $this->input->post('remarks');
		$status = $this->input->post('status');
		$data = $this->Recruitment_Model->update_remarks($id,$remarks,$status);
		echo json_encode($data);
		redirect('recruitment','refresh');
	}
	
	function update_status(){
		if ( $this->Privileges_Model->check_privilege( 'recruitment', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$id = $this->input->post('candidate_id');
				$status = $this->input->post('status_id');
				$name = $this->input->post('name');
				$candidate_id = $this->Recruitment_Model->update_candidate_status($id,$status);
				$data['success'] = true;
				if($name=="Rejected")
				$data['message'] = "Mention rejected remarks in notes";
				else if($name=="Screened")
				$data['message'] = "Schedule the interview";
				else
				$data['message'] = lang('recruitment').' '.lang('markas').' '.$name;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	function delete_recruitment($id) {
        $person_id = $id;
        $deleteContact = $this->Recruitment_Model->delete_recruitment($person_id);
        redirect(base_url('recruitment'));
        
    }
}