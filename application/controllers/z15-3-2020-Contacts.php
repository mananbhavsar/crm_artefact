<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Contacts extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Contacts_Model');
	/*	if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} */
	}

	function index() {
		$data[ 'title' ] = lang( 'contacts' );
		$data[ 'tasks' ] = $this->Tasks_Model->get_all_tasks();
		$data[ 'projects' ] =$projects = $this->Projects_Model->get_all_projects();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'staffs' ] =$staffs = $this->Staff_Model->get_all_staff();
		$this->load->view( 'contacts/index', $data );
	}

	function create() {
		
			
	//	if ( $this->Privileges_Model->check_privilege( 'tasks', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				//$cname = $this->input->post( 'cname' );
				$cemail = $this->input->post( 'cemail' );
				$cperson = $this->input->post( 'cperson' );
				$cnum = $this->input->post( 'cnum' );
				$keyword_content = $this->input->post( 'keyword_content' );
				$address = $this->input->post( 'address' );
					//echo $assignedto;exit;
					$appconfig = get_appconfig();
					$params = array(
						
						'cemail' => $this->input->post( 'cemail' ),
						'cperson' => $this->input->post( 'cperson' ),
						'cnum' => $this->input->post( 'cnum' ),
						'keyword_content' => $this->input->post( 'keyword_content' ),
						'address' => $this->input->post( 'address' ),
						'user_id' => $this->session->userdata( 'usr_id' ),
						'type' => 'person'
					);
					//echo "<pre>";
					//print_r($params );exit;
					$contact_id = $this->Contacts_Model->add_contact_person($params);
					
					if (!is_dir('uploads/files/contacts/'.$contact_id)) { 
						mkdir('./uploads/files/contacts/'.$contact_id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/contacts/'.$contact_id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					//$config['max_size'] = '9000';
					
						$config['file_name'] = $_FILES['userfile']['name'];
					
					$this->load->library( 'upload', $config );
					
					
						     if($this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					
						if (is_file('./uploads/files/contacts/'.$contact_id.'/'.$image_data[ 'file_name' ])) {
							$params1 = array(
								'userfile' => $image_data[ 'file_name' ],
								'person_id' => $contact_id
							);
							$this->Contacts_Model->update_contact_person( $contact_id, $params1 );
						}
					}
						
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'contact', $contact_id );
					}
				
					$data['message'] = lang('contact').' '.lang('createmessage');
					$data['success'] = true;
					$data['id'] = $contact_id;
					
					
				
						
					redirect(base_url('contacts'));
					//echo json_encode($data);
				
			}
		/* } else {
			$data['message'] = lang('you_dont_have_permission');
			$data['success'] = false;
			echo json_encode($data);
		} */
	}
	
	function createb() {
		
			
	//	if ( $this->Privileges_Model->check_privilege( 'tasks', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$cname = $this->input->post( 'cname' );
				$cemail = $this->input->post( 'cemail' );
				$cperson = $this->input->post( 'cperson' );
				$cnum = $this->input->post( 'cnum' );
				$keyword_content = $this->input->post( 'keyword_content' );
				$address = $this->input->post( 'address' );
					//echo $assignedto;exit;
					$appconfig = get_appconfig();
					$params = array(
						'cname' => $this->input->post( 'cname' ),
						'cemail' => $this->input->post( 'cemail' ),
						'cperson' => $this->input->post( 'cperson' ),
						'cnum' => $this->input->post( 'cnum' ),
						'keyword_content' => $this->input->post( 'keyword_content' ),
						'address' => $this->input->post( 'address' ),
						'user_id' => $this->session->userdata( 'usr_id' ),
						'type' => 'business'
					);
					//echo "<pre>";
					//print_r($params );exit;
					$contact_id = $this->Contacts_Model->add_contact_person($params);
					
					if (!is_dir('uploads/files/contacts/'.$contact_id)) { 
						mkdir('./uploads/files/contacts/'.$contact_id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/contacts/'.$contact_id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					//$config['max_size'] = '9000';
					
						$config['file_name'] = $_FILES['userfile']['name'];
					
					$this->load->library( 'upload', $config );
					
					
						     if($this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					
						if (is_file('./uploads/files/contacts/'.$contact_id.'/'.$image_data[ 'file_name' ])) {
							$params1 = array(
								'userfile' => $image_data[ 'file_name' ],
								'person_id' => $contact_id
							);
							$this->Contacts_Model->update_contact_person( $contact_id, $params1 );
						}
					}
						
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'contact', $contact_id );
					}
				
					$data['message'] = lang('contact').' '.lang('createmessage');
					$data['success'] = true;
					$data['id'] = $contact_id;
					
					
				
						
					redirect(base_url('contacts'));
					//echo json_encode($data);
				
			}
		/* } else {
			$data['message'] = lang('you_dont_have_permission');
			$data['success'] = false;
			echo json_encode($data);
		} */
	}

	function update( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				
				$cemail = $this->input->post( 'cemail' );
				$cperson = $this->input->post( 'cperson' );
				$cnum = $this->input->post( 'cnum' );
				$keyword_content = $this->input->post( 'keyword_content' );
				$address = $this->input->post( 'address' );
					//echo $assignedto;exit;
					$appconfig = get_appconfig();
					$params = array(
						
						'cemail' => $this->input->post( 'cemail' ),
						'cperson' => $this->input->post( 'cperson' ),
						'cnum' => $this->input->post( 'cnum' ),
						'keyword_content' => $this->input->post( 'keyword_content' ),
						'address' => $this->input->post( 'address' ),
						'user_id' => $this->session->userdata( 'usr_id' ),
						'type' => 'person',
						'created' => date( "Y-m-d"),
					);
					//echo "<pre>";
					//print_r($params );exit;
					$this->Contacts_Model->update_contact_person_details($id,$params);
					
					if (!is_dir('uploads/files/contacts/'.$id)) { 
						mkdir('./uploads/files/contacts/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/contacts/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					//$config['max_size'] = '9000';
					
						$config['file_name'] = $_FILES['userfile']['name'];
					
					$this->load->library( 'upload', $config );
					
					
						     if($this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					
						if (is_file('./uploads/files/contacts/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params1 = array(
								'userfile' => $image_data[ 'file_name' ],
								'person_id' => $id
							);
							$this->Contacts_Model->update_contact_person( $id, $params1 );
						}
					}
						
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'contact', $id );
					}
				
					$data['message'] = lang('contact').' '.lang('createmessage');
					$data['success'] = true;
					$data['id'] = $id;
					
					
				
						
					redirect(base_url('contacts'));
		}
		
			
	}
	
	function updateb( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$cname = $this->input->post( 'cname' );
				$cemail = $this->input->post( 'cemail' );
				$cperson = $this->input->post( 'cperson' );
				$cnum = $this->input->post( 'cnum' );
				$keyword_content = $this->input->post( 'keyword_content' );
				$address = $this->input->post( 'address' );
					//echo $assignedto;exit;
					$appconfig = get_appconfig();
					$params = array(
						'cname' => $this->input->post( 'cname' ),
						'cemail' => $this->input->post( 'cemail' ),
						'cperson' => $this->input->post( 'cperson' ),
						'cnum' => $this->input->post( 'cnum' ),
						'keyword_content' => $this->input->post( 'keyword_content' ),
						'address' => $this->input->post( 'address' ),
						'user_id' => $this->session->userdata( 'usr_id' ),
						'type' => 'business',
						'created' => date( "Y-m-d"),
					);
					//echo "<pre>";
					//print_r($params );exit;
					$this->Contacts_Model->update_contact_person_details($id,$params);
					
					if (!is_dir('uploads/files/contacts/'.$id)) { 
						mkdir('./uploads/files/contacts/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/contacts/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					//$config['max_size'] = '9000';
					
						$config['file_name'] = $_FILES['userfile']['name'];
					
					$this->load->library( 'upload', $config );
					
					
						     if($this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					
						if (is_file('./uploads/files/contacts/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params1 = array(
								'userfile' => $image_data[ 'file_name' ],
								'person_id' => $id
							);
							$this->Contacts_Model->update_contact_person( $id, $params1 );
						}
					}
						
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'contact', $id );
					}
				
					$data['message'] = lang('contact').' '.lang('createmessage');
					$data['success'] = true;
					$data['id'] = $id;
					
					
				
						
					redirect(base_url('contacts'));
		}
		
			
	}

	function task( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'all' ) ) {
			
		} 
		
			$data[ 'title' ] = lang( 'contacts' );
			$data['task'] = $this->Contacts_Model->get_contact( $id );
			//$data[ 'projects' ] =$projects = $this->Projects_Model->get_all_projects();
			//$data[ 'staffs' ] =$staffs = $this->Staff_Model->get_all_staff();
			//$data['task']=$task;
			//$rel_type = $task[ 'relation_type' ];
			$this->load->view( 'inc/header', $data );
			$this->load->view( 'contacts/task', $data );
		
	}

	function addsubtask() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'description' => $_POST[ 'description' ],
					'taskid' => $_POST[ 'taskid' ],
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'created' => date( 'Y-m-d H:i:s' ),
				);
				$this->db->insert( 'subtasks', $params );
				$data[ 'insert_id' ] = $this->db->insert_id();

				$template = $this->Emails_Model->get_template('task', 'task_comments');
				if ($template['status'] == 1) {
					$tasks = $this->Tasks_Model->get_task_detail( $_POST[ 'taskid' ] );
					$task_url = '' . base_url( 'tasks/task/' . $_POST[ 'taskid' ] . '' ) . '';
					switch ( $tasks[ 'status_id' ] ) {
						case '1':
							$status = lang( 'open' );
							break;
						case '2':
							$status = lang( 'inprogress' );
							break;
						case '3':
							$status = lang( 'waiting' );
							break;
						case '4':
							$status = lang( 'complete' );
							break;
						case '5':
							$status = lang( 'cancelled' );
							break;
					};
					switch ( $tasks[ 'priority' ] ) {
						case '1':
							$priority = lang( 'low' );
							break;
						case '2':
							$priority = lang( 'medium' );
							break;
						case '3':
							$priority = lang( 'high' );
							break;
						default: 
							$priority = lang( 'medium' );
							break;
					};
					$message_vars = array(
						'{task_name}' => $tasks[ 'name' ],
						'{task_startdate}' => $tasks[ 'startdate' ],
						'{task_duedate}' => $tasks[ 'duedate' ],
						'{task_priority}' => $priority,
						'{task_url}' => $task_url,'description',
						'{staffname}' => $tasks[ 'assigner' ],
						'{task_comment}' => $_POST[ 'description' ],
						'{task_status}' => $status,
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $tasks['staffemail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" )
					);
					if ($tasks['staffemail']) {
						$this->db->insert( 'email_queue', $param );
					}
				}
				$data['success'] = true;
				// return json_encode( $data );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function markascancelled() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ){
			if ( isset( $_POST[ 'task' ] ) ) {
				$task = $_POST[ 'task' ];
				$response = $this->db->where( 'id', $task )->update( 'tasks', array( 'status_id' => 5 ) );
				$response = $this->db->where( 'taskid', $task )->update( 'subtasks', array( 'complete' => 0 ) );
				$template = $this->Emails_Model->get_template('task', 'task_updated');
					if ($template['status'] == 1) {
						$tasks = $this->Tasks_Model->get_task_detail( $task );
						$task_url = '' . base_url( 'tasks/task/' . $task . '' ) . '';
						switch ( $tasks[ 'status_id' ] ) {
							case '1':
								$status = lang( 'open' );
								break;
							case '2':
								$status = lang( 'inprogress' );
								break;
							case '3':
								$status = lang( 'waiting' );
								break;
							case '4':
								$status = lang( 'complete' );
								break;
							case '5':
								$status = lang( 'cancelled' );
								break;
						};
						switch ( $tasks[ 'priority' ] ) {
							case '1':
								$priority = lang( 'low' );
								break;
							case '2':
								$priority = lang( 'medium' );
								break;
							case '3':
								$priority = lang( 'high' );
								break;
							default: 
								$priority = lang( 'medium' );
								break;
						};
						$message_vars = array(
							'{task_name}' => $tasks[ 'name' ],
							'{task_startdate}' => $tasks[ 'startdate' ],
							'{task_duedate}' => $tasks[ 'duedate' ],
							'{task_priority}' => $priority,
							'{task_url}' => $task_url,'description',
							'{staffname}' => $tasks[ 'assigner' ],
							'{task_status}' => $status,
							'{logged_in_user}' => $this->session->userdata('staffname'),
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $tasks['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($tasks['staffemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
				$data['success'] = true;
				$data['message'] = lang('task').' '.lang('markas').' '.lang('cancelled');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function markascompletetask() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ){
			if ( isset( $_POST[ 'task' ] ) ) {
				$task = $_POST[ 'task' ];
				$response = $this->db->where( 'id', $task )->update( 'tasks', array( 'status_id' => 4, 'timer' => 0 ) );
				$response = $this->db->where( 'taskid', $task )->update( 'subtasks', array( 'complete' => 1 ) );
				$end = date( 'Y-m-d H:i:s' );
				$response = $this->db->where( 'task_id', $task )->where( 'status', 0 )->update( 'tasktimer', array( 'end' => $end, 'end' => $end, 'note' => 'completed', 'status' => 1 ) );
				$template = $this->Emails_Model->get_template('task', 'task_updated');
					if ($template['status'] == 1) {
						$tasks = $this->Tasks_Model->get_task_detail( $task );
						$task_url = '' . base_url( 'tasks/task/' . $task . '' ) . '';
						switch ( $tasks[ 'status_id' ] ) {
							case '1':
								$status = lang( 'open' );
								break;
							case '2':
								$status = lang( 'inprogress' );
								break;
							case '3':
								$status = lang( 'waiting' );
								break;
							case '4':
								$status = lang( 'complete' );
								break;
							case '5':
								$status = lang( 'cancelled' );
								break;
						};
						switch ( $tasks[ 'priority' ] ) {
							case '1':
								$priority = lang( 'low' );
								break;
							case '2':
								$priority = lang( 'medium' );
								break;
							case '3':
								$priority = lang( 'high' );
								break;
							default: 
								$priority = lang( 'medium' );
								break;
						};
						$message_vars = array(
							'{task_name}' => $tasks[ 'name' ],
							'{task_startdate}' => $tasks[ 'startdate' ],
							'{task_duedate}' => $tasks[ 'duedate' ],
							'{task_priority}' => $priority,
							'{task_url}' => $task_url,'description',
							'{staffname}' => $tasks[ 'assigner' ],
							'{task_status}' => $status,
							'{logged_in_user}' => $this->session->userdata('staffname'),
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $tasks['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($tasks['staffemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
				$data['success'] = true;
				$data['message'] = lang('task').' '.lang('markas').' '.lang('complete');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function completesubtasks() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $_POST[ 'subtask' ] ) ) {
				$subtask = $_POST[ 'subtask' ];
				$response = $this->db->where( 'id', $subtask )->update( 'subtasks', array( 'complete' => 1 ) );
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function removesubtasks() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'delete' ) ) {
			if ( isset( $_POST[ 'subtask' ] ) ) {
				$subtask = $_POST[ 'subtask' ];
				$response = $this->db->where( 'id', $subtask )->delete( 'subtasks', array( 'id' => $subtask ) );
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function uncompletesubtasks() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $_POST[ 'task' ] ) ) {
				$subtask = $_POST[ 'task' ];
				$response = $this->db->where( 'id', $subtask )->update( 'subtasks', array( 'complete' => 0 ) );
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function starttimer() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'task_id' => $_POST[ 'task' ],
					'status' => 0,
					'project_id' => $_POST[ 'project' ],
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'start' => date( 'Y-m-d H:i:s' ),
					'end' => NULL
				);
				$this->db->insert( 'tasktimer', $params );
				$response = $this->db->where( 'id', $_POST[ 'task' ] )->update( 'tasks', array( 'timer' => 1 ) );
				$data[ 'insert_id' ] = $this->db->insert_id();
				$data['success'] = true;
				$data['message'] = lang('timer_started');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function stoptimer() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $_POST[ 'task' ] ) ) {
				$task = $_POST[ 'task' ];
				$end = date( 'Y-m-d H:i:s' );
				$response = $this->db->where( 'task_id', $task )->where( 'status', 0 )->update( 'tasktimer', array( 'end' => $end, 'end' => $end, 'note' => $_POST[ 'note' ], 'status' => 1 ) );
				$response = $this->db->where( 'id', $_POST[ 'task' ] )->update( 'tasks', array( 'timer' => 0 ) );
				$data['success'] = true;
				$data['message'] = lang('timer_stopped');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function deletefiles() {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'delete' ) ) {
			if ( isset( $_POST[ 'fileid' ] ) ) {
				$file = $_POST[ 'fileid' ];
				$response = $this->db->where( 'id', $file )->delete( 'files', array( 'id' => $file ) );
				$data['success'] = true;
				$data['message'] = lang('files'). ' '.lang('deletemessage');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function add_file( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'edit' ) ) {
			if ( isset( $id ) ) {
				if ( isset( $_POST ) ) {
					if (!is_dir('uploads/files/tasks/'.$id)) { 
						mkdir('./uploads/files/tasks/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/tasks/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					if (isset($_FILES["file"])) {
						$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
						$config['file_name'] = $new_name;
					}
					$this->load->library( 'upload', $config );
					if (!$this->upload->do_upload('file')) {
						$data['success'] = false;
						$data['message'] = $this->upload->display_errors();
						echo json_encode($data);
					} else {
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/tasks/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params = array(
								'relation_type' => 'task',
								'relation' => $id,
								'file_name' => $image_data[ 'file_name' ],
								'created' => date( " Y.m.d H:i:s " ),
								'is_old' => '0'
							);
							$this->db->insert( 'files', $params );
						}
						$template = $this->Emails_Model->get_template('task', 'task_attachment');
						if ($template['status'] == 1) {
							$tasks = $this->Tasks_Model->get_task_detail( $id );
							$task_url = '' . base_url( 'tasks/task/' . $id . '' ) . '';
							switch ( $tasks[ 'status_id' ] ) {
								case '1':
									$status = lang( 'open' );
									break;
								case '2':
									$status = lang( 'inprogress' );
									break;
								case '3':
									$status = lang( 'waiting' );
									break;
								case '4':
									$status = lang( 'complete' );
									break;
								case '5':
									$status = lang( 'cancelled' );
									break;
							};
							switch ( $tasks[ 'priority' ] ) {
								case '1':
									$priority = lang( 'low' );
									break;
								case '2':
									$priority = lang( 'medium' );
									break;
								case '3':
									$priority = lang( 'high' );
									break;
								default: 
									$priority = lang( 'medium' );
									break;
							};
							$message_vars = array(
								'{task_name}' => $tasks[ 'name' ],
								'{task_startdate}' => $tasks[ 'startdate' ],
								'{task_duedate}' => $tasks[ 'duedate' ],
								'{task_priority}' => $priority,
								'{task_url}' => $task_url,'description',
								'{staffname}' => $tasks[ 'assigner' ],
								'{task_status}' => $status,
								'{logged_in_user}' => $this->session->userdata('staffname'),
								'{name}' => $this->session->userdata('staffname'),
								'{email_signature}' => $this->session->userdata('email'),
							);
							$subject = strtr($template['subject'], $message_vars);
							$message = strtr($template['message'], $message_vars);

							$param = array(
								'from_name' => $template['from_name'],
								'email' => $tasks['staffemail'],
								'subject' => $subject,
								'message' => $message,
								'created' => date( "Y.m.d H:i:s" )
							);
							if ($tasks['staffemail']) {
								$this->db->insert( 'email_queue', $param );
							}
						}
						$data['success'] = true;
						$data['message'] = lang('file').' '.lang('uploadmessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function download_file($id) {
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file( $id );
			if ($fileData['is_old'] == '1') {
				if (is_file('./uploads/files/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('tasks/task/'.$fileData['relation']);
		    	}
			} else {
				if (is_file('./uploads/files/tasks/'.$fileData['relation'].'/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/tasks/'.$fileData['relation'].'/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('tasks/task/'.$fileData['relation']);
		    	}
		    }
				
		}
	}

	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'delete' ) ) {
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file($id);
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'files', array( 'id' => $id ) );
					if ($fileData['is_old'] == '1') {
						if (is_file('./uploads/files/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/' . $fileData['file_name']);
				    	}
					} else {
						if (is_file('./uploads/files/tasks/'.$fileData['relation'].'/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/tasks/'.$fileData['relation'].'/' . $fileData['file_name']);
				    	}
					}
			    	if ($response) {
			    		$data['success'] = true;
			    		$data['message'] = lang('file'). ' '.lang('deletemessage');
			    	} else {
			    		$data['success'] = false;
			    		$data['message'] = lang('errormessage');
			    	}
			    	echo json_encode($data);
			    }
			} else {
				redirect('projects');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function add_files( $id ) {
		if ( isset( $id ) ) {
			if ( isset( $_POST ) ) {
				$config[ 'upload_path' ] = './uploads/files/';
				$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
				$this->load->library( 'upload', $config );
				$this->upload->do_upload( 'file_name' );
				$data_upload_files = $this->upload->data();
				$image_data = $this->upload->data();
				//$this->upload->display_errors()
				$params = array(
					'relation_type' => 'task',
					'relation' => $id,
					'file_name' => $image_data[ 'file_name' ],
					'created' => date( " Y.m.d H:i:s " ),
				);
				$this->db->insert( 'files', $params );
				$template = $this->Emails_Model->get_template('task', 'task_attachment');
				if ($template['status'] == 1) {
					$tasks = $this->Tasks_Model->get_task_detail( $id );
					$settings = $this->Settings_Model->get_settings_ciuis();
					$task_url = '' . base_url( 'tasks/task/' . $id . '' ) . '';
					switch ( $tasks[ 'status_id' ] ) {
						case '1':
							$status = lang( 'open' );
							break;
						case '2':
							$status = lang( 'inprogress' );
							break;
						case '3':
							$status = lang( 'waiting' );
							break;
						case '4':
							$status = lang( 'complete' );
							break;
						case '5':
							$status = lang( 'cancelled' );
							break;
					};
					switch ( $tasks[ 'priority' ] ) {
						case '1':
							$priority = lang( 'low' );
							break;
						case '2':
							$priority = lang( 'medium' );
							break;
						case '3':
							$priority = lang( 'high' );
							break;
						default: 
							$priority = lang( 'medium' );
							break;
					};
					$message_vars = array(
						'{task_name}' => $tasks[ 'name' ],
						'{task_startdate}' => $tasks[ 'startdate' ],
						'{task_duedate}' => $tasks[ 'duedate' ],
						'{task_priority}' => $priority,
						'{task_url}' => $task_url,'description',
						'{staffname}' => $tasks[ 'assigner' ],
						'{task_status}' => $status,
						'{company_name}' => $settings['company'],
						'{company_email}' => $settings['email'],
						'{logged_in_user}' => $this->session->userdata('staffname'),
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $tasks['staffemail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" )
					);
					if ($tasks['staffemail']) {
						$this->db->insert( 'email_queue', $param );
					}
				}
				redirect( 'tasks/task/' . $id . '' );
			}
		}
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'all' ) ) {
			$data[ 'tasks' ]  = $this->Tasks_Model->get_task_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tasks', 'own') ) {
			$data[ 'tasks' ]  = $this->Tasks_Model->get_task_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($data[ 'tasks' ]) {
			if ( $this->Privileges_Model->check_privilege( 'tasks', 'delete' ) ) {
				$number = get_number('tasks',$id,'task','task');
				if ( isset( $id ) ) {
					$response = $this->db->where( 'id', $id )->delete( 'tasks', array( 'id' => $id ) );
					$response = $this->db->where( 'id', $id )->delete( 'subtasks', array( 'taskid' => $id ) );
					$response = $this->db->where( 'id', $id )->delete( 'tasktimer', array( 'task_id' => $id ) );
					$response = $this->db->where( 'id', $id )->delete( 'files', array( 'relation_type' => 'task', 'relation' => $id ) );
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'task' ) .' '. $number . '' ),
						'staff_id' => $this->session->usr_id
					) );
					$data['success'] = true;
					$data['message'] = lang('task').' '.lang('deletemessage');
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
			echo json_encode($data);
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tasks'));
		}
	}

	function get_task( $id ) {
		$task = array();
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'all' ) ) {
			$task  = $this->Tasks_Model->get_task_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tasks', 'own') ) {
			$task  = $this->Tasks_Model->get_task_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tasks'));
		}
		if($task) {
			$task = $this->Tasks_Model->get_task_detail( $id );
			if ( $task[ 'milestone' ] != NULL ) {
				$milestone = $task[ 'milestone' ];
			} else {
				$milestone = lang( 'nomilestone' );
			}
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					break;
				case '2':
					$status = lang( 'inprogress' );
					break;
				case '3':
					$status = lang( 'waiting' );
					break;
				case '4':
					$status = lang( 'complete' );
					break;
				case '5':
					$status = lang( 'cancelled' );
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
				default: 
					$priority = lang( 'medium' );
					break;
				case '4':
					$priority = $task[ 'duedate' ];
					break;
			};
			switch ( $task[ 'public' ] ) {
				case '1':
					$is_Public = true;
					break;
				case '0':
					$is_Public = false;
					break;
			}
			switch ( $task[ 'visible' ] ) {
				case '1':
					$is_visible = true;
					break;
				case '0':
					$is_visible = false;
					break;
			}
			switch ( $task[ 'billable' ] ) {
				case '1':
					$is_billable = true;
					break;
				case '0':
					$is_billable = false;
					break;
			}
			switch ( $task[ 'timer' ] ) {
				case '1':
					$is_timer = true;
					break;
				case '0':
					$is_timer = false;
					break;
			}
			$startdate=$task[ 'startdate' ];
			$priority_prefer='';
				  $low= date('Y-m-d', strtotime($startdate. ' + 2 days'));
				  $medium= date('Y-m-d', strtotime($startdate. ' + 3 days'));
				  $high= date('Y-m-d', strtotime($startdate. ' + 5 days'));
				  
				  $today_date=date('Y-m-d');
				  if($task[ 'priority' ]!=4){
						if($today_date <= $low){
							
							$priority_prefer='Low';
							$newpriority='1';
						}else if($today_date == $medium){
							
							$priority_prefer='Medium';
							$newpriority='2';
						}else if($today_date >= $high){
							
							$priority_prefer='High';
							$newpriority='3';
						}
						$params = array(
							
							'priority' => $newpriority,
							
						);
						$this->Tasks_Model->update_task( $task[ 'id' ], $params );
				  }else{
					  $priority_prefer=$priority;
				  }
			$taskdata = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'description' => $task[ 'description' ],
				'staff' => $task[ 'assigner' ],
				'status' => $status,
				'priority' => $priority_prefer,
				'priority_id' => $task[ 'priority' ],
				'status_id' => $task[ 'status_id' ],
				'assigned' => $task[ 'assigned' ],
				'duedate' => date(get_dateFormat(), strtotime($task[ 'duedate' ])),
				'duedate_edit' => $task[ 'duedate' ],
				'startdate' => date(get_dateFormat(), strtotime($task[ 'startdate' ])),
				'startdate_edit' => $task[ 'startdate' ],
				'created' => date(get_dateFormat(), strtotime($task[ 'created' ])),
				'relation_type' => $task[ 'relation_type' ],
				'relation' => $task[ 'relation' ],
				'milestone' => $task[ 'milestone' ],
				'datefinished' => $task[ 'datefinished' ],
				'hourlyrate' => $task[ 'hourly_rate' ],
				'timer' => $is_timer,
				'public' => $is_Public,
				'visible' => $is_visible,
				'billable' => $is_billable,
				'task_number' => get_number('tasks',$task['id'],'task','task'),

			);
			echo json_encode( $taskdata );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tasks'));
		}
	}

	function tasktimelogs( $id ) {
		$timelogs = $this->Tasks_Model->get_task_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $id );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'status' => $timelog[ 'status' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			};
		};
		echo json_encode( $data_timelogs );
	}

	function subtasks( $id ) {
		$subtasks = $this->Tasks_Model->get_subtasks( $id );
		echo json_encode( $subtasks );
	}

	function subtaskscomplete( $id ) {
		$subtaskscomplete = $this->Tasks_Model->get_subtaskscomplete( $id );
		echo json_encode( $subtaskscomplete );
	}

	function taskfiles( $id ) { 
		if (isset($id)) {
			$files = $this->Tasks_Model->get_task_files( $id );
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf') {
					$type = 'pdf';
				}
				if ($ext == 'zip' || $ext == 'rar' || $ext == 'tar') {
					$type = 'archive';
				}
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$display = true;
				} else {
					$display = false;
				}
				if ($ext == 'pdf') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				if ($file['is_old'] == '1') {
					$path = base_url('uploads/files/'.$file['file_name']);
				} else {
					$path = base_url('uploads/files/tasks/'.$id.'/'.$file['file_name']);
				}
				$data[] = array(
					'id' => $file['id'],
					'task_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}

	function get_tasks() {
		$tasks = array();
		//if ( $this->Privileges_Model->check_privilege( 'tasks', 'all' ) ) {
			$tasks = $this->Contacts_Model->get_all_contact_persons();
		//} 
		$data_tasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			/* switch ( $task[ 'status_id' ] ) { 
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = 'done';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = lang( 'project' );
					break;
				case 'ticket':
					$relationtype = lang( 'ticket' );
					break;
				case 'proposal':
					$relationtype = lang( 'proposal' );
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
				case '4':
					$priority = $task[ 'duedate' ];
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			}; 
			$appconfig = get_appconfig();
			
			$staffname=array();
				$taskassigned=explode(',',$task['assigned']);
				foreach($taskassigned as $eachTask){
					$staffdetails=$this->Tasks_Model->get_all_tasks_staff($eachTask);
					if(!empty($staffdetails)){
						$staffname[]=$staffdetails;
					}
				}
				//$staffname=rtrim($staffname,', ');
				$priority_prefer='';
				  $low= date('Y-m-d', strtotime($startdate. ' + 2 days'));
				  $medium= date('Y-m-d', strtotime($startdate. ' + 3 days'));
				  $high= date('Y-m-d', strtotime($startdate. ' + 5 days'));
				  
				  $today_date=date('Y-m-d');
				  if($task[ 'priority' ]!=4){
						if($today_date <= $low){
							
							$priority_prefer='Low';
							$newpriority='1';
						}else if($today_date == $medium){
							
							$priority_prefer='Medium';
							$newpriority='2';
						}else if($today_date >= $high){
							
							$priority_prefer='High';
							$newpriority='3';
						}
						$params = array(
							
							'priority' => $newpriority,
							
						);
						$this->Tasks_Model->update_task( $task[ 'id' ], $params );
				  }else{
					  $priority_prefer=$priority;
				  } */
	
			$data_tasks[] = array(
				'id' => $task[ 'person_id' ],
				'name' => $task[ 'cname' ],
				'address' => $task['address'],
				'cperson' =>  $task['cperson'],
				'cnum' => $task['cnum'],
				'email' => $task['cemail'],
				'keywords' => $task['keyword_content'],
				'created' => $task['created'],
				'type' => $task['type'],
				//'members' => $staffname,
				//'relationtype' => $relationtype,
				//'status' => $status,
				//'status_id' => $task[ 'status_id' ],
				//'duedate' => $duedate,
				//'priority'=>$priority_prefer,
				//'startdate' => $startdate,
				//'done' => $taskdone,
				//'' . lang( 'filterbystatus' ) . '' => $status,
				//'' . lang( 'filterbypriority' ) . '' => $priority,
				//'task_number' => get_number('tasks',$task['id'],'task','task'),
			);
		};
		echo json_encode( $data_tasks );
	}
}
