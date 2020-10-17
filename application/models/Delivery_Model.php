<?php
class Delivery_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_customers( $id ) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
	}
	
	function get_all_customers_by_acccess() {
		$this->db->select( '*' );
		$this->db->from('customers');
		$this->db->where('main_sales_person =', $this->session->usr_id);
		$this->db->or_where('find_in_set("'.$this->session->usr_id.'", sales_team) <> 0');
		return $this->db->get()->result_array();
	}
	
	function search_customers_by_access($q) {
		$this->db->select( '*' );
		$this->db->from('customers');
		$this->db->where('(
			email LIKE "%' . $q . '%"
			OR company LIKE "%' . $q . '%"
			OR namesurname LIKE "%' . $q . '%"
		)');
		$this->db->where('main_sales_person =', $this->session->usr_id);
		$this->db->or_where('find_in_set("'.$this->session->usr_id.'", sales_team) <> 0');
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result_array();
	}
	
	function get_customers_sales( $id ) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
	}
	
	function get_customers_estimations( $id ) {
		$this->db->select( '*, customers.id as custid ' );
		$this->db->join('customers','customers.id = estimations.customer_id');
		return $this->db->get_where( 'estimations', array( 'estimations.customer_id' => $id ) )->result_array();
	}
	

	function get_all_customers($staff_id='') {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		$this->db->order_by( 'customers.id', 'desc' );
		if($staff_id) {
			return $this->db->get_where( 'customers', array( 'staff_id' => $staff_id) )->result_array();
		} else {
			return $this->db->get_where( 'customers', array( '' ) )->result_array();	
		}
		
	}

	function get_subsidiaries($id) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->order_by( 'customers.id', 'desc' );
		return $this->db->get_where( 'customers', array( 'customers.subsidiary_parent_id' => $id ) )->result_array();
	}
	
	function add_customers( $params ) {
		$this->db->insert( 'customers', $params );
		$customer_id = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['customer_series'] ? $appconfig['customer_series'] : $customer_id;
		$customer_number = $appconfig['customer_prefix'].$number;
		$this->db->where('id', $customer_id)->update( 'customers', array('customer_number' => $customer_number ) );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'addedacustomer' ) . ' <a href="customers/customer/' . $customer_id . '">' . get_number('customers',$customer_id,'customer','customer') . '</a>' ),
			'staff_id' => $this->session->usr_id
		) );

		$isContact = $this->input->post('contact');
		if ($isContact == '1') {
			$password = password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT );
			if($this->input->post('company')){
				$company = $this->input->post('company');
			} else {
				$company = $this->input->post('namesurname');
			}
			$param = array(
				'name' => $this->input->post('company'),
				'surname' => '',
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'password' => $password,
				'address' => $this->input->post('address'),
				'customer_id' => $customer_id,
			);
			//$contacts_id = $this->Contacts_Model->create( $param );
			$contacts_id = '';
			if($contacts_id){
				$update_contact_privilege = $this->update_contact_privilege($contacts_id, 'true', '1');
				$update_contact_privilege = $this->update_contact_privilege($contacts_id, 'true', '2');
				$update_contact_privilege = $this->update_contact_privilege($contacts_id, 'true', '7');
				$update_contact_privilege = $this->update_contact_privilege($contacts_id, 'true', '9');
				$update_contact_privilege = $this->update_contact_privilege($contacts_id, 'true', '16');

				$template = $this->Emails_Model->get_template('customer', 'new_contact_added');
				if ($template['status'] == 1 ) {
					$message_vars = array(
						'{login_email}' => $this->input->post( 'email' ),
						'{login_password}' => ($this->input->post( 'password' ))?($this->input->post( 'password' )):' ',
						'{app_url}' => '' . base_url( 'area/login' ) . '',
						'{email_signature}' => $this->session->userdata( 'email' ),
						'{name}' => $this->session->userdata( 'staffname' ),
						'{customer}' => $this->input->post( 'name' )
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);
					$param = array(
						'from_name' => $template['from_name'],
						'email' => $this->input->post( 'email' ),
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" ),
					);
					if ($this->input->post( 'email' )) {
						$this->db->insert( 'email_queue', $param );
					}
				}
			}
		}
		return $customer_id;
	}

	function update_contact_privilege( $id, $value, $privilege_id ) {
		if ( $value != 'false' ) {
			$params = array(
				'relation' => ( int )$id,
				'relation_type' => 'contact',
				'permission_id' => ( int )$privilege_id
			);
			$this->db->insert( 'privileges', $params );
			return $this->db->insert_id();
		} else {
			$response = $this->db->delete( 'privileges', array( 'relation' => $id, 'relation_type' => 'contact', 'permission_id' => $privilege_id ) );
		}
	}

	function get_customers_for_import() {     
        $query = $this->db->get('customers');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
	}
	
	function get_customers_documents($id) {
		$this->db->order_by( 'doc_id', 'desc' );
		return $this->db->get_where( 'customer_document', array( 'cust_id'=>$id ) )->result_array();
	}
	function get_customer_groups() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'customergroups', array( '' ) )->result_array();
	}

	function get_groups($staff_id='') {
		$this->db->select('customergroups.name as name, COUNT(customergroups.name) as y');
		$this->db->join( 'customergroups', 'customers.groupid = customergroups.id', 'left' );
		if($staff_id){
			$this->db->where('staff_id', $staff_id);
		}
		$this->db->group_by('customergroups.name'); 
		return $this->db->get_where( 'customers', array( '' ) )->result_array();
	}

	function get_group( $id ) {
		return $this->db->get_where( 'customergroups', array( 'id' => $id ) )->row_array();
	}

	function update_group( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'customergroups', $params );
	}

	function check_group($id) {
		$data = $this->db->get_where( 'customers', array( 'groupid' => $id ) )->num_rows();
		return $data;
	}

	function remove_group( $id ) {
		$response = $this->db->delete( 'customergroups', array( 'id' => $id ) );
	}

    function insert_customers_csv($data) {
		$this->db->insert('customers', $data);
		$customer = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['customer_series'] ? $appconfig['customer_series'] : $customer;
		$customer_number = $appconfig['customer_prefix'].$number;
		$this->db->where('id', $customer)->update( 'customers', array('customer_number' => $customer_number ) );
    }

	function update_customers( $id, $params ) {
		$appconfig = get_appconfig();
		$customer_data = $this->get_customers($id);
		if($customer_data['customer_number']==''){
			$number = $appconfig['customer_series'] ? $appconfig['customer_series'] : $id;
			$customer_number = $appconfig['customer_prefix'].$number;
			$this->db->where('id',$id)->update('customers',array('customer_number'=>$customer_number));
			if(($appconfig['customer_series']!='')){
				$customer_number = $appconfig['customer_series'];
				$customer_number = $customer_number + 1;
				$this->Settings_Model->increment_series('invoice_series',$customer_number);
			}
		}
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'customers', $params );
		$loggedinuserid = $this->session->usr_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="'.base_url().'staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="'.base_url().'customers/customer/' . $id . '">' . get_number('customers',$id,'customer','customer'). '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
	}

	function delete_customers( $id, $number ) {
		$invoice = $this->db->get_where('invoices', array('customer_id' => $id))->num_rows();
		$proposal = $this->db->get_where('proposals', array('relation_type' => 'customer', 'relation' => $id))->num_rows();
		$expense = $this->db->get_where('expenses', array('customer_id' => $id))->num_rows();
		$project = $this->db->get_where('projects', array('customer_id' => $id))->num_rows();
		$ticket = $this->db->get_where('tickets', array('customer_id' => $id))->num_rows();
		$deposit = $this->db->get_where('deposits', array('customer_id' => $id))->num_rows();
		$order = $this->db->get_where('orders', array('relation_type' => 'customer', 'relation' => $id))->num_rows();
		if (($invoice > 0) || ($proposal > 0) || ($expense > 0) || ($project > 0) || ($ticket > 0) || ($deposit > 0) || ($order > 0)) {
			return false;
		} else {
			$response = $this->db->delete( 'customers', array( 'id' => $id ) );
			$response = $this->db->delete( 'contacts', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'logs', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'notifications', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'reminders', array( 'relation_type' => 'customer', 'relation' => $id ) );
			$response = $this->db->delete( 'notes', array( 'relation_type' => 'customer', 'relation' => $id ) );
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' '. $number . '' ),
				'staff_id' => $this->session->usr_id
			) );
			return true;
		}
	}

	function search_json_customer() {
		$this->db->select( 'id customer,type customertype,company company,namesurname individual,' );
		$this->db->from( 'customers' );
		return $this->db->get()->result();
	}

	function get_customers_by_privileges( $id, $staff_id='' ) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		if($staff_id) {
			return $this->db->get_where( 'customers', array( 'customers.id' => $id, 'staff_id' => $staff_id ) )->row_array();
		} else {
			return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
		}
		
	}

	function search_customers($q) {
		$this->db->select( '*' );
		$this->db->from('customers');
		$this->db->where('(
			email LIKE "%' . $q . '%"
			OR company LIKE "%' . $q . '%"
			OR namesurname LIKE "%' . $q . '%"
		)');
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result_array();
	}
	
	function get_CustomerLicenceNotify(){
		$sql = "SELECT cust.id,cust.customer_number,cust.licence_no FROM customers as cust where cust.trade_expiry_date !='' AND DATE_SUB(cust.trade_expiry_date,INTERVAL 30 DAY) = CURDATE() AND cust.licence_no !=''  order by cust.id ASC";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}

	function get_all_customersincompany() {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		return $this->db->get_where( 'customers' )->row_array();
	}

	function get_all_customerstotalinvoice() {
		$sql = "SELECT 
				customers.id,
				customers.customer_number,
				customers.company,
				IFNULL (SUM(invoices.total),0) as revenue
			FROM
				customers
					LEFT JOIN
				invoices ON customers.id = invoices.customer_id
			GROUP BY invoices.customer_id ";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	function get_all_salesdatainvoice() {
		$sql = "	SELECT 
		MONTHNAME(created) as months, SUM(total)as total
	FROM
		invoices
	GROUP BY MONTH(created)";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}

	function get_all_salesstaffamount($departmentid) {
			$sql = "SELECT 
			staffname,staffavatar,staff.id,
			IFNULL(SUM((SELECT 
							SUM(invoices.total) AS revenue
						FROM
							invoices
						WHERE
							customers.id = invoices.customer_id
						GROUP BY invoices.customer_id)),
					0) AS total_sales
		FROM
			staff
				inner JOIN
			customers ON customers.sales_team in (staff.id)
	
		GROUP BY staff.staffname";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}

	function get_all_salesdatainvoicebystaff($staff_id) {
		$sql = "SELECT 
				MONTHNAME(invoices.created) AS months,
				SUM(invoices.total) AS total
			FROM
				invoices
					LEFT JOIN
				customers ON customers.id = invoices.customer_id
			WHERE
				customers.sales_team in ($staff_id)
			GROUP BY MONTH(invoices.created)";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}

	function get_all_custinvoicebystaff($staff_id) {
		$sql = "SELECT 
				customers.id,
				customers.customer_number,
				customers.company,
				IFNULL (SUM(invoices.total),0) as revenue
			FROM
				customers
					LEFT JOIN
				invoices ON customers.id = invoices.customer_id
				WHERE customers.sales_team in ($staff_id)
			GROUP BY invoices.customer_id ";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}


		
	function get_all_staff() {
		$this->db->select( '*' );
		$this->db->from('staff');
		return $this->db->get()->result_array();
	}
	
		
	function get_all_installtion() {
		$this->db->select( '*' );
		$this->db->from('installation');
		return $this->db->get()->result_array();
	}


	function get_installationid( $id ) {
		return $this->db->get_where( 'installation', array( 'id' => $id ) )->row_array();
	}

	function update_installation( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'installation', $params );
	}

	function get_all_delivery() {
		$this->db->select( '*,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,delivery.status_id as status, delivery.id as id, delivery.staff_id as staff_id, customers.email as customeremail,DATE_FORMAT(delivery_date, "%d/%m/%Y") AS deliverydate ,delivery.delivery_number' );
		$this->db->join( 'projects', 'delivery.projectid = projects.id', 'left' );
		$this->db->join( 'customers', 'projects.customer_id = customers.id', 'left' );
		$this->db->order_by( 'delivery.id', 'desc' );
		return $this->db->get( 'delivery' )->result_array();
	}

	function get_all_deliverystatus() {
		$this->db->select( ' SUM(if(delivery.status_id = 1, 1, 0)) AS sumnotstarted,SUM(if(delivery.status_id = 2, 1, 0)) AS sumstarted,SUM(if(delivery.status_id = 3, 1, 0)) AS sumhold,SUM(if(delivery.status_id = 4, 1, 0)) AS sumcancelled,SUM(if(delivery.status_id = 5, 1, 0)) AS sumcomplete' );
		return $this->db->get( 'delivery' )->result_array();
	}
	function get_delivery($delivery_uid) {
		$this->db->select( '*,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,delivery.status_id as status, delivery.id as id, delivery.staff_id as staff_id, customers.email as customeremail ,delivery.address as custaddress,delivery.* ,projects.id as projectid ,delivery.*' );
		$this->db->join( 'projects', 'delivery.projectid = projects.id', 'left' );
		$this->db->join( 'customers', 'projects.customer_id = customers.id', 'left' );
		$this->db->order_by( 'delivery.id', 'desc' );
		return $this->db->get_where( 'delivery', array( 'delivery.id' => $delivery_uid ) )->row_array();
	}
	function GetdeliveryStatusByStage($deliveryid) {
		$totalRows = $this->db->get_where('subdelivery', array('subdelivery.deliveryid' => $deliveryid))->num_rows();
		$completedRows = $this->db->get_where('subdelivery', array('subdelivery.deliveryid' => $deliveryid, 'subdelivery.complete'=>1))->num_rows();
		$data['totalRowsCnt'] = $totalRows;
		$data['completedCnt'] = $completedRows;
		$data['percentageCompetion'] = $totalRows ? number_format($completedRows/$totalRows * 100) : 0;
		return $data;
	}
	function get_subdelivery( $id ) {
		$this->db->select('subdelivery.id, subdelivery.deliveryid, subdelivery.delivery_stage_id, subdelivery.finished, subdelivery.created, subdelivery.staff_id, subdelivery.complete, installation.name as stagename,subdelivery.update');
		$this->db->order_by( 'subdelivery.id', 'desc' );
		$this->db->join( 'installation', 'subdelivery.delivery_stage_id = installation.id');
		return $this->db->get_where( 'subdelivery', array( 'subdelivery.deliveryid' => $id ) )->result_array();
	}
	function get_subdeliverycomplete( $id ) {
		$this->db->select('subdelivery.id, subdelivery.deliveryid, subdelivery.delivery_stage_id, subdelivery.finished, subdelivery.created, subdelivery.staff_id, subdelivery.complete, installation.name as stagename');
		$this->db->order_by( 'subdelivery.id', 'desc' );
		$this->db->join( 'installation', 'subdelivery.delivery_stage_id = installation.id');
		return $this->db->get_where( 'subdelivery', array( 'subdelivery.deliveryid' => $id, 'subdelivery.complete' => 1 ) )->result_array();
	}

	function get_project_files( $id ) { 
		$this->db->order_by( 'id', 'desc' );
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'delivery', 'files.relation' => $id ) )->result_array();
	}
	
	function get_members( $id ) {
		$this->db->select( '*,staff.staffname as member,staff.staffavatar as memberavatar,staff.email as memberemail,deliverymembers.id as id' );
		$this->db->join( 'staff', 'deliverymembers.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'deliverymembers', array( 'deliverymembers.project_id' => $id ) )->result_array();
	}

	function get_last_status( $id ) {
		$this->db->select('subdelivery.id, subdelivery.deliveryid, subdelivery.delivery_stage_id, subdelivery.finished, subdelivery.created, subdelivery.staff_id, subdelivery.complete, installation.name as stagename');
		$this->db->order_by( 'subdelivery.update', 'desc' );
		$this->db->join( 'installation', 'subdelivery.delivery_stage_id = installation.id');
		return $this->db->get_where( 'subdelivery', array( 'subdelivery.deliveryid' => $id, 'subdelivery.complete' => 1 ) )->result_array();
	}

	function remove_installation( $id ) {
		$response = $this->db->delete( 'installation', array( 'id' => $id ) );
	}

	function get_stage( $id ) {
		return $this->db->get_where( 'installation', array( 'id' => $id ) )->row_array();
	}

	function update( $id, $params ) {
		
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'delivery', $params );
		$loggedinuserid = $this->session->usr_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="'.base_url().'staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ).' '.lang('project') . ' <a href="'.base_url().'delivery/delivery/' . $id . '">' . get_number('delivery',$id,'delivery','delivery'). '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( ''.$staffname.' '.lang('updated').' '.lang('delivery') ),
			'staff_id' => $loggedinuserid,
			'project_id' => $id,
		) );
	}

	function StatusMarkAs() {
		$response = $this->db->where( 'id', $_POST[ 'project_id' ] )->update( 'delivery',array( 'status_id' => $_POST[ 'status_id' ] ) );
		
	}


	function get_members_index( $id ) {
		$this->db->select( '*,staff.staffname as member,staff.staffavatar as memberavatar,staff.email as memberemail,deliverymembers.id as id' );
		$this->db->join( 'staff', 'deliverymembers.staff_id = staff.id', 'left' );
		//$this->db->limit(3);
		return $this->db->get_where( 'deliverymembers', array( 'deliverymembers.project_id' => $id ) )->result_array();
	}

	function get_delivery_files( $id ) { 
		$this->db->order_by( 'id', 'desc' );
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'delivery', 'files.relation' => $id ) )->result_array();
	}

	function delete_projects( $id, $number ) { 
		$this->db->delete( 'delivery', array( 'id' => $id ) );
		$this->db->delete( 'notes', array( 'relation' => $id, 'relation_type' => 'delivery' ) );
		$this->db->delete( 'logs', array( 'project_id' => $id ) );
		$this->db->delete( 'deliverymembers', array( 'delivery_id' => $id ) );

		$files = $this->get_delivery_files( $id );
		foreach ($files as $file) {
			if ($file['is_old'] == '1') {
				if (is_file('./uploads/files/' . $file['file_name'])) {
			    	unlink('./uploads/files/' . $file['file_name']);
			    }
			}
		}
		$this->db->delete( 'files', array( 'relation' => $id, 'relation_type' => 'delivery' ) );
		$folder = './uploads/files/delivery/'.$id;
		if(is_dir($folder)) {
			delete_files($folder, true);
			rmdir($folder);
		}
		$loggedinuserid = $this->session->usr_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' ),
			'detail' => ( ' ' .$staffname.' '.lang( 'project_deleted' ).' '.$number.'.'),
			'staff_id' => $loggedinuserid,
		));
		return true;
	}


}
