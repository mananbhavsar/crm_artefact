<?php
class Payroll_Model extends CI_Model {
	private $table = null;

	function __construct() {
		$this->table = 'payslip';
		parent::__construct( $this->table );
	}

	
	function getrecords() {
	   $day = date('d'); 
	   $month = date('m');
	   $year = date('Y');
	   $previous = $month-1;
	   $last = $month-2;
	  // echo $day.'--'.$month.'--'.$year; die;
	   if($day > '25'){
	       $from_date = $year.'-0'.$previous.'-25';
	       $to_date = $year.'-'.$month.'-25';
	      
	   }else{
	       $from_date = $year.'-0'.$last.'-25';
	       $to_date = $year.'-0'.$previous.'-25';
	   }
	   //echo $from_date.'--'.$to_date; die;
	  
	  $sql = "SELECT *,staff.staffname FROM payslip LEFT JOIN staff as staff ON staff.id = payslip.staff_id  WHERE from_date >='$from_date' AND to_date <= '$to_date'";
	  $res = $this->db->query($sql);
	  
	  $result = $res->result_array();
	  
	  return $result;
	  
	  
	/*	$this->db->select( '*,staff.staffname' );
		$this->db->join( 'staff', 'staff.id = payslip.staff_id', 'left' );
		return $this->db->get_where( 'payslip', array( '' ) )->result_array(); */
	}
	function get_payslip_data($from_date,$to_date){
	    
	   $sql = "SELECT * FROM payslip WHERE from_date <= '$from_date' AND to_date >= '$to_date' ";
	  
	   $res = $this->db->query($sql);
	  $result = $res->result_array();
	  
	  return $result;
	    
	}
	
	function get_srequests($staff_id,$from_date,$to_date) {
			
				$sql = "SELECT amount FROM salary_requests as sq  LEFT JOIN staff as st ON st.id = sq.employee_id WHERE sq.type_of_salary = '1' AND  sq.from_date >= '$from_date' AND sq.to_date <= '$to_date' AND sq.status = '2' order by salary_id desc limit 1 ";
				
				return $this->db->query( $sql )->row_array();
				
			
	}
	
	function get_payslip( $id ) {
		$this->db->select( '*,staff.staffname,staff.id' );
		$this->db->join( 'staff', 'staff.id = payslip.staff_id', 'left' );
		
		return $this->db->get_where( 'payslip', array( 'payslip_id' => $id ) )->row_array();
	}
	
	 function get_total_othours($staff_id,$from_date,$to_date){
        
        
        $sql = "SELECT * FROM `staff_ot_hours` WHERE attendance_date >= '$from_date' AND attendance_date <= '$to_date' AND staff_id = $staff_id ";
       // print_r($sql);
        $query = $this->db->query($sql);
		$ot_count = 0;
        $atn_result  =  $query->result_array();
       
        for($i=1;$i<=31;$i++){
         
          foreach($atn_result as $res){
			
            if(  $res['day_'.$i] != ''){
                $ot_count += $res['day_'.$i];
            }
		  }
        }
        
        if($ot_count >=  0)
        
        return $ot_count;
    }
    
    
    	 function get_no_of_absents($staff_id,$from_date,$to_date){
        
        
        $sql = "SELECT * FROM `staff_attendance` WHERE attendance_date >= '$from_date' AND attendance_date <= '$to_date' AND staff_id = $staff_id ";
       // print_r($sql);
        $query = $this->db->query($sql);
		$ab_count = 0;
        $atn_result  =  $query->result_array();
       
        for($i=1;$i<=31;$i++){
         
          foreach($atn_result as $res){
			
            if(  $res['day_'.$i] == 'A'){
                $ab_count += 1;
            }
		  }
        }
        
       
        
        return $ab_count;
    }
    function get_filter_attendance_ot_log($from_date,$to_date,$emp){
		//echo $emp;exit;
      
             $curr_date = $from_date;
             $from_month = date("m", strtotime($curr_date));
        	$from_day = date("d", strtotime($curr_date));
        	$from_year = date("Y",strtotime($curr_date));
        	 
			 $to_month = date("m", strtotime($to_date));
			 $to_day = date("d", strtotime($to_date));
        	$to_year = date("Y",strtotime($to_date));
			$where ='';
			 if($emp != ''){
		 $where .= " AND empl_id = '$emp'";
	 }
			
			     $sql1="Select InTime.empl_id,InTime.time As CheckInTime,OutTime.time As CheckOutTime,st.staffname,InTime.*
From 
    (Select * From attendance_log Where type = 'in'   and punch_date between '".$from_date."' and '".$to_date."' ".$where.") As InTime
    Left Join 
    (Select * From attendance_log Where type = 'Out'  and punch_date between '".$from_date."' and '".$to_date."' ".$where." ) As OutTime	
    On InTime.`empl_id` = OutTime.`empl_id`
    And InTime.time < OutTime.time  
	And InTime.punch_date = OutTime.punch_date
	 JOIN staff as st ON st.id = InTime.empl_id 

 
Group By  InTime.`empl_id`,InTime.`id` order by InTime.empl_id ASC,InTime.punch_date ASC";
$ret = $this->db->query($sql1, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
        //echo '<pre>'; print_r($result); die;
        return $result;
	
		
	} 
function get_time_diff($start_time, $current_time)
{
	
	$start_t = new DateTime($start_time);
$current_t = new DateTime($current_time);

$difference = $start_t ->diff($current_t );

return $return_time = $difference ->format('%H:%I:%S');

}
function get_salary_info_details($staff_id){
    $sql = "SELECT *  FROM staff WHERE staff.id = '$staff_id' ";
    
    $res = $this->db->query($sql);
    $result = $res->row_array();
    return $result;
}

}