<?php
class Inventories_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_warehouses( $id ) {
		$this->db->select( '*, warehouses.warehouse_id as id ' );
		return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id ) )->row_array();
	}
	function get_inventory_warehouses( $id ) {
		$this->db->select( '*,inventories.inv_warehouse as id ' );
		return $this->db->get_where( 'inventories', array( 'inventories.inv_warehouse' => $id ) )->row_array();
	}
	function get_all_Status() {
		$this->db->order_by( 'warehouse_id', 'desc' );
		return $this->db->get_where( 'warehouses', array( '' ) )->result_array();
	}
	function get_set_status( $id ) {
		return $this->db->get_where( 'warehouses', array( 'warehouse_id' => $id ) )->row_array();
	}
	function update_status( $id, $params ) {
		$this->db->where( 'warehouse_id', $id );
		return $this->db->update( 'warehouses', $params );
	}
	function remove_status( $id ) {
		$response = $this->db->delete( 'warehouses', array( 'warehouse_id' => $id ) );
	}
	function get_all_supplier_by_search($supplier='') {
		$this->db->select( '*' );
		$this->db->from('vendors');
		$this->db->where('(
			company LIKE "' . $supplier . '%"
		
		)');
		$this->db->order_by('company', 'desc');
		return $this->db->get()->result_array();
		
		
	}
	function add_supplier( $params ) {
		$this->db->insert( 'vendors', $params );
		$supplier_id = $this->db->insert_id();
	
		return $supplier_id;
	}
	
	function get_project_files( $id ) { 
		$this->db->order_by( 'id', 'desc' );
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'vendor', 'files.relation' => $id ) )->result_array();
	}
	
	function get_vendors_documents($id){
		$this->db->select( '*, vendor_documents.vendor_id as id ' );
		return $this->db->get_where( 'vendor_documents', array( 'vendor_documents.vendor_id' => $id ) )->result_array();
	}


	function get_all_vendors() {
		$this->db->select( '*, vendors.id as id ' );
		$this->db->join('vendors_groups','vendors.groupid = vendors_groups.id','left');
		$this->db->order_by( 'vendors.id', 'desc' );
		return $this->db->get_where( 'vendors', array( '' ) )->result_array();
	}

	function add_inventories( $params ) {
		
		$this->db->insert( 'inventories', $params );
		$vendor_id = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['inventory_series'] ? $appconfig['inventory_series'] : $vendor_id;
		$vendor_number = $appconfig['inventory_prefix'].$number;
		$this->db->where('inv_id', $vendor_id)->update( 'inventories', array('inventory_number' => $vendor_number ) );
		
		return $vendor_id;
	}

	function update_vendors( $id, $params ) {
		$appconfig = get_appconfig();
		$vendor_data = $this->get_vendors($id);
		if($vendor_data['vendor_number']==''){
			$number = $appconfig['vendor_series'] ? $appconfig['vendor_series'] : $id;
			$vendor_number = $appconfig['vendor_prefix'].$number;
			$this->db->where('id',$id)->update('vendors',array('vendor_number'=>$vendor_number));
			if(($appconfig['vendor_series']!='')){
				$vendor_number = $appconfig['vendor_series'];
				$vendor_number = $vendor_number + 1;
				$this->Settings_Model->increment_series('vendor_series',$vendor_number);
			}
		}
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'vendors', $params );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated' ) . ' <a href="vendors/vendor/' . $id . '">' . get_number('vendors',$id,'vendor','vendor') . '</a>' ),
			'staff_id' => $this->session->usr_id
		) );
	}

	function delete_warehouses( $id) {
		
			$response = $this->db->delete( 'warehouses', array( 'warehouse_id' => $id ) );
			
			return true;
		
	}

	function get_product_categories() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'inventory_product_categories', array( '' ) )->result_array();
	}
	function get_material_prices($material_id,$supplier_id) {
		$this->db->order_by('vendor_mat_id','desc');
		return $this->db->get_where('vendor_materials',array('material_id' => $material_id,'vendor_id' => $supplier_id))->result_array();
		
	}
	function get_material_suppliers($material_id) {
	    	$this->db->select( '*, vendors.company ' );
		$this->db->join('vendors','vendors.id = vendor_materials.vendor_id','left');
		$this->db->order_by('vendor_mat_id','desc');
		return $this->db->get_where('vendor_materials',array('material_id' => $material_id))->result_array();
		
	}
	function get_material_categories(){
		$this->db->order_by('mat_cat_id','desc');
		return $this->db->get_where( 'material_categories',array( '' ))->result_array();
	}
	function get_material_category_name($id){
		$this->db->order_by('mat_cat_id','desc');
		return $this->db->get_where( 'material_categories',array( 'mat_cat_id' => $id ))->row_array();
	}

		function get_warehouses_all(){
			$sql = "SELECT * FROM warehouses WHERE 1 = 1 order by warehouse_id desc";
			$query = $this->db->query($sql);
			
			$res = $query->result_array();
			
			return $res;
		}
		
		function get_cost_value($material_id){
			
			
		$sql = "SELECT cost,category,unittype FROM materials   WHERE material_id = '$material_id'";
		$query = $this->db->query($sql);
		$res = $query->row_array();
		return $res;
		
			
		}
   function get_product_type() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'inventory_product_type', array( '' ) )->result_array();
		
	}
	function get_move_type() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'inventory_move_type', array( '' ) )->result_array();
	}
	function get_groups($staff_id='') {
		$this->db->select('vendors_groups.name as name, COUNT(vendors_groups.name) as y');
		$this->db->join( 'vendors_groups', 'vendors.groupid = vendors_groups.id', 'left' );
		if($staff_id){
			$this->db->where('staff_id', $staff_id);
		}
		$this->db->group_by('vendors_groups.name'); 
		return $this->db->get_where( 'vendors', array( '' ) )->result_array();
	}

	function get_inv_product_categories( $id ) {
		return $this->db->get_where( 'inventory_product_categories', array( 'id' => $id ) )->row_array();
	}

   function get_inv_product_type( $id ) {
		return $this->db->get_where( 'inventory_product_type', array( 'id' => $id ) )->row_array();
	}
	function get_inv_move_type( $id ) {
		return $this->db->get_where( 'inventory_move_type', array( 'id' => $id ) )->row_array();
	}
	
	function update_product_category( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'inventory_product_categories', $params );
	}

    function update_move_type( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'inventory_move_type', $params );
	}
	function check_product_category($id) {
		$data = $this->db->get_where( 'inventories', array( 'product_category' => $id ) )->num_rows();
		return $data;
	}
    function check_product_type($id) {
		$data = $this->db->get_where( 'inventories', array( 'product_type' => $id ) )->num_rows();
		return $data;
	}
   function check_move_type($id) {
		$data = $this->db->get_where( 'inventories', array( 'move_type' => $id ) )->num_rows();
		return $data;
	}

	function remove_product_category( $id ) {
		$response = $this->db->delete( 'inventory_product_categories', array( 'id' => $id ) );
	}
	function remove_product_type( $id ) {
		$response = $this->db->delete( 'inventory_product_type', array( 'id' => $id ) );
	}
	function remove_move_type( $id ) {
		$response = $this->db->delete( 'inventory_move_type', array( 'id' => $id ) );
	}

 
    function update_inventory($id, $params) {
		$response = $this->db->where('inv_id', $id)->update('inventories', $params);
		
		return $response;
	}
		function delete_inventory($inv_id) {
		return $this->db->delete('inventories', array( 'inv_id' => $inv_id));
	}
function get_inventory_record($id)
	{
		$sql = "SELECT inv.*,inv_prd.name as cat_name,wh.warehouse_name,mv.name as move_name,vnd.company,cust.company as customer_name FROM inventories as inv LEFT JOIN inventory_product_categories as inv_prd ON inv_prd.id = inv.inv_product_category LEFT JOIN warehouses as wh ON wh.warehouse_id = inv.inv_warehouse LEFT JOIN inventory_move_type as mv ON mv.id = inv.inv_move_type LEFT JOIN vendors as vnd ON vnd.id=inv.supplier_id
		LEFT JOIN customers as cust ON cust.id = inv.customer_id WHERE inv_id = '$id'";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		return $result;
		
	}

	function get_all_inventories_by_privileges($staff_id='') {
		$this->db->select( '*, inventories.inv_id as id,staff.staffname,staff.staffavatar,warehouses.warehouse_name,inventory_product_categories.name as product_category_name,inventory_move_type.name as move_type_name');
		$this->db->join('staff','staff.id = inventories.staff_id','left');
		$this->db->join('warehouses','warehouses.warehouse_id=inventories.inv_warehouse','left'
		);
		$this->db->join('inventory_product_categories','inventory_product_categories.id=inventories.inv_product_category','left');
		$this->db->join('inventory_move_type','inventory_move_type.id=inventories.inv_move_type','left');
		$this->db->order_by('inventories.inv_id', 'desc' );
		if($staff_id) {
			return $this->db->get_where( 'inventories', array( 'staff_id' => $staff_id ) )->result_array();
		} else {
			return $this->db->get_where( 'inventories', array( '' ) )->result_array();
		}
	}

	function get_warehouse_by_privileges( $id, $staff_id='' ) {
		$this->db->select( '*, warehouses.warehouse_id as id ' );
		if($staff_id) {
			return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id, 'staff_id' => $staff_id ) )->row_array();
		} else {
			return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id ) )->row_array();
		}
		
	}
	
	function get_vendor_by_licence_Notify(){
		$sql = "SELECT ven.id,ven.company,ven.licence_no FROM vendors as ven where ven.trade_expiry_date !='' AND DATE_SUB(ven.trade_expiry_date,INTERVAL 30 DAY) = CURDATE() AND ven.licence_no !=''  order by ven.id ASC";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	
	function get_materials_keyword($keyword){
		
		$sql = $this->db->query("SELECT * FROM materials WHERE  
		(itemname LIKE '%".$keyword."%' OR itemdescription LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	function get_vendor_keyword($keyword){
		
		$sql = $this->db->query("SELECT * FROM vendors WHERE  
		(company LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
		function get_customer_keyword($keyword){
		
		$sql = $this->db->query("SELECT * FROM customers WHERE  
		(company LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	function get_all_inv_product_categories($keyword){
		
		$sql = $this->db->query("SELECT * FROM inventory_product_categories WHERE  
		(name LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	
	function get_all_inv_product_types($keyword){
		
		$sql = $this->db->query("SELECT * FROM inventory_product_type WHERE  
		(name LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	function get_all_inv_move_types($keyword){
		
		$sql = $this->db->query("SELECT * FROM inventory_move_type WHERE  
		(name LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	function get_all_inv_warehouses($keyword){
		
		$sql = $this->db->query("SELECT * FROM warehouses WHERE  
		(warehouse_name LIKE '%".$keyword."%')");
   
       return  $row = $sql->result_array();
		
	}
	
}