<?php
include APPPATH . '/third_party/vendor/autoload.php';
use Dompdf\Dompdf;
class Estimations_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_all_clients()
	{	
		$this->db->select( '*');
		return $this->db->get_where( 'client',array( 'status' => 'Active') )->result_array();
	}
	
	function get_client_id( $id ) {
		$this->db->select( '*');
		return $this->db->get_where( 'client',array( 'client_id' => $id) )->row_array();
	}
	
	function get_all_client_contacts()
	{	
		$this->db->select( '*');
		return $this->db->get_where( 'client_contact',array( ) )->result_array();
	}
	function get_client_contacts($client_id)
	{	
		$this->db->select( '*');
		return $this->db->get_where( 'client_contact',array( 'clientid' => $client_id ) )->result_array();
	}
	
	 function get_sales_staff($department_id="") {
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( 'department_id' => $department_id ) )->result_array();
	}
		function get_admin_staff() {
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( 'staff.id' => '1' ) )->result_array();
	}
	
	function get_materials(){
		$this->db->select( '*' );
		return $this->db->get_where('materials',array('others'=>'on'))->result_array();
		
	}
	function get_materials_keyword($keyword){
		
		$sql = $this->db->query("SELECT * FROM materials WHERE others = 'on' and 
		(itemname LIKE '%".$keyword."%' OR itemdescription LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		/*
		$this->db->select( '*' );
		$this->db->from( 'materials' );
		$this->db->where( 'others = "on"' );
		$this->db->where( 'itemname LIKE "%' . $keyword . '%"' );
		$this->db->or_where( 'itemdescription LIKE "%' . $keyword . '%"' );
		 $result= $this->db->get();
		 return $result->result_array();
		 */
		 /*
		 echo $this->db->last_query();
		 exit;
		$this->db->select( '*' );		
		
		 $this->db->get_where('materials',array('others'=>'on',(('itemname LIKE "%' . $keyword . '%"') OR ('itemdescription LIKE "%' . $keyword . '%"'))))->result_array();
		 echo $this->db->last_query();*/
		
	}
	
	function get_materials_keyword_sku($keyword){
		$this->db->select( '*' );
		
		
		return $this->db->get_where('materials',array('others'=>'on','item_code LIKE "%' . $keyword . '%"'))->result_array();
		
	}
	
	function get_mat_data($id)
{
	/*return $this->db->select('*')
	                ->from('materials')
				    ->where(['material_id'=>$id])
				    ->get()
				    ->row();*/
					$this->db->select( '*' );
		$this->db->join( 'material_categories', 'material_categories.mat_cat_id = materials.category', 'left' );
		return $this->db->get_where( 'materials', array( 'materials.material_id' => $id ) )->row();
}

function get_mat_cat_data($id) {
		$this->db->select( 'material_categories.mat_cat_name as mat_category_name,material_categories.mat_cat_id' );
		$this->db->join( 'material_categories', 'material_categories.mat_cat_id = materials.category', 'left' );
		return $this->db->get_where( 'materials', array( 'materials.material_id' => $id ) )->row_array();
	}
	
	function get__mat__cat_data($id)
{
	$this->db->select( 'material_id' );
		return $this->db->get_where('materials',array('category'=>$id))->result_array();
	
}
	
	function get_all_estimations() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar' );
		$this->db->join( 'staff', 'estimations.user_id = staff.id', 'left' );
		$this->db->order_by( 'estimations.estimation_id', 'desc' );
		return $this->db->get( 'estimations' )->result_array();
	}
	function get_estimation_record( $id ) {
		return $this->db->get_where( 'estimations', array( 'estimation_id' => $id ) )->row_array();
	}
	function get_client_record($client_id){
		return $this->db->get_where( 'client', array( 'client_id' => $client_id ) )->row_array();
	}
	function get_client_contact_record($client_id,$contract_id){
		
		return $this->db->get_where( 'client_contact', array( 'clientid' => $client_id ,
															 'client_contact_id' => $contract_id	) )->row_array();
	}
	
	function get_estimation_main_items( $id ) {
		return $this->db->get_where( 'estimations_main_items', array( 'estimation_id' => $id ) )->result_array();
	}
	function get_estimation_sub_items( $id ) {
		$this->db->select( '*' );
		$this->db->join( 'materials', 'materials.material_id = estimations_sub_items.name', 'left' );
		
		return $this->db->get_where( 'estimations_sub_items', array(  'estimation_id' => $id ) )->result_array();
		
		return $this->db->get_where( 'estimations_sub_items', array( 'estimation_id' => $id ) )->result_array();
	}
	
	function get_estimation_documents( $id ) {
	return $this->db->get_where( 'estimations_documents', array( 'estimation_id' => $id ) )->result_array();
	}
	function get_estimation_documents_files( $id ) {
	return $this->db->get_where( 'estimations_documents', array( 'est_doc_id' => $id ) )->row_array();
	}
	function get_all_proposals_by_customer($id) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id' );
		$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		$this->db->order_by( 'proposals.id', 'desc' );
		return $this->db->get_where( 'proposals', array( 'relation_type' => 'customer', 'relation' => $id ) )->result_array();
	}

	function get_all_quotes_by_customer($id) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id' );
		$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		$this->db->order_by( 'proposals.id', 'desc' );
		return $this->db->get_where( 'proposals', array( 'relation_type' => 'customer', 'relation' => $id, 'status_id' => 0, 'is_requested' => '1' ) )->result_array();
	}

	function customer_proposals($id) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id' );
		$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		$this->db->order_by( 'proposals.id', 'desc' );
		return $this->db->get_where( 'proposals', array( 'relation_type' => 'customer', 'relation' => $id ) )->result_array();
	}

	function project_proposals($id) {
		$this->db->select('*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id');
		$this->db->join('staff', 'proposals.assigned = staff.id', 'left');
		$this->db->order_by('proposals.id', 'desc');
		return $this->db->get_where( 'proposals', array( 'proposals.project_id' => $id) )->result_array();
	}

	function get_proposal( $id ) {
		return $this->db->get_where( 'proposals', array( 'id' => $id ) )->row_array();
	}

	function check_project_id($project_id, $proposal_id) {
		$data = $this->db->get_where( 'proposals', array( 'id' => $proposal_id, 'project_id' => $project_id ) )->num_rows();
		if ($data > 1 || $data == 1) {
			return 'exist';
		} else {
			return 'not_exist';
		}
	}

	function get_pro_rel_type( $id ) {
		return $this->db->get_where( 'estimations', array( 'estimation_id' => $id ) )->row_array();
	}

	function get_proposal_by_token( $token ) {
		return $this->db->get_where( 'proposals', array( 'token' => $token ) )->row_array();
	}

	function get_proposals( $id, $rel_type ) {
		if ( $rel_type == 'customer' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,staff.email as staffemail,customers.type as type,customers.company as customercompany,customers.zipcode as zip,customers.email as toemail,customers.namesurname as namesurname,customers.address as toaddress,proposals.status_id as status_id, proposals.id as id ' );
			$this->db->join( 'customers', 'proposals.relation = customers.id', 'left' );
			$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
			return $this->db->get_where( 'proposals', array( 'proposals.id' => $id ) )->row_array();
		} elseif ( $rel_type == 'lead' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,staff.email as staffemail,leads.name as leadname,leads.address as toaddress,leads.email as toemail, proposals.id as id ' );
			$this->db->join( 'leads', 'proposals.relation = leads.id', 'left' );
			$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
			return $this->db->get_where( 'proposals', array( 'proposals.id' => $id ) )->row_array();
		}
	}

	function get_proposal_customer($id) {
		$this->db->select( 'customers.id as customer_id' );
		$this->db->join( 'customers', 'proposals.relation = customers.id', 'left' );
		//$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		return $this->db->get_where( 'proposals', array( 'proposals.id' => $id ) )->row_array();
	}

	function get_proposalitems( $id ) {
		return $this->db->get_where( 'proposalitems', array( 'id' => $id ) )->row_array();
	}
	// GET INVOICE DETAILS

	function get_proposal_productsi_art( $id ) {
		$this->db->select_sum( 'in[total]' );
		$this->db->from( 'proposalitems' );
		$this->db->where( '(proposal_id = ' . $id . ') ' );
		return $this->db->get();
	}

	// CHANCE INVOCE STATUS

	function status_1( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '1' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '1' ) );
	}

	function status_2( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '2' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '2' ) );
	}

	function status_3( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '3' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '3' ) );
	}
	function proposal_add_by_customer( $params ) {
		$this->db->insert( 'proposals', $params );
		$proposal = $this->db->insert_id();
		$this->db->insert( 'items', array(
			'relation_type' => 'proposal',
			'relation' => $proposal,
			'product_id' => '',
			'code' => '',
			'name' => '',
			'description' => '',
			'quantity' => '1',
			'unit' => 'Unit',
			'price' => 0,
			'tax' => 0,
			'discount' => 0,
			'total' => 0,
		) );
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $_SESSION[ 'name' ] . '' . lang( 'isrequested_quote' ) . '' ),
			'customer_id' => $_SESSION[ 'customer' ],
			'staff_id' => $params['addedfrom'],
			'target' => '' . base_url( 'proposals/proposal/' . $proposal . '' ) . ''
		));
		return $proposal;
	}
	// ADD INVOICE
	function proposal_add( $params ) {
		$this->db->insert( 'proposals', $params );
		$proposal = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['proposal_series'] ? $appconfig['proposal_series'] : $proposal;
		$proposal_number = $appconfig['proposal_prefix'].$number;
		$this->db->where('id', $proposal)->update( 'proposals', array('proposal_number' => $proposal_number ) );
		// MULTIPLE INVOICE ITEMS POST
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			$this->db->insert( 'items', array(
				'relation_type' => 'proposal',
				'relation' => $proposal,
				'product_id' => $item[ 'product_id' ],
				'code' => $item[ 'code' ],
				'name' => $item[ 'name' ],
				'description' => $item[ 'description' ],
				'quantity' => $item[ 'quantity' ],
				'unit' => $item[ 'unit' ],
				'price' => $item[ 'price' ],
				'tax' => $item[ 'tax' ],
				'discount' => $item[ 'discount' ],
				'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
			) );
			$i++;
		};
		//LOG
		if ( $this->input->post( 'proposal_type' ) != 'true' ) {
			//NOTIFICATION
			$staffname = $this->session->staffname;
			$staffavatar = $this->session->staffavatar;
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewproposal' ) . '' ),
				'customer_id' => $this->input->post( 'customer' ),  
				'perres' => $staffavatar,
				'target' => '' . base_url( 'area/proposals/proposal/' . $params['token'] . '' ) . ''
			) );
		}
		$appconfig = get_appconfig();
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="proposals/proposal/' . $proposal . '">' . get_number('proposals',$proposal,'proposal','proposal') . '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		return $proposal;
	}

	function update_proposals( $id, $params ) {
		$appconfig = get_appconfig();
		$proposal_data = $this->get_proposal($id);
		if($proposal_data['proposal_number']==''){
			$number = $appconfig['proposal_series'] ? $appconfig['proposal_series'] : $id;
			$proposal_number = $appconfig['proposal_prefix'].$number;
			$this->db->where('id',$id)->update('proposals',array('proposal_number'=>$proposal_number));
			if(($appconfig['proposal_series']!='')){
				$proposal_number = $appconfig['proposal_series'];
				$proposal_number = $proposal_number + 1;
				$this->Settings_Model->increment_series('proposal_series',$proposal_number);
			}
		}
		$this->db->where( 'id', $id );
		$proposal = $id;
		$response = $this->db->update( 'proposals', $params );
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			if ( isset($item[ 'id' ])) {
				$params = array(
					'relation_type' => 'proposal',
					'relation' => $proposal,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				);
				$this->db->where( 'id', $item[ 'id' ] );
				$response = $this->db->update( 'items', $params );
			} 
			if ( empty($item[ 'id' ])) {
				$this->db->insert( 'items', array(
					'relation_type' => 'proposal',
					'relation' => $proposal,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				) );
			}
			$i++;
		};
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		if ( $this->input->post( 'proposal_type' ) != true ) {
			$relation = $this->input->post( 'customer' );
		} else {
			$relation = $this->input->post( 'lead' );
		};
		$appconfig = get_appconfig();
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="proposals/proposal/' . $id . '">' . get_number('proposals',$id,'proposal','proposal') . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $relation,
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedproposal' ) . '' ),
			'customer_id' => $relation,
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/proposal/' . $proposal . '' ) . ''
		) );
		if ( $response ) {
			return "Proposal Updated.";
		} else {
			return "There was a problem during the update.";
		}
	}

	//PROPOSAL DELETE
	function delete_proposals( $id, $number ) {
		$response = $this->db->delete( 'estimations', array( 'estimation_id' => $id ) );
		$response = $this->db->delete( ' estimations_documents', array( 'estimation_id' => $id ) );
		$response = $this->db->delete( ' estimations_main_items', array( 'estimation_id' => $id));
		$response = $this->db->delete( ' estimations_sub_items', array( 'estimation_id' => $id));
		
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$appconfig = get_appconfig();
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . $number . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function cancelled() {
		$response = $this->db->where( 'id', $_POST[ 'proposal_id' ] )->update( 'proposals', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}

	function markas() {
		$response = $this->db->where( 'estimation_id', $_POST[ 'proposal_id' ] )->update( 'estimations', array( 'estimate_status' => $_POST[ 'status_id' ] ) );
	}

	function deleteproposalitem( $id ) {
		$response = $this->db->delete( 'proposalitems', array( 'id' => $id ) );
	}
	public

	function get_proposal_year() {
		return $this->db->query( 'SELECT DISTINCT(YEAR(date)) as year FROM proposals ORDER BY year DESC' )->result_array();
	}

	function update_pdf_status($id, $value){
		$this->db->where('id', $id);
		$response = $this->db->update('proposals',array('pdf_status' => $value));
	}

	function generate_pdf( $id ) { 
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		if (!is_dir('uploads/files/proposals/'.$id)) {
			mkdir('./uploads/files/proposals/'.$id, 0777, true);
		}
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
		$data['country'] = get_country($data[ 'settings' ]['country_id']);
		$data['custcountry'] = get_country($data[ 'proposals' ]['country_id']);
		$data['custstate'] = get_state_name($data['proposals']['state'],$data['proposals']['state_id']);
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$file_name = '' . get_number('proposals', $id, 'proposal', 'proposal') . '.pdf';
		$html = $this->load->view( 'proposals/pdf', $data, TRUE );
		$this->dompdf = new DOMPDF();
		$this->dompdf->loadHtml( $html );
		$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
		$this->dompdf->set_option('isHtml5ParserEnabled', TRUE );
		$this->dompdf->setPaper( 'A4', 'portrait' );
		$this->dompdf->render();
		$output = $this->dompdf->output();
		$result = file_put_contents( 'uploads/files/proposals/'. $id. '/' . $file_name . '', $output );
		$this->update_pdf_status($id, '1');
		$html = null;
		$this->output->delete_cache();
		$this->dompdf->loadHtml(null);
		$this->dompdf = null;
		unset($this->dompdf);
		return true; 
	}

	function get_all_proposals_by_privileges($staff_id='') {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id' );
		$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		$this->db->order_by( 'proposals.id', 'desc' );
		if($staff_id) {
			$this->db->where('(proposals.assigned='.$staff_id.' OR proposals.addedfrom='.$staff_id.')');
			return $this->db->get('proposals')->result_array();
		} else {
			return $this->db->get( 'proposals' )->result_array();
		}
	}

	function get_proposals_by_privileges( $id,  $staff_id='' ) {
		
		if($staff_id){
			$this->db->where('proposals.id' ,$id);
			$this->db->where('(proposals.assigned='.$staff_id.' OR proposals.addedfrom='.$staff_id.')');
			return $this->db->get('estimations')->row_array();
		} else {
			
			return $this->db->get_where( 'estimations', array( 'estimation_id' => $id ) )->row_array();
		}
	}
}
