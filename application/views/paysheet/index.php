<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.pen body {
	padding-top:50px;
}

/* Social Buttons - Twitter, Facebook, Google Plus */
.btn-twitter {
	background: #00acee;
	color: #fff
}
.btn-twitter:link, .btn-twitter:visited {
	color: #fff
}
.btn-twitter:active, .btn-twitter:hover {
	background: #0087bd;
	color: #fff
}

.btn-instagram {
	color:#fff;
	background-color:#3f729b;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:focus,.btn-instagram.focus {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:hover {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}

.btn-github {
	color:#fff;
	background-color:#444;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:focus,.btn-github.focus {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:hover {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}

/* MODAL FADE LEFT RIGHT BOTTOM */
.modal.fade:not(.in).left .modal-dialog {
	-webkit-transform: translate3d(-25%, 0, 0);
	transform: translate3d(-25%, 0, 0);
}
.modal.fade:not(.in).right .modal-dialog {
	-webkit-transform: translate3d(25%, 0, 0);
	transform: translate3d(25%, 0, 0);
}
.modal.fade:not(.in).bottom .modal-dialog {
	-webkit-transform: translate3d(0, 25%, 0);
	transform: translate3d(0, 25%, 0);
}

.modal.right .modal-dialog {
	position:absolute;
	top:0;
	right:0;
	margin:0;
}

.modal.left .modal-dialog {
	position:absolute;
	top:0;
	left:0;
	margin:0;
}

.modal.left .modal-dialog.modal-sm {
	max-width:300px;
}

.modal.left .modal-content, .modal.right .modal-content {
    min-height:100vh;
	border:0;
}

.modal-header {
   
    background-color: #000000	;

 }
.modal-title {
    color: white !important;
	line-height:0.42857143;
	font-size: 20px;
    letter-spacing: .005em;
  }
  .ciuis-invoice-summaries-b1{
	  width:20% !important;
  }
  .ciuis-invoice-summaries-b1 .box-content .percentage
  {
	  left:40%!important;
  }
  .select2-default {
	  color: rgba(0,0,0,0.12) !important;
	  border-color:rgba(0,0,0,0.12) !important;
	  font-family:inherit !important;
	  font-size:inherit !important;
	  
  }
  .md-dialog-container,.md-open-menu-container{
	  z-index:2000;
  }
  .tiptext {
}
.description {
    display:none;
    position:absolute;
}
</style>
<div class="ciuis-body-content" ng-controller="Orders_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
    <div class="panel-heading"> <strong><?php //echo lang('ContactsList') ?></strong> <span class="panel-subtitle"><?php //echo lang('ordersituationsdesc') ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'1'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'1'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'2'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'3'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'4'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('revised')?></span>
      </div> -->
     <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> <span class="task-stat-all" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'5'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php //echo lang('Total Contacts')?></span>
      </div> -->
    <!--  <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> <span class="task-stat-all" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'6'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php //echo lang('Total Contacts')?></span>
      </div>  -->
    </div>
  </div>
  <div class="main-content container-fluid col-xs-16 col-md-12 col-lg-12">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('Payroll'); ?> <small>(<span ng-bind="'<?php echo count($getpayslip); ?>'"></span>)</small><br>
         <b style='color:red'><?php echo date('Y-m',strtotime($to_date)); ?></b></h2>
        <!-- <div class="ciuis-external-search-in-table">
          <input ng-model="order_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php //echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button onclick="update()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button> -->
        <?php //if (check_privilege('contacts', 'create')) { ?>
          
		 <!--  <md-menu>
		<md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
         <md-menu-content width="4">
		 <md-menu-item>
          <a href="<?php //echo base_url('payroll/create') ?>">Payslip Entry</a>
		  </md-menu-item>
		  <md-menu-item>
          <a href="<?php //echo base_url('paysheet');?>">Payroll</a>
		  </md-menu-item>
		  
		   </md-menu-content>
		   </md-menu> -->
           
        <?php //} ?>
      </div>
    </md-toolbar>
	<form id="form1" method="post" action="<?php print base_url().'paysheet/create';?>"> 
    <md-content ng-show="!contactsListLoader" class="bg-white" >
      <md-table-container >
        <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
			 <th md-column><span>Select All</span></br>
			 <input type="checkbox" onchange="select_all(this.value)" id="select_chk" /></th>
              <th md-column><span><?php echo '#'; ?></span></th>
              <th md-column ><span><?php echo 'Name'; ?></span></th>
              <th md-column ><span><?php echo 'Working Days'; ?></span></th>
              <th md-column ><span><?php echo 'Absents'; ?></span></th>
              <th md-column ><span><?php echo 'OT Hrs'; ?></span></th>
              <th md-column ><span><?php echo 'OT Amt'; ?></span></th>
            <!--  <th md-column ><span><?php //echo 'Advance'; ?></span></th> -->
              <th md-column ><span><?php echo 'Incentives'; ?></span></th>
              <th md-column ><span><?php echo 'Deductions'; ?></span></th>
			  <th md-column ><span><?php echo 'Total Salary'; ?></span></th>
            </tr>
          </thead>
		 
          <tbody md-body>
		 
            <?php 
			
			$j = 1; 
			$tot = 0;
			foreach ($staff as $key => $value) {
				
				$ci =& get_instance();
$ci->load->model('Attendance_Model');
$ci->load->model('Payroll_Model');

$attend_details = $this->Payroll_Model->get_filter_attendance_ot_log($from_date,$to_date,$value['id']);
//print_r($attend_details);
$attend_details = '';
$absent=0;
  $present=0;
  $latein=0;
   $ontime=0;
   
 $ot_hours = 0;
$absents = 0;
foreach($attend_details as $details) {  
$gettime=$this->Attendance_Model->get_attendance_time($details['empl_id']);
				$starttime='';
						$endtime='';
						if($gettime!=''){
							
										 $starttime= $gettime['start_time'];
										 $endtime= $gettime['end_time'];
									
						}
						$timings = $ci->Attendance_Model->get_attendance_time(($details["empl_id"]));
$next_day_continuation = $ci->Attendance_Model->next_day_continuation($details["punch_date"],$details["empl_id"]);
$break_timings = $ci->Attendance_Model->get_break_timings($details["empl_id"]);


$time1 = strtotime($details['CheckInTime']);
$time2 = strtotime($details['CheckOutTime']);
$st_time = strtotime($timings['start_time']);
$et_time = strtotime($timings['end_time']);
$ot_allow_time = strtotime($timings['late_out_count_time']);
$in_ot_allow_time = $timings['late_in_count_time'];
$in_end_grace_time =  strtotime("".$in_ot_allow_time." minutes", strtotime($timings['start_time']));
$in_start_grace_time =  strtotime("-".$in_ot_allow_time." minutes", strtotime($timings['start_time']));

 $in_start_grace = date('H:i:s', $in_start_grace_time); 
 $in_end_grace = date('H:i:s', $in_end_grace_time); 
 
 $out_end_grace_time =  strtotime("".$in_ot_allow_time." minutes", strtotime($timings['end_time']));
 
 $out_start_grace_time =  strtotime("-".$in_ot_allow_time." minutes", strtotime($timings['end_time']));


$out_start_grace = date('H:i:s', $out_start_grace_time); 
 $out_end_grace = date('H:i:s', $out_end_grace_time); 

$timediff = '-';
$ottimediff = '-';
$pr_status = '-'; 

$break_hrs = '-';
$total = 0;

foreach($break_timings as $break){
    $br_start = strtotime($break['start_time']);
    $br_end = strtotime($break['end_time']);
    if($time1 != '' && $time2 != ''){
    if($time1 < $br_start && $time2 > $br_end){
    
    $break_hrs = $this->Attendance_Model->get_time_difference($break['end_time'],$break['start_time']);
    $temp = explode(":", $break_hrs); 
      
    // Convert the hours into seconds 
    // and add to total 
    $total+= (int) $temp[0] * 3600; 
      
    // Convert the minutes to seconds 
    // and add to total 
    $total+= (int) $temp[1] * 60; 
      
    // Add the seconds to total 
    $total+= (int) $temp[2]; 
    
}

}
}
$formatted = sprintf('%02d:%02d:%02d',  
                ($total / 3600), 
                ($total / 60 % 60), 
                $total % 60); 
if($time1 != '' && $time2 != ''){
//echo ($time1.'--'.strtotime($timings['start_time']));
    if($time1 < $st_time ){
      $ottimediff= $this->Attendance_Model->get_time_diff($timings['start_time'],$details['CheckInTime']);
      $ot_hours += $ottimediff;
       
$timediff= $this->Attendance_Model->get_time_difference($details['CheckOutTime'],$timings['start_time']);
	$pr_status = 'Present';
	
	}
else if($time1 >= $st_time && $time1 <= $et_time ){
	   // echo 'sas';
	    if($details['CheckOutTime'] != '' && $time2 > $out_end_grace_time){
	        	$ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$out_end_grace);
				$ot_hours += $ottimediff;
	    }
	    else{
	        $ottimediff = '-';
	    }

 if($details['CheckOutTime'] > $timings['end_time']){
	        	$timediff= $this->Attendance_Model->get_time_difference($timings['end_time'],$details['CheckInTime']);
	    }else {
	    	$timediff= $this->Attendance_Model->get_time_difference($details['CheckOutTime'],$details['CheckInTime']);
	    }
	   $pr_status = 'Present';
}
else if($time1 >= $out_end_grace_time){
	      
	    	$ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$details['CheckInTime']);
			$ot_hours += $ottimediff;
	    	$timediff = '-';
	    	$pr_status = 'OT';
	    
	}
	 else if($next_day_continuation == '1' && $details['CheckOutTime'] != ''){
	  
	    $timediff= $this->Attendance_Model->get_time_difference($timings['end_time'],$details['CheckInTime']);
	    
	    $ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$out_grace_end);
		$ot_hours += $ottimediff;
	    $pr_status = 'Present';
     }
	else { $timediff= '-';
           $ottimediff = '-'; 
	    $pr_status = '-';
	}
}
else if($time2 == ''){
     if($details['CheckOutTime'] == '' && $next_day_continuation == '1'){
	  
	   // $timediff= $this->Attendance_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	   $timediff = '-';
	    $ottimediff = $this->Attendance_Model->get_time_diff('24.00',$details['CheckInTime']);
		$ot_hours += $ottimediff;
	    $pr_status = 'OT';
     }else if($details['CheckOutTime'] == '' && $next_day_continuation != '1'){
	  
	   // $timediff= $this->Attendance_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	   $timediff = '-';
	    $ottimediff = '-';
	    $pr_status = 'Absent';
		$absents += 1;
     }
     
 }
 else { $timediff= '-';
           $ottimediff = '-'; 
     $pr_status = 'Absent';
	 $absents += 1;
 }
 
 if($details['CheckInTime'] == '00:00:00'){
      $timediff = '-';
       $ottimediff = $this->Attendance_Model->get_time_diff('00.00',$details['CheckOutTime']);
	   $ot_hours += $ottimediff;
       $pr_status = 'Present';
 }
 $otstatus='';
 //echo $timediff;
 if($timediff != '-'){
 $tot_diff = $this->Attendance_Model->get_time_diff($timediff,$formatted);
 }else{
    $tot_diff = '-'; 
 }
 
 

 
}
   ?>
 
           <?php  $working_days = 30-$absents; 
		  $staff_details = $this->Payroll_Model->get_staff_details_info($value['id']);
		  $advance = $this->Payroll_Model->get_srequests($value['id'],$from_date,$to_date);
		  $pay_record = $this->Payroll_Model->get_payslip_record($value['id'],$from_date,$to_date);
		  
		  $date1 = date_create($from_date);
$date2 = date_create($to_date);
$diff = date_diff($date1,$date2);
$total_days = $diff->format("%a");
?>
		   <input type="hidden" name="total_days" id="total_days" value="<?php echo $total_days; ?>" />
            <tr class="select_row" md-row  class="cursor" >
			 <td md-cell>
			 <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date;?>" />
			 <input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date;?>" />
			 
                <input type="checkbox" name="empl_id<?php echo $value['id'];?>"  class='chk'  />
               <input type="hidden" name="emp_id<?php echo $value['id'];?>" value="<?php echo $value['id']; ?>" />
              </td>
              <td md-cell>
                <strong>
                 <span><?php echo $j;?></span>
                </strong><br>
               
              </td>
             
              <td md-cell>
                <strong><span><?php echo $value['staffname']; ?></span></strong>
              </td>
              <td md-cell>
                <strong><span><?php $basic =  round( ($staff_details['basic_salary']*$working_days)/30); echo $working_days;
		?></span></strong> 
			
		  <input type="hidden" name="basic_salary<?php echo $value['id'];?>" id="basic_salary<?php echo $value['id'];?>" class="amt<?php echo $value['id'];?>" value="<?php echo round( ($staff_details['basic_salary']*$working_days)/30); ?>"/>
		</td>
			
		  <input type="hidden" name="present_days<?php echo $value['id'];?>" id="present_days<?php echo $value['id'];?>" value="<?php echo $working_days; ?>" />
		  <input type="hidden" name="lop_days<?php echo $value['id'];?>" id="lop_days<?php echo $value['id'];?>" value="<?php echo $absents; ?>" />
             
                <td md-cell>
                <strong><span><?php $allw = round(($staff_details['allowance']*$working_days)/30); echo $absents; ?></span></strong>
              </td>
			  <input type="hidden" name="allowance<?php echo $value['id'];?>" id="allowance<?php echo $value['id'];?>" class="amt<?php echo $value['id'];?>" value="<?php echo round(($staff_details['allowance']*$working_days)/30);
	  ?>">
               <td md-cell>
                <strong><span><?php  echo $ot_hours;  ?></span></strong>
              </td>
			   <input type="hidden" name="ot_per_hour<?php echo $value['id'];?>" id="ot_per_hour<?php echo $value['id'];?>" value="<?php echo $staff_details['over_time'];?>">
		  <input type="hidden" name="ot_hours<?php echo $value['id'];?>" id ="ot_hours<?php echo $value['id'];?>" value="<?php echo $ot_hours; ?>" >
              <td md-cell>
                <strong><span><input type="hidden" name="ot_amount<?php echo $value['id'];?>" id ="ot_amount<?php echo $value['id'];?>"  class="amt<?php echo $value['id'];?>" value="<?php echo $ot_hours*$staff_details['over_time'];?>"><span id="ot_full_amount"><?php  $ot_amt = $ot_hours*$staff_details['over_time'];  echo $ot_amt; ?> </span></span></strong>
              </td>
			<!--  <td md-cell><span><?php //if(empty($advance['amount'])){ echo '0'; } else { echo  $advance['amount']; } ?> </span> -->
			  
		  <input type="hidden" name="advance<?php echo $value['id'];?>" id="advance<?php echo $value['id'];?>" class="amt_d<?php echo $value['id'];?>" value="<?php if(empty($advance['amount'])){ echo '0'; } else { echo  $advance['amount']; } ?>"></td>
              <td md-cell>
                  <?php if($pay_record['incentives'] != '') { ?>
                  <input type="number" name="incentives<?php echo $value['id'];?>" id="incentives<?php echo $value['id'];?>" class="amt<?php echo $value['id'];?>" value="<?php echo $pay_record['incentives'];?>" onchange="enter_incentives(this.value,<?php echo $value['id'];?>);" style="width:90px;">
                  <?php } else { ?>
                <input type="number" name="incentives<?php echo $value['id'];?>" id="incentives<?php echo $value['id'];?>" class="amt<?php echo $value['id'];?>" value="0" onchange="enter_incentives(this.value,<?php echo $value['id'];?>);" style="width:90px;">
                <?php } ?>
              </td>
              <td md-cell>
 <?php if($pay_record['deductions'] != '') { ?>
                <input type="number" name="deduc<?php echo $value['id'];?>" id="deduc<?php echo $value['id'];?>" class="amt_d<?php echo $value['id'];?>" value="<?php echo $pay_record['deductions'];?>" onchange="enter_deducs(this.value,<?php echo $value['id'];?>);" style="width:90px;">
                 <div class="tiptext" style="margin-left:130px;margin-top:-20px;"> <i class="fa fa-comments" aria-hidden="true"></i>
<div class="description"><textarea name="comments<?php echo $value['id'];?>"
id="comments<?php echo $value['id'];?> " rows="5" cols="20"><?php echo $pay_record['comments'];?></textarea></div>
                </div>
                <?php } else { ?>
                <input type="number" name="deduc<?php echo $value['id'];?>" id="deduc<?php echo $value['id'];?>" class="amt_d<?php echo $value['id'];?>" value="0" onchange="enter_deducs(this.value,<?php echo $value['id'];?>);" style="width:90px;">
                 <div class="tiptext" style="margin-left:130px;margin-top:-20px;"> <i class="fa fa-comments" aria-hidden="true"></i>
<div class="description"><textarea name="comments<?php echo $value['id'];?>"
id="comments<?php echo $value['id'];?> " rows="5" cols="20"></textarea></div>
                </div>
                <?php } ?>
              </td>
               <td md-cell>
                   <?php if($pay_record['staff_id'] == '') { ?>
                <strong><span id="tot_amt<?php echo $value['id'];?>"><?php echo ($basic+$ot_amt+$allw)-$advance['amount']; ?></span></strong>
				 
				<input type="hidden" name="tot_sal<?php echo $value['id'];?>" id="tot_sal<?php echo $value['id'];?>" value="<?php echo ($basic+$ot_amt+$allw)-$advance['amount']; ?>" />
				<input type="hidden" name="tot_earn<?php echo $value['id'];?>" id="tot_earn<?php echo $value['id'];?>" value="<?php echo ($basic+$ot_amt+$allw)-$advance['amount']; ?>" />
				<?php } else { ?>
				 <strong><span id="tot_amt<?php echo $value['id'];?>"><?php echo ($basic+$ot_amt+$allw+$pay_record['incentives'])-($advance['amount']+$pay_record['deductions']); ?></span></strong>
				<input type="hidden" name="tot_sal<?php echo $value['id'];?>" id="tot_sal<?php echo $value['id'];?>" value="<?php echo ($basic+$ot_amt+$allw+$pay_record['incentives'])-($advance['amount']+$pay_record['deductions']); ?>" />
				<input type="hidden" name="tot_earn<?php echo $value['id'];?>" id="tot_earn<?php echo $value['id'];?>" value="<?php echo ($basic+$ot_amt+$allw+$pay_record['incentives'])-($advance['amount']+$pay_record['deductions']); ?>" />
				<?php } ?>
				
              </td>
            </tr>
          <?php $j++; } ?>
		  <tr>
		  <td>
		   <input type="submit" name="add" value="Add" align="center" />
          </td>
          </tr>		  
		  
		  
          </tbody>
		 
        </table>
      </md-table-container>
      <md-table-pagination ng-show="orders.length > 0" md-limit="order_list.limit" md-limit-options="limitOptions" md-page="order_list.page" md-total="{{orders.length}}"></md-table-pagination>
      <md-content ng-show="!orders.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
    </md-content>
	</form>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in orders[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill' && prop != 'status' && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type' && prop != 'customer_email'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
            <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
              <md-option value="all"><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
            </md-select>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbyassigned') ?>'">
            <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
              <md-option value="all"><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
            </md-select>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
  <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">
 <div class="modal-header">
 
        <h4 class="modal-title">Filter</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>

<div class="modal-body">
<form id="form1" method="post" action="<?php print base_url().'payroll/payslip_excel';?>">
<div class="row" id="emp"><div class="form-group col-md-12">
<h4 class="text-muted text-uppercase"><strong class="ng-binding">filterbydate</strong></h4>
<div class="labelContainer">
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="fromdatetime" placeholder="<?php echo lang('from') ?>" show-todays-date="" minutes="false" ng-change="changeDate(prop)" show-icon="true" ng-model="filter_from_dt" class=" dtp-no-msclear dtp-input md-input" name="from_date">
					</div>
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="todatetime" placeholder="<?php echo lang('to') ?>" show-todays-date="" minutes="true" show-icon="true" ng-change="changeDate(prop)" ng-model="filter_to_dt" class=" dtp-no-msclear dtp-input md-input" name="to_date">
					</div>
				</div></br></br>
				<div class="col-md-12">
<input type="submit" class="btn btn-success col-md-12"  value="Export Excel">
</div>
</div>
</form>
<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>

 
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<script>
$(".tiptext").mouseover(function() {
    $(this).children(".description").show();
}).mouseout(function() {
    $(this).children(".description").hide();
});

function enter_incentives(inc,empl_id){
	
	        tot_sal = 0;
    
					$('input.amt'+empl_id).each(function() { 
						var value = parseFloat($(this).val());
						//alert(value);
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
					
					
			tot_ded = 0;	

					$('input.amt_d'+empl_id).each(function() { 
						var value1 = parseFloat($(this).val());
					
					if (!isNaN(value1)){ 
					
					tot_ded += value1;
					
					}
					
					});
				
	
	$('#tot_earn'+empl_id).val((tot_sal));
	$('#tot_amt'+empl_id).html((tot_sal)-(tot_ded));
	$('#tot_sal'+empl_id).val((tot_sal)-(tot_ded));
}
function enter_deducs(inc,empl_id){
	        tot_sal = 0;
					$('input.amt'+empl_id).each(function() { 
						var value = parseFloat($(this).val());
						//alert(value);
					if (!isNaN(value)){ 
					tot_sal += value;
					}
					});
			tot_ded = 0;	
					$('input.amt_d'+empl_id).each(function() { 
						var value1 = parseFloat($(this).val());
					if (!isNaN(value1)){ 
					tot_ded += value1;
					}
					});
	$('#tot_earn'+empl_id).val((tot_sal));
	$('#tot_amt'+empl_id).html((tot_sal)-(tot_ded));
	$('#tot_sal'+empl_id).val((tot_sal)-(tot_ded));
}
function select_all(val){
	
	var isChecked = $("#select_chk").is(":checked");
	if(isChecked == true){
	$(".chk").prop("checked","checked");
	}else{
		$(".chk").prop("checked",false);
	}
}
function update(){
	 
	 $("#sidebar-right").modal ("show");
	 
	 return false;
	  $.ajax({
              url : "<?php echo base_url(); ?>attendance/search_atten",
              data:{},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				  $('#update_details').html(response);
	 $("#sidebar-right").modal ("show");
	 $('#emps').select2({ });
	  $('#depts').select2({ });
	 
	 var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
			  }
	  });
 }
</script> 