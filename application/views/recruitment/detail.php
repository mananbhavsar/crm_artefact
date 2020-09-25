<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<md-content class="ciuis-body-content" ng-controller="Recruitment_Controller">
	<md-content class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools bg-white">
				<div class="col-sm-10 pull-left">
				    <span style="font-size: 16px;"><strong>Candidate Name: </strong><?php echo $recruitment["applicant_name"];?></span><br>
				</div>
				<div class="col-sm-3 text-right">
					<?php
					if (check_privilege('recruitment', 'delete')) { ?> 
						<md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
							<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
							<md-icon><i class="ion-compose  text-muted"></i></md-icon>
						</md-button>
						<a href="<?php echo site_url() ?>recruitment/delete_recruitment/<?php echo $recruitment['candidate_id'] ?>"><i class="fa fa-trash"></i></a>
						<?php } if (check_privilege('recruitment', 'edit')) { ?> 
						<md-menu md-position-mode="target-right target" ng-cloak>
							
							<md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
								<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
							</md-button>
							<md-menu-content width="4" >
								<md-menu-item ng-repeat="status in statuss">
									<md-button ng-click="MarkAs(status.id,status.name)"  ng-bind="status.name" aria-label="Open"></md-button>
								</md-menu-item>
							</md-menu-content>
						</md-menu>
					<?php } ?>
				</div>
			</div>
		</md-toolbar>
		<div ng-show="taskLoader" layout-align="center center" class="text-center" id="circular_loader">
			<md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
			<p style="font-size: 15px;margin-bottom: 5%;">
				<span>
					<?php echo lang('please_wait') ?> <br>
					<small><strong><?php echo lang('loading'). ' '. lang('Recruitment').'...' ?></strong></small>
				</span>
			</p>
		</div>
		<md-content ng-show="!taskLoader" layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
			<md-tabs md-dynamic-height md-border-bottom>
				<md-tab label="<?php echo 'View Form'; ?>">
					<br>
					<div class="ciuis-ticket-row">
						<div class="ciuis-ticket-fieldgroup">
							<div class="ticket-label"><?php echo lang('Applicant Name')?></div>
							<div class="ticket-data"><?php echo $recruitment["applicant_name"];?></div>
						</div>
						<div class="ciuis-ticket-fieldgroup">
							<div class="ticket-label"><?php echo 'Position Applied For'?></div>
							<div class="ticket-data" ><?php echo $recruitment["position_applied_for"];?> </div>
						</div>
					</div>
					<div class="ciuis-ticket-row">
						<div class="ciuis-ticket-fieldgroup">
							<div class="ticket-label"><?php echo lang('Date')?></div>
							<div class="ticket-data" ><?php echo date('d-m-Y',strtotime($recruitment["entered_date"])); ?> </div>
						</div>
						<div class="ciuis-ticket-fieldgroup">
							<div class="ticket-label">
								<?php echo lang('status')?>
							</div>
							<div class="ticket-data label-status" >
							<span ng-if="<?php echo $recruitment["status"];?>==1">
								<strong ><label class="label label-info">Awaiting Review</label></strong>
							</span>
							<span ng-if="<?php echo $recruitment["status"];?>==2">
								<strong ><label class="label label-warning">Reviewed</label></strong>
							</span>
							<span ng-if="<?php echo $recruitment["status"];?>==3">
								<strong ><label class="label label-warning">Screened</label></strong>
							</span>
							<span ng-if="<?php echo $recruitment["status"];?>==4">
								<strong ><label class="label label-primary">Interviewed</label></strong>
							</span>
							<span ng-if="<?php echo $recruitment["status"];?>==5">
								<strong ><label class="label label-success">Hired</label></strong>
							</span>
							<span ng-if="<?php echo $recruitment["status"];?>==6">
								<strong ><label class="label label-danger">Rejected</label></strong>
							</span> </div>
						</div>
					</div>
					<div class="ciuis-ticket-row">
						<div class="ciuis-ticket-fieldgroup">
							<div class="ticket-label">
								<?php echo lang('Location')?>
							</div>
							<div class="ticket-data"><?php echo $recruitment["location"];?> </div>
						</div>
					</div>
				</md-tab>
				<md-tab label="<?php echo lang('notes'); ?>">
					<md-content class="md-padding bg-white">
						<section class="ciuis-notes show-notes">
							<article ng-repeat="note in notes" class="ciuis-note-detail">
								<div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt=""
								width="50" height="50" /> </div>
								<div class="ciuis-note-detail-body">
									<div class="text">
										<p> <span ng-bind="note.description"></span> 
											<a ng-click='DeleteNote($index)'style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a>
										</p>
									</div>
									<p class="attribution"> by <strong>
										<a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}"
										ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span>		
									</p>
								</div>
							</article>
						</section>
						<section class="md-pb-30">
							<md-input-container class="md-block">
								<label><?php echo lang('description') ?></label>
								<textarea required name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
							</md-input-container>
							<div class="form-group pull-right">
								<button ng-click="AddNote()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
								  type="submit">
								  <?php echo lang('addnote')?>
								</button>
							</div>
						</section>
					</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('Schedule interview'); ?>">
					<md-list ng-cloak>
						<md-toolbar class="toolbar-white">
							<div class="md-toolbar-tools">
								<h2><?php echo lang('Schedule interview') ?></h2>
								<span flex></span>
								<md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip" aria-label="Add Reminder">
									<md-tooltip md-direction="left"><?php echo lang('Add Schedule interview') ?></md-tooltip>
									<md-icon><i class="ion-plus-round text-success"></i></md-icon>
								</md-button>
							</div>
						</md-toolbar>
						<md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)"
						  class="noright"> <img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
							<p>{{ reminder.description }}</p>
							<md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3">
								<md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
								<i class="ion-ios-calendar-outline"></i>
							</md-icon>
							<md-icon ng-click="DeleteReminder($index)" aria-label="Send Email" class="md-secondary md-hue-3">
								<md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
								<i class="ion-ios-trash-outline"></i>
							</md-icon>
						</md-list-item>
					</md-list>
				</md-tab>
			</md-tabs>
	
		</md-content>
	</md-content>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
				<h2 flex md-truncate><?php echo lang('Update') ?></h2>
			</div>
		</md-toolbar>
		<md-content layout-padding="">
			<md-content class="bg-white" layout-padding ng-cloak>
				<form action="<?php echo base_url('recruitment/update/'.$recruitment['candidate_id'])?>" method="post" id="formid" enctype="multipart/form-data">
					  <div layout-gt-xs="row">
						<md-input-container class="md-block" flex-gt-sm>
							<label><?php echo 'Applicant Name'?></label>
							<input required type="text" name="applicant_name" class="form-control" id="applicant_name" value="<?php echo $recruitment["applicant_name"];?> ">
							
						</md-input-container>
					</div>
					<div layout-gt-xs="row">
						<md-input-container class="md-block" flex-gt-sm>
							<label><?php echo 'Positon Applied For' ?></label>
							<input required type="text" name="position_applied_for" class="form-control" id="position_applied_for" value="<?php echo $recruitment["position_applied_for"];?> ">
						</md-input-container>
					</div>
					
					<div layout-gt-xs="row">
						<md-input-container class="md-block" flex-gt-xs>
							<label><?php echo 'Date' ;?></label>
							<input type="text" required value="<?php echo date('d-m-Y',strtotime($recruitment["entered_date"]));?> " name="entered_date" id="entered_date" ngstyle="width: 200px !important;" >
						</md-input-container>
					</div>
					<div layout-gt-xs="row">
						<md-input-container class="md-block" flex-gt-xs>
							<label><?php echo 'Location' ?></label>
							<input type="text" name="location" class="form-control" value="<?php echo $recruitment["location"];?> " id="location">
						</md-input-container>
					</div>
					<input type="submit" name="add"  class="btn btn-success col-md-12"  value="Update">
				</form>
			</md-content>
		</md-content>	
	</md-sidenav>
  	
	<!---<ciuis-sidebar ng-show="!ticketsLoader"></ciuis-sidebar>-->
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
            class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('Add Schedule interview') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('datetobenotified') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
            placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date"
            show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('setreminderto'); ?></label>
          <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id"
            style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="reminder_description"
            placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
        </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
            type="submit">
            <?php echo lang('Add Schedule interview')?>
          </button>
        </div>
      </md-content>
    </md-content>
  </md-sidenav>

</md-content>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/bootstrap-datepicker.min.css'); ?>">
  <!-- datepicker -->
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<script>
var CandidateID = "<?php echo $recruitment['candidate_id'];?>";
var files1='<?php echo $recruitment["file_name"]  ?>';
console.log(files1);
</script>
<script type="text/javascript">
	$(document).ready(function() {
		
        $('#entered_date').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			 orientation: "bottom right",
			 autoclose: true,
	    });
	});
	var lang = {};
	lang.attention = "<?php echo lang('attention')?>";
	lang.doIt = "<?php echo lang('doIt')?>";
	lang.cancel = "<?php echo lang('cancel')?>";
	lang.ticketattentiondetail = "<?php echo lang('ticketattentiondetail')?>";
	lang.ticket = "<?php echo lang('ticket')?>";
	lang.delete = "<?php echo lang('delete')?>";
</script>
