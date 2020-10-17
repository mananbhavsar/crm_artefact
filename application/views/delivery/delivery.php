<?php $appconfig = get_appconfig();  ?>
<style type="text/css">
	#desc {
		padding-left:2%;
	}
	
	.gap {
		border: 15px solid #EEEEEE;
	}
	
	.desc h3:focus {
		outline: none;
		border: 0;
	}
	
	table.gap tr th, table.gap tr td {
		background-color:#fff;
	}
	
	table.gap, .gap th, .gap td {
		border: 1px solid #EEEEEE !important;
	}

</style>
<md-content class="ciuis-body-content" ng-controller="DeliveryCust_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-content class="bg-white">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <md-progress-circular md-mode="determinate" value="{{project.progress}}" class="md-hue-2" md-diameter="20px"></md-progress-circular>
          <h2 class="md-pl-10" flex md-truncate>
            <span class="blur5" ng-bind="project.delivery_number"></span>
            <span ng-bind="project.name"></span>
            <span ng-show="project.template == 1" class="badge" ng-cloak><strong><?php echo lang('template').' '.lang('project') ?></strong></span>
          </h2>
          <?php if (check_privilege('invoices', 'create')) { ?> 
            <md-button ng-show="project.authorization === 'true' && project.template == 0" ng-click="ConvertDialog()" class="md-icon-button" aria-label="Convert" ng-cloak>
              <md-tooltip md-direction="bottom"><?php echo lang('convertinvoice') ?></md-tooltip>
              <md-icon area-label="Delete"><i class="ion-loop text-success"></i></md-icon>
            </md-button>
          <?php } ?>
          <md-button ng-click="projectReport()" class="md-icon-button" aria-label="Pdf" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('generate').' '.lang('project').' '.lang('report') ?></md-tooltip>
            <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
          </md-button>
<!--           <md-menu ng-show="project.authorization === 'true'" md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-mouseenter="$mdMenu.open($event)" aria-label="Delete">
              <md-icon aria-label="Delete"><i class="ion-android-add-circle text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4" ng-mouseleave="$mdMenu.close()">
              <?php if (check_privilege('projects', 'edit')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewService()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.addservice"></p>
                      <md-icon md-menu-align-target class="ion-android-apps" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="NewMilestone()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.addmilestone"></p>
                      <md-icon md-menu-align-target class="ion-android-radio-button-on" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } if (check_privilege('tasks', 'create')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewTask()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.addtask"></p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-tasks" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } if (check_privilege('expenses', 'create')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewExpense()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.newexpense"></p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-expenses" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } if (check_privilege('tickets', 'create')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewTicket()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.newticket"></p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-supports" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } if (check_privilege('proposals', 'create')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewProposal()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.link_proposal"></p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-proposals" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } ?>
            </md-menu-content>
          </md-menu> -->
          <?php if (check_privilege('projects', 'edit') || check_privilege('projects', 'delete')) { ?>      
          <md-menu ng-show="project.authorization === 'true'" md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
            <md-menu-item>
                  <md-button ng-click="Update()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.updateproject"></p>
                      <md-icon md-menu-align-target class="ion-compose" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                
                </md-menu-item>
                <md-menu-item>
                <md-button ng-click="Delete()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.delete"></p>
                      <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                  </md-menu-item>
                <md-menu-item  ng-repeat="status in subprojects">
                  <md-button ng-click="MarkasPopup($index)" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="'Mark as ' + status.stagename">Mark as {{status.stagename}}</p>
                    </div>
                  </md-button>
                </md-menu-item>
                <!--<md-menu-item ng-hide="project.status_id == '1'">
                  <md-button ng-click="MarkAs(1,'<?php echo lang("notstarted") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectnotstarted"></p>
                      <md-icon md-menu-align-target class="ion-ios-close-empty" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item ng-hide="project.status_id == '2'">
                  <md-button ng-click="MarkAs(2,'<?php echo lang("started") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectstarted"></p>
                      <md-icon md-menu-align-target class="ion-toggle-filled" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>-->
                
            </md-menu-content>
          </md-menu>
          <md-menu ng-show="project.authorization === 'true'" md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
            <md-menu-item ng-hide="project.status_id == '1'">
                  <md-button ng-click="StatusMarkAs(1,'<?php echo lang("notstarted") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectnotstarted"></p>
                      <md-icon md-menu-align-target class="ion-toggle-filled" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item ng-hide="project.status_id == '2'">
                  <md-button ng-click="StatusMarkAs(2,'<?php echo lang("started") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectstarted"></p>
                      <md-icon md-menu-align-target class="ion-toggle-filled" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
            <md-menu-item ng-hide="project.status_id == '3'">
                  <md-button ng-click="StatusMarkAs(3,'<?php echo lang("hold") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojecthold"></p>
                      <md-icon md-menu-align-target class="ion-toggle-filled" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item ng-hide="project.status_id == '4'">
                  <md-button ng-click="StatusMarkAs(4,'<?php echo lang("cancelled") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectcancelled"></p>
                      <md-icon md-menu-align-target class="mdi mdi-close-circle-o" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-menu-item ng-hide="project.status_id == '4' || project.status_id == '5'">
                  <md-button ng-click="StatusMarkAs(5,'<?php echo lang("completed") ?>')" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.markasprojectcomplete"></p>
                      <md-icon md-menu-align-target class="ion-checkmark-circled" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
            
                
            </md-menu-content>
          </md-menu>
        <?php } ?>
        </div>
      </md-toolbar>
      <md-content class="bg-white" ng-cloak>
        <div ng-show="projectLoader" layout-align="center center" class="text-center" id="circular_loader">
          <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
            <p style="font-size: 15px;margin-bottom: 5%;">
             <span>
                <?php echo lang('please_wait') ?> <br>
               <small><strong><?php echo lang('loading'). ' '. lang('project').'...' ?></strong></small>
             </span>
           </p>
         </div>
        <div ng-show="!projectLoader" id="project-details" class="on-schedule projects-top">
          <div layout="row" layout-wrap>
            <div flex-sm="33" flex-xs="20" flex-lg="16" flex-gt-sm="16" class="text-center">
            <strong>  <h5>Stage </h5></strong>
              <h3 class="on-schedule" ng-bind="project.latest_status"></h3>
            </div>
            <div flex-sm="30" flex-xs="30" flex-lg="30" flex-gt-sm="30" class="text-center">
            <strong> <h5><?php echo lang('delivery_date') ?></h5></strong>
              <h3 ng-bind="project.delivery_date | date:dd/mm/yyyy"></h3>
            </div>
            <div flex-sm="20" flex-xs="20" flex-lg="20" flex-gt-sm="20" class="text-center">
            <strong>   <h5>Address</h5></strong>
              <h3 ng-bind="project.address" ></h3>
            </div>
            <div flex-sm="20" flex-xs="10" flex-lg="10" flex-gt-sm="10" class="text-center">
            <strong> <h5>Contact Name</h5></strong>
              <h3 ng-bind="project.contact_name" ></h3>
            </div>
          
            <div flex-sm="20" flex-xs="10" flex-lg="10" flex-gt-sm="10" class="text-center">
            <strong> <h5>Contact Number</h5></strong>
              <h3 ng-bind="project.contact_number"></h3>
            </div>
         
          </div>
        </div>
     
      </md-content>
      <md-tabs ng-show="!projectLoader" md-dynamic-height md-border-bottom ng-cloak>
        <md-tab label="<?php echo lang('summary') ?>">
          <h4 layout-padding class="m-xs text-success text-bold" ng-show="project.template == 0">
            <md-button class="md-icon-button auto-cursor">
              <md-icon><i class="ico-ciuis-staffdetail text-success"></i>
              </md-icon> 
            </md-button>
            <span ng-bind="project.customer"></span>
          </h4>
          <md-divider ng-show="project.template == 0"></md-divider>
          <md-content class="bg-white">
            <div ng-show="!projectLoader" id="project-details" class="on-schedule projects-top">
              <div layout="row" layout-wrap>
                <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><strong ng-bind="project.ldt"></strong> <i class="ion-ios-stopwatch-outline"></i></h4>
                <span class="stat-label text-muted"> <?php echo lang('daysleft') ?> </span> 
                </div>
               <!--  <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><span><span ng-bind="project.progress+'%'"></span></span></h4>
                  <span class="stat-label"> <?php echo lang('progresscompleted') ?> </span> 
                </div>
                <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><span><span ng-bind="milestones.length"></span></span></h4>
                  <span class="stat-label"> <?php echo lang('total_s').' '.lang('milestones') ?> </span> 
                </div>
                <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><span><span ng-bind="project.tasks.length"></span></span></h4>
                  <span class="stat-label"> <?php echo lang('total_s'). ' '.lang('tasks') ?> </span> 
                </div>
                <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><span><span ng-bind="tickets.length"></span></span></h4>
                  <span class="stat-label"> <?php echo lang('total_s').' '.lang('tickets') ?> </span> 
                </div>
                <div flex-sm="33" flex-xs="50" flex-lg="16" flex-gt-sm="16" class="text-center">
                  <h4><span><span ng-bind="expenses.length"></span></span></h4>
                  <span class="stat-label"> <?php echo lang('total_s').' '.lang('expenses') ?> </span> 
                </div> -->
              </div>
            </div>
          </md-content>
		  <md-content class="md-padding bg-white" ng-if="project.order_id != '0'">
			<div class="proposal">
				<table border="0" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr>
                      <th class="desc"><?php echo lang('description') ?></th>
                      <th class="unit text-right"><?php echo lang('quantity') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat-start="item in project.items">
                      <td class="desc"><h3 ng-bind="item.name" ng-click="sectionToShow(item.id)"><br>
                        </h3>
                        <pre class="pre_view" ng-cloak>{{item.description}}</pre></td>
                      <td class="unit" ng-bind="item.quantity"></td>
                    </tr>
				
					<tr ng-repeat-end ></tr>
                  </tbody>
                </table>
			</div>
          </md-content>
          <md-content class="md-padding bg-white">
            <h3><?php echo lang('description') ?></h3>
            <p ng-bind="project.description"></p>
          </md-content>
          <md-content class="bg-white" ng-show="custom_fields.length > 0">
            <md-subheader ng-if="custom_fields"><?php echo lang('custom_fields') ?></md-subheader>
            <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
              <md-icon class="{{field.icon}} material-icons"></md-icon>
              <strong flex md-truncate>{{field.name}}</strong>
              <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
              <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
              <p ng-if="field.type === 'date'" class="text-right" flex md-truncate ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
              <p ng-if="field.type === 'select'" class="text-right" flex md-truncate ng-bind="custom_fields[$index].selected_opt.name"></p>
              <md-divider ng-if="custom_fields"></md-divider>
            </md-list-item>
          </md-content>
        </md-tab>
<!-- 
	    <md-tab label="<?php echo lang('stage') ?>">
          <md-content class="md-padding bg-white">
            <article class="project_milestone_detail">
				<md-content class="ciuis-task-subtask bg-white">
					<div class="todo-checklist-container" ng-cloak>
						<div class="ciuis-sub-task">
							<h2 class="mb0">{{title}}: {{subprojects.length + SubProjectsComplete.length}} {{subprojects.length + SubProjectsComplete.length === 1 ? 'Sub Stages' : 'Stages'}}</h2>
						</div>
						<div class="ciuis-sub-task  ciuis-sub-task--small  ciuis-sub-task--highlight"> <span>{{ SubProjectsComplete.length }} <?php echo lang('of')?> {{ projectLength() }} ({{ projectCompletionTotal(SubProjectsComplete.length) }}%) <?php echo lang('substages_complete')?>.</span>
						</div>
						<div class="progress">
							<div style="width: {{ projectCompletionTotal(SubProjectsComplete.length) }}%" class="progress-bar progress-bar-success progress-bar-striped active" ng-bind="'Complete '+projectCompletionTotal(SubProjectsComplete.length)+'%'"></div>
						</div>
						<ul class="subtask-items">
							<li class="subtask-list-item" ng-repeat="project in subprojects"> <span ng-bind="project.stagename"></span>
							  <div class="pull-right">
								<?php if (check_privilege('projects', 'delete')) { ?>
								  <div class="sub-task-button" href ng-click="removeProject($index)"> <span class="ion-trash-b"></span> </div>
								<?php } if (check_privilege('projects', 'edit')) { ?>
									<div class="sub-task-button" href ng-click="completeProject($index)"> <span class="ion-checkmark-round"></span> </div>
								<?php } ?>
							  </div>
							</li>
							<li class="subtask-list-item" ng-class="{ 'subtask-status subtask-status--done' : task.complete }" ng-repeat="project in SubProjectsComplete"> <span ng-bind="project.stagename"></span>
							  <div class="pull-right">
							  <?php if (check_privilege('projects', 'edit')) { ?>
								<div class="sub-task-button" href ng-click="uncompleteProject($index)"> <span class="ion-refresh"></span> </div>
							  <?php } ?>
							  </div>
							</li>
						</ul>
					</div>
				</md-content>
            </article>
          </md-content>
        </md-tab> -->
        <md-tab label="<?php echo lang('milestones') ?>">
          <md-content class="md-padding bg-white">
            <article class="project_milestone_detail">
              <ul class="milestone_project">
                <li ng-repeat="milestone in milestones" class="milestone_project-milestone {{milestone.status}}">
                  <div class="milestone_project-action is-expandable expanded expensesSection">
                    <div class="pull-right">
                      <md-button aria-label="Remove Milestone" class="md-icon-button" ng-click="RemoveMilestone($index)">
                        <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
                      </md-button>
                      <md-button aria-label="Show Milestone" class="md-icon-button" ng-click="ShowMilestone($index)">
                        <md-icon><i class="ion-ios-compose text-muted"></i></md-icon>
                      </md-button>
                    </div>
                    <h2 class="milestonetitle" ng-bind="milestone.name"></h2>
                    <span class="milestonedate exp" ng-bind="milestone.duedate"></span>
                    <div class="content">
                      <div ng-repeat="task in milestone.tasks" class="milestone-todos-list">
                        <ul class="all-milestone-todos">
                          <li ng-class="{'done' : task.status = 4}" class="milestone-todos-list-item col-md-12"> <span class="pull-left col-md-5"><strong ng-bind="task.name"></strong><br>
                            <small ng-bind="task.name"></small></span>
                            <div class="col-md-7">
                              <div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('startdate') ?> <i class="ion-ios-stopwatch-outline"></i></small><br>
                                <strong ng-bind="task.startdate"></strong></span> </div>
                              <div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('duedate') ?> <i class="ion-ios-timer-outline"></i></small><br>
                                <strong ng-bind="task.duedate"></strong></span> </div>
                              <div class="col-md-4"> <span class="date-start-task"> <small class="text-muted"><?php echo lang('status') ?> <i class="ion-ios-flag"></i></small><br>
                                <strong ng-if="task.status_id == '1' "><?php echo lang('open') ?></strong> <strong ng-if="task.status_id == '2' "><?php echo lang('inprogress') ?></strong> <strong ng-if="task.status_id == '3' "><?php echo lang('waiting') ?></strong> <strong ng-if="task.status_id == '4' "><?php echo lang('complete') ?></strong> </span> </div>
                              <div class="col-md-2">
                                <md-button aria-label="Go Task" class="md-icon-button" ng-href="<?php echo base_url('/tasks/task/')?>{{task.id}}">
                                  <md-icon><i class="ion-android-open text-muted"></i></md-icon>
                                </md-button>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </article>
          </md-content>
        </md-tab>
       
        <md-tab label=" <?php echo lang('notes') ?>">
          <md-content class="md-padding bg-white">
            <section class="md-pb-30">
              <md-input-container class="md-block" ng-show="!editNote">
                <label><?php echo lang('description') ?></label>
                <textarea name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <md-input-container class="md-block" ng-show="editNote">
                <label><?php echo lang('description') ?></label>
                <textarea id="note_focus" name="description" ng-model="edit_note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <input type="hidden" name="" ng-model="edit_note_id">
              <div class="form-group pull-right">
                <md-button ng-show="editNote" ng-click="SaveNote()" class="template-button pull-right" ng-disabled="saveNote == true">
                  <span ng-hide="saveNote == true"><?php echo lang('savenote');?></span>
                  <md-progress-circular class="white" ng-show="saveNote == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                </md-button>
                <md-button ng-show="!editNote" ng-click="AddNote()" class="template-button pull-right" ng-disabled="addNote == true">
                  <span ng-hide="addNote == true"><?php echo lang('addnote');?></span>
                  <md-progress-circular class="white" ng-show="addNote == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                </md-button>
              </div>
            </section>
            <section class="ciuis-notes show-notes">
              <article ng-repeat="note in notes" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50"/> </div>
                <div class="ciuis-note-detail-body"> 
                  <div class="text">
                    <p> 
                      <span ng-bind="note.description"></span> 
                      <a ng-click='DeleteNote($index)' class="ion-trash-a text-muted note-button pull-right" ng-disabled="modifyNote == true">
                        <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
                      </a>
                      <a ng-click='EditNote($index)' class="ion-compose note-button text-muted pull-right" ng-disabled="modifyNote == true">
                        <md-tooltip md-direction="bottom"><?php echo lang('edit') ?></md-tooltip>
                      </a>
                    </p>
                  </div>
                  <p class="attribution"> <?php echo lang('addedby') ?> <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> <?php echo lang('at') ?> <span ng-bind="note.date"></span> </p>
                </div>
              </article>
            </section>
          </md-content>
        </md-tab>
     
        <md-tab label="<?php echo lang('addvehicle') ?>">
          <md-content class="md-padding bg-white">
            <md-list-item ng-repeat="item in vehicle.items">
				<div layout-gt-sm="row">
				<input type="hidden" class="min_input_width" ng-model="item.id">
				<md-input-container class="md-block">
					<label><?php echo lang('vehicle_number'); ?></label>
					<input class="min_input_width" ng-model="item.vehicle_number">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('vehicle_type'); ?></label>
					<input class="min_input_width" ng-model="item.vehicle_type">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('driver_name'); ?></label>
					<input class="min_input_width" ng-model="item.driver_name" >
				</md-input-container>
			
				
				</div>
				<md-icon aria-label="Remove Line" ng-click="vehicle_remove($index,item.id)" class="md-secondary ion-trash-b text-muted"></md-icon>
			</md-list-item>
			<md-content class="bg-white" layout-padding>
				<div class="col-md-6">
				<md-button ng-click="add_vehicle()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
					<md-icon class="ion-plus-round text-muted"></md-icon>
				</md-button>
				<md-button ng-click="save_vehicle()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
					<md-icon class="ion-checkmark text-muted"></md-icon>
				</md-button>
				</div>
			</md-content>
          </md-content>
        </md-tab>


      </md-tabs>
    </md-content>
  </div>
  <!-- Sidebar -->
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 project-sidebar">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Member" ng-disabled="true">
          <md-icon><i class="ion-ios-people text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('peopleonthisprojects') ?></h2>
        <?php if (check_privilege('projects', 'edit')) { ?> 
          <md-button ng-click="InsertMember()" ng-show="project.authorization === 'true'" class="md-icon-button md-primary" aria-label="Add Member" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('add').' '.lang('staff') ?></md-tooltip>
            <md-icon class="ion-person-add"></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <div class="project-assignee" ng-cloak>
      <div id="ciuis-customer-contact-detail">
        <div ng-if="project.authorization === 'false'" role="alert" class="alert alert-warning alert-icon alert-dismissible">
          <div class="icon"><span class="mdi mdi-block-alt"></span></div>
          <div class="message">
            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
            <?php echo lang('notauthorized') ?> </div>
        </div>
        <div data-linkid="{{member.id}}" ng-repeat="member in project.members" class="ciuis-customer-contacts">
          <div data-toggle="modal" data-target="#contactmodal1"> <img width="40" height="40" src="{{UPIMGURL}}{{member.staffavatar}}" alt="">
            <div style="padding: 16px;position: initial;"> <strong ng-bind="member.staffname"></strong> <br>
              <span ng-bind="member.email"></span> </div>
              <?php if (check_privilege('projects', 'delete')) { ?> 
                <div ng-show="project.authorization === 'true'" ng-click='UnlinkMember($index)' class="unlink"> <i class="ion-ios-close-outline"></i> </div>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('files') ?></h2>
        <?php if (check_privilege('projects', 'edit')) { ?> 
          <md-button ng-click="UploadFile()" ng-show="project.authorization === 'true'" class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <div ng-show="projectFiles" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
        <small><strong><?php echo lang('loading'). ' '. lang('project_files').'...' ?></strong></small></span>
      </p>
    </div>
    <md-content class="bg-white" ng-show="!projectFiles">
      <md-list flex ng-cloak>
        <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
          <div class="md-list-item-text image-preview">
            <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
              <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="{{file.path}}">
            </a>
            <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('delivery/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
            </a>
            <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('delivery/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
            <a ng-if="file.type == 'pdf'" class="cursor" ng-href="<?php echo base_url('delivery/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('delivery/download_file/{{file.id}}');?>">
              <h3 class="link" ng-bind="file.file_name"></h3>
            </a>
          </div>
          <?php if (check_privilege('projects', 'delete')) { ?> 
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
        <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
      </md-list>
      <div ng-show="files.length>6 && !projectFiles" class="pagination-div" ng-cloak>
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </md-content>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="width: 450px;" ng-cloak>
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('updateprojectinformations') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('name') ?></label>
          <input required type="text" ng-model="project.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>" disabled/>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs ng-show="project.template == 0">
          <label><?php echo lang('customer'); ?></label>
          <md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="project.customer_id" name="customer" style="min-width: 200px;" data-md-container-class="selectdemoSelectHeader"  ng-disabled="true">> 
            <md-select-header class="demo-select-header">
              <label style="display: none;"><?php echo lang('search').' '.lang('customer')?></label>
              <input ng-submit="search_customers(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search').' '.lang('customers')?>" class="demo-header-searchbox md-text" ng-keyup="search_customers(search_input)">
            </md-select-header>
            <md-optgroup label="customers">
              <md-option ng-value="customer.id" ng-repeat="customer in all_customers">
                <span class="blur" ng-bind="customer.customer_number"></span> 
                <span ng-bind="customer.name"></span><br>
                <span class="blur">(<small ng-bind="customer.email"></small>)</span>
              </md-option>
            </md-optgroup>            
          </md-select>
        </md-input-container>
        <input type="hidden" ng-model="project.template" name="">
        <md-input-container>
          <label><?php echo lang('startdate') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="project.editdelivery_date" class=" dtp-no-msclear dtp-input md-input">

        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label><br>
          <input type="text" id="location" class="form-control text-left" placeholder="" <?php echo lang('description'); ?>  ng-model="project.description">
        </md-input-container>
        <md-switch ng-model="NeedShippingAddress" aria-label="Status" class="md-block" > <strong class="text-muted"><?php echo lang('need_shipping_address') ?></strong></md-switch>
        <md-subheader ng-show='true' class="md-primary bg-white text-uppercase text-bold"><?php echo lang('shipping_address') ?></md-subheader>
        <md-content  ng-show='true' layout-padding class="bg-white" ng-cloak>
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="project.address" md-maxlength="500" rows="2" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
        <md-select placeholder="<?php echo lang('country'); ?>" ng-model="project.shipping_country_id"  ng-change="getShippingStates(project.shipping_country_id)" name="shipping_country" style="min-width: 200px;">
            <md-option ng-value="{{country.id}}" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
          <br />
        </md-input-container>        
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="project.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="project.shipping_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="project.shipping_zip">
        </md-input-container>

        <md-input-container class="md-block">
          <label>Contact Name</label>
          <input name="zipcode" ng-model="project.contact_name">
        </md-input-container>
        <md-input-container class="md-block">
          <label>Contact number</label>
          <input name="zipcode" ng-model="project.contact_number">
        </md-input-container>
        </md-content>    
      
      </md-content>
      <md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="UpdateProject()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true"  aria-label="Update">
            <span ng-hide="saving == true"><?php echo lang('update');?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>  
        </section>
      </md-content>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewMilestone" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addmilestone') ?></md-truncate>
      </div>
    </md-toolbar>
  <!--   <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('name') ?></label>
          <input required type="text" ng-model="amilestone.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('duedate') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" show-icon="true" ng-model="amilestone.duedate" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="amilestone.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('milestoneorder') ?></label>
          <input required type="number" ng-model="amilestone.order" class="form-control" id="title" placeholder="0"/>
        </md-input-container>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddMilestone()" class="md-raised md-primary btn-report block-button" ng-disabled="addingMilestone == true" aria-label="AddMilestone">
            <span ng-hide="addingMilestone == true"><?php echo lang('add');?></span>
            <md-progress-circular class="white" ng-show="addingMilestone == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content> -->
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewTask" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addtask') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('name') ?></label>
          <input required type="text" ng-model="newtask.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('hourlyrate') ?></label>
          <input type="text" ng-model="newtask.hourlyrate" class="form-control" id="title" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('startdate') ?></label>
          <md-datepicker md-min-date="date" name="start" ng-model="newtask.startdate" md-open-on-focus></md-datepicker>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('duedate') ?></label>
          <md-datepicker md-min-date="date" name="start" ng-model="newtask.duedate" md-open-on-focus></md-datepicker>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('assigned'); ?></label>
          <md-select required ng-model="newtask.assigned" name="assigned" style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('priority'); ?></label>
          <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="newtask.priority" name="priority" style="min-width: 200px;">
            <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('milestone'); ?></label>
          <md-select ng-model="newtask.milestone" name="assigned" style="min-width: 200px;">
            <md-option ng-value="milestone.id" ng-repeat="milestone in milestones">{{milestone.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="newtask.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <md-switch ng-model="isPublic" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
        <md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable') ?></strong></md-switch>
        <md-switch ng-model="isVisible" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddTask()" class="md-raised md-primary btn-report block-button" aria-label=""><?php echo lang('add');?></md-button>
          <br/><br/><br/><br/>            
        </section>
      </md-content>
    </md-content>                                                                                   
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewExpense" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addexpense') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('title') ?></label>
          <input required type="text" ng-model="newexpense.title" class="form-control" id="title" placeholder="<?php echo lang('title'); ?>"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('amount') ?></label>
          <input required type="number" ng-model="newexpense.amount" class="form-control" id="amount" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('date') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="newexpense.date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('category'); ?></label>
          <md-select required ng-model="newexpense.category" name="category" style="min-width: 200px;">
            <md-option ng-value="category.id" ng-repeat="category in expensescategories">{{category.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('account'); ?></label>
          <md-select required ng-model="newexpense.account" name="account" style="min-width: 200px;">
            <md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="newexpense.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddExpense()" class="md-raised md-primary btn-report block-button" ng-disabled="adding == true" aria-label="AddExpense">
            <span ng-hide="adding == true"><?php echo lang('add');?></span>
            <md-progress-circular class="white" ng-show="adding == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewTicket" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
    <div class="md-toolbar-tools">
    <md-button ng-click="close()" class="md-icon-button" aria-label="Close">
       <i class="ion-android-arrow-forward"></i>
    </md-button>
    <md-truncate><?php echo lang('create') ?></md-truncate>
    </div>
    </md-toolbar>
    <md-content layout-padding>
    <?php //echo form_open_multipart('tickets/create'); ?>
      <md-input-container class="md-block">
        <label><?php echo lang('subject') ?></label>
        <input required type="text" ng-model="ticket.subject" name="subject" class="form-control">
      </md-input-container>
          <md-input-container ng-show="project.template == 1" class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
            <md-select placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="ticket.customer" name="customer"  ng-init="project.customer_id">
              <md-option ng-value="customer" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
            </md-select>
            <br>
          </md-input-container>
          <md-input-container ng-show="project.template == 0" class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
            <md-select disabled placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="ticket.customer" name="customer" ng-init="project.customer_id">
              <md-option ng-value="customer" ng-repeat="customer in all_customers" ng-selected="customer.id == project.customer_id">{{customer.name}}</md-option>
            </md-select>
            <br>
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('contact'); ?></label>
            <md-select required ng-model="ticket.contact" name="contact">
              <md-select-header>
                <md-toolbar class="toolbar-white">
                  <div class="md-toolbar-tools">
                    <h4 flex md-truncate><?php echo lang('contacts') ?></h4>
                    <md-button class="md-icon-button" ng-href="<?php echo base_url('customers/customer/{{ticket.customer.id}}')?>" target="_blank" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </div>
                </md-toolbar>
              </md-select-header>
              <md-option ng-value="contact.id" ng-repeat="contact in ticket.customer.contacts">{{contact.name + ' ' + contact.surname}}</md-option>
            </md-select><br>
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
              <label><?php echo lang('department'); ?></label>
        <md-select required ng-model="ticket.department" name="department">
          <md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
        </md-select><br>
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
              <label><?php echo lang('priority'); ?></label>
        <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="ticket.priority" name="priority">
          <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
        </md-select><br>
          </md-input-container>
          <md-input-container class="md-block">
        <label><?php echo lang('message') ?></label>
        <textarea required name="message" ng-model="ticket.message" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
      </md-input-container>
      <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button type="button" ng-click="createTicket()" class="md-raised md-primary btn-report block-button" aria-label="add"><?php echo lang('add');?>
          </md-button>
          <br/><br/><br/><br/>
      </section>
    <?php //echo form_close(); ?>
    </md-content>
  </md-sidenav>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewService" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addservice') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('category'); ?></label>
          <md-select required ng-model="newservice.category" ng-change="getProducts(newservice.category)" name="category" style="min-width: 200px;">
            <md-select-header>
              <md-toolbar class="toolbar-white">
                <div class="md-toolbar-tools">
                  <h4 flex md-truncate><?php echo lang('categories') ?></h4>
                  <a href="<?php echo base_url('products') ?>">
                    <md-button class="md-icon-button" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </a>
                </div>
              </md-toolbar>
            </md-select-header>
            <md-option ng-value="category.id" ng-repeat="category in productcategories">{{category.name}}</md-option>
          </md-select>
          <p class="text-danger" ng-show="productFound"><?php echo lang('productnotfound') ?></p>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('product'); ?></label>
          <md-select required ng-model="newservice.product" name="product" ng-change="getProductData(newservice.product)" style="min-width: 200px;">
            <md-toolbar class="toolbar-white">
                <div class="md-toolbar-tools">
                  <h4 flex md-truncate><?php echo lang('products') ?></h4>
                  <a href="<?php echo base_url('products') ?>">
                    <md-button class="md-icon-button" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </a>
                </div>
              </md-toolbar>
            <md-option ng-value="product.id" ng-repeat="product in categoriesproduct">{{product.productname}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('productname') ?></label>
          <input required type="text" ng-model="newservice.productname" class="form-control" id="title" placeholder="<?php echo lang('productname'); ?>"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('price') ?></label>
          <input required type="text" ng-model="newservice.price" class="form-control" id="price" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo $appconfig['tax_label'] ?></label>
          <input required type="text" ng-model="newservice.tax" class="form-control" id="tax" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('quantity') ?></label>
          <input type="number" required name="quantity" min="1" ng-model="newservice.quantity" ng-init="newservice.quantity=1" placeholder="<?php echo lang('quantity') ?>" class="form-control">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('unit') ?></label>
          <input type="text" required name="unit" ng-model="newservice.unit" ng-init="newservice.unit='Unit'" placeholder="<?php echo lang('unit') ?>" class="form-control">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="newservice.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddService()" class="md-raised md-primary btn-report block-button" aria-label="add"><?php echo lang('add');?>
          </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="UpdateService" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('updateservice') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('category'); ?></label>
          <md-select required ng-model="updateservice.category" ng-change="getProducts(updateservice.category)" name="category" style="min-width: 200px;">
            <md-select-header>
              <md-toolbar class="toolbar-white">
                <div class="md-toolbar-tools">
                  <h4 flex md-truncate><?php echo lang('categories') ?></h4>
                  <a href="<?php echo base_url('products') ?>">
                    <md-button class="md-icon-button" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </a>
                </div>
              </md-toolbar>
            </md-select-header>
            <md-option ng-value="pcategory.id" ng-repeat="pcategory in productcategories">{{pcategory.name}}</md-option>
          </md-select>
          <p class="text-danger" ng-show="productFound"><?php echo lang('productnotfound') ?></p>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('product'); ?></label>
          <md-select required ng-model="updateservice.product" name="product" ng-change="getProductData(updateservice.product)" style="min-width: 200px;">
            <md-toolbar class="toolbar-white">
                <div class="md-toolbar-tools">
                  <h4 flex md-truncate><?php echo lang('products') ?></h4>
                  <a href="<?php echo base_url('products') ?>">
                    <md-button class="md-icon-button" aria-label="Create New">
                      <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                    </md-button>
                  </a>
                </div>
              </md-toolbar>
            <md-option ng-value="product.id" ng-repeat="product in categoriesproduct">{{product.productname}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('productname') ?></label>
          <input required type="text" ng-model="updateservice.productname" class="form-control" id="title" placeholder="<?php echo lang('productname'); ?>"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('price') ?></label>
          <input required type="text" ng-model="updateservice.price" class="form-control" id="price" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo $appconfig['tax_label'] ?></label>
          <input required type="text" ng-model="updateservice.tax" class="form-control" id="tax" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('quantity') ?></label>
          <input type="text" required name="quantity" min="1" ng-model="updateservice.quantity" ng-init="updateservice.quantity=1" placeholder="<?php echo lang('quantity') ?>" class="form-control">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('unit') ?></label>
          <input type="text" required name="unit" ng-model="updateservice.unit" ng-init="updateservice.unit='Unit'" placeholder="<?php echo lang('unit') ?>" class="form-control">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="updateservice.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="SaveService()" class="md-raised md-primary btn-report block-button" aria-label="add"><?php echo lang('update');?> </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>

  <script type="text/ng-template" id="convertDialog.html">
    <md-dialog aria-label="Expense Detail">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class=""><?php echo lang('convertinvoice') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()" aria-label="add">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px;">
        <md-content class="bg-white">
          <md-list flex>
            <md-list-item>
              <div class="ciuis-custom-list-item-item col-md-12">
                <div class="col-md-6" style="padding-bottom: 3%;margin-bottom: 5%;border: 1px solid #efefef;border-radius: 3px;text-align: center;margin-left: -3px;margin-right: 3px;">
                  <p class="text-success"><?php echo lang('convertinvoicewithservicevalue'); ?></p>
                  <md-button ng-click="Convert()" ng-disabled="invoiceButton" class="md-raised md-primary" aria-label="add"><?php echo lang('services'). ' ' .lang('invoice');?></md-button><br>
                </div>
                <div class="col-md-6" style="padding-bottom: 3%;margin-bottom: 5%;border: 1px solid #efefef;border-radius: 3px;text-align: center;margin-left: 3px;margin-right: -3px;">
                  <p class="text-success"><?php echo lang('convertinvoicewithprojectvalue'); ?></p>
                  <md-button ng-click="ConvertWithProjectValue()" ng-disabled="invoiceButton" class="md-raised md-primary" aria-label="add"><?php echo  lang('project'). ' ' .lang('invoice');?></md-button><br>
                </div>
              </div>
            </md-list-item>
          </md-list>
        </md-content>     
      </md-dialog-content>
    </md-dialog>
  </script>

  <script type="text/ng-template" id="ticketDialog.html">
    <md-dialog aria-label="Ticket Detail">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class="text-success"><?php echo lang('ticket') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()" aria-label="add">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
            <md-tooltip md-direction="left"><?php echo lang('close') ?></md-tooltip>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px; ">
        <md-content class="bg-white" layout-padding>
          <div class="ciuis-ticket-row">
            <h4 style="width:100%"><strong ng-bind="ticket.subject"></strong> 
              <md-menu md-position-mode="target-right target" class=" pull-right">
                <a class="cursor"  ng-click="$mdMenu.open($event)" style="font-size: 25px;padding: 25px;"><i class="ion-android-more-vertical"></i>
                  <md-tooltip md-direction="top"><?php echo lang('actions') ?></md-tooltip>
                </a>
                  <md-menu-content width="4">
                    <md-menu-item>
                      <md-button ng-click="TicketMarkAs(1,lang.open, ticket.id)" ng-bind="lang.markasopen" aria-label="Open"></md-button>
                    </md-menu-item>
                    <md-menu-item>
                      <md-button ng-click="TicketMarkAs(2,lang.inprogress, ticket.id)" ng-bind="lang.markasinprogress" aria-label="In Progress"></md-button>
                    </md-menu-item>
                    <md-menu-item>
                      <md-button ng-click="TicketMarkAs(3,lang.answered, ticket.id)" ng-bind="lang.markasanswered" aria-label="Answered"></md-button>
                    </md-menu-item>
                    <md-menu-item>
                      <md-button ng-click="TicketMarkAs(4,lang.closed, ticket.id)" ng-bind="lang.markasclosed" aria-label="Closed"></md-button>
                    </md-menu-item>
                    <md-menu-item>
                      <md-button ng-click="DeleteTicket(ticket.id)" ng-bind="lang.delete" aria-label="Closed"></md-button>
                    </md-menu-item>
                    </md-menu-content>
                </md-menu>
              <a href="<?php echo base_url('tickets/ticket/')?>{{ticket.id}}" class="pull-right" style="font-size: 25px;"><i class="ion-android-open"></i>
                <md-tooltip md-direction="left"><?php echo lang('go_to_ticket') ?></md-tooltip>
              </a> 
            </h4>
          </div>
          <div class="ciuis-ticket-row">
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('assignedstaff')?>
              </div>
              <div class="ticket-data" ng-bind="ticket.staffname"></div>
            </div>
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('customer')?>
              </div>
              <div class="ticket-data">
                <a href="<?php echo base_url('customers/customer/{{ticket.customer_id}}')?>" ng-bind="ticket.contactsurname"></a>
              </div>
            </div>
          </div>
          <div class="ciuis-ticket-row">
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('contactname')?>
              </div>
              <div class="ticket-data" ng-bind="ticket.contactname">
              </div>
            </div>
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('department')?>
              </div>
              <div class="ticket-data" ng-bind="ticket.department"></div>
            </div>
          </div>
          <div class="ciuis-ticket-row">
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('status')?>
              </div>
              <div class="ticket-data label-status">
                <span ng-switch="ticket.status_id">
                  <span class="badge" ng-switch-when="1"><?php echo lang( 'open' ); ?></span>
                  <span class="badge" ng-switch-when="2"><?php echo lang( 'inprogress' ); ?></span>
                  <span class="badge" ng-switch-when="3"><?php echo lang( 'answered' ); ?></span>
                  <span class="badge" ng-switch-when="4"><?php echo lang( 'closed' ); ?></span>
                </span>
              </div>
            </div>
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('priority')?>
              </div>
              <div class="ticket-data">
                <span ng-switch="ticket.priority">
                  <span ng-switch-when="1"><?php echo lang( 'low' ); ?></span>
                  <span ng-switch-when="2"><?php echo lang( 'medium' ); ?></span>
                  <span ng-switch-when="3"><?php echo lang( 'high' ); ?></span>
                </span>
              </div>
            </div>
          </div>
          <div class="ciuis-ticket-row">
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('datetimeopened')?>
              </div>
              <div class="ticket-data">
                <span class="badge" ng-bind="ticket.date | date : 'MMM d, y h:mm:ss a'"></span>
              </div>
            </div>
            <div class="ciuis-ticket-fieldgroup">
              <div class="ticket-label">
                <?php echo lang('datetimelastreplies')?>
              </div>
              <div class="ticket-data">
                <span ng-show="ticket.lastreply == NULL" class="badge"><?php echo lang('n_a') ?></span><span ng-show="ticket.lastreply != NULL" class="badge" ng-bind="ticket.lastreply | date : 'MMM d, y h:mm:ss a'"></span>
              </div>
            </div>
          </div>
          <div class="ciuis-ticket-row">
            <div class="ciuis-ticket-fieldgroup full">
              <div class="ticket-label">
                <strong><?php echo lang('message') ?></strong>
              </div>
              <div style="padding: 10px; border-radius: 3px; margin-bottom: 10px; font-weight: 600; background: #f3f3f3;" class="ticket-data">
                <span ng-bind="ticket.message"></span>
              </div>
            </div>
          </div>
        </md-content>     
      </md-dialog-content>
    </md-dialog>
  </script>

  <script type="text/ng-template" id="expenseDialog.html">
    <md-dialog aria-label="Expense Detail">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class="text-success"><?php echo lang('expense') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()" aria-label="add">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px; ">
        <md-content class="bg-white">
          <md-list flex>
            <md-list-item>
              <h3>
                <a class="ciuis_expense_receipt_number" href="<?php echo base_url('expenses/receipt/') ?>{{expense.id}}">
                  <strong ng-bind="expense.longid"></strong>
                </a>
                <a href="<?php echo base_url('expenses/receipt/') ?>{{expense.id}}"><i class="ion-android-open"></i><md-tooltip md-direction="top"><?php echo lang('go_to').' '.lang('expense') ?></md-tooltip></a>
              </h3>
            </md-list-item>
            <md-list-item>
              <p>
                <small ng-bind="expense.title">
                </small> 
                <span ng-show="expense.billable != 'false'" class="label label-{{expense.color}}" ng-bind="expense.billstatus"></span>
                <span flex></span>
              </p>
            </md-list-item>
            <md-list-item>
              <h4 class="text-bold money-area">
                <small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small>: 
                <strong ng-bind-html="expense.amount | currencyFormat:cur_code:null:true:cur_lct"></strong>
              </h4>
            </md-list-item>
            <md-list-item>
              <div> <span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('category'); ?></small>: 
                <strong ng-bind="expense.category"></strong> 
              </div>
            </md-list-item>
            <md-divider>
            </md-divider>
            <md-content layout-padding>
              <h3 class="md-mt-0">
                <small class="text-muted text-uppercase"><?php echo lang('date'); ?></small>: 
                <strong ng-bind="expense.date | date : 'MMM d, y h:mm:ss a'"></strong>
              </h3>
            </md-content>
          </md-list>
        </md-content>     
      </md-dialog-content>
    </md-dialog>
  </script>

  <script type="text/ng-template" id="insert-member-template.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('assigned'); ?></h2>
    <md-select required ng-model="insertedStaff" style="min-width: 200px;" aria-label="AddMember">
      <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
    </md-select>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="AddProjectMember()"><?php echo lang('add') ?>!</md-button>
  </md-dialog-actions>
  </md-dialog>
</script> 

<script type="text/ng-template" id="markas-template.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="delivery.addnewdelivery_date" class=" dtp-no-msclear dtp-input md-input">
    <md-switch ng-model="editNeedShippingAddress" aria-label="Status"><strong class="text-muted"><?php echo lang('need_shipping_address') ?></strong></md-switch>
        <md-subheader ng-show='editNeedShippingAddress == true' class="md-primary bg-white text-uppercase text-bold"><?php echo lang('shipping_address') ?></md-subheader>
        <md-content  ng-show='editNeedShippingAddress == true' layout-padding class="bg-white" ng-cloak>
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="delivery.address" md-maxlength="500" rows="2" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
        <md-select placeholder="<?php echo lang('country'); ?>" ng-model="delivery.shipping_country_id"  ng-change="getShippingStates(delivery.shipping_country_id)" name="shipping_country" style="min-width: 200px;">
            <md-option ng-value="{{country.id}}" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
          <br />
        </md-input-container>        
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="delivery.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="delivery.shipping_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="delivery.shipping_zip">
        </md-input-container>
        <md-input-container class="md-block">
          <label>Contact Name</label>
          <input name="zipcode" ng-model="delivery.contact_name">
        </md-input-container>
        <md-input-container class="md-block">
          <label>Contact number</label>
          <input name="zipcode" ng-model="delivery.contact_number">
        </md-input-container>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="MarkAs()"><?php echo lang('add') ?>!</md-button>
  </md-dialog-actions>
  </md-dialog>
</script> 
  <script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('projects/add_file/'.$projects['id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="file_name" file-model="project_file">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="view_image.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>">
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('projects', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('projects/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="delete_project.html">
  <md-dialog aria-label="options dialog">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class="text-danger"><?php echo lang('delete_delivery_note') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()" aria-label="add">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
  <md-dialog-content layout-padding>
    <p class="text-danger" style="margin:unset;">
      <strong><?php echo lang('delete_project_warning') ?> </strong>
      <li><?php echo lang('all').' '.lang('tickets').' '.lang('of_this').' '.lang('project') ?></li>
      <li><?php echo lang('all').' '.lang('services').' '.lang('of_this').' '.lang('project') ?></li>
      <li><?php echo lang('all').' '.lang('milestones').' '.lang('of_this').' '.lang('project') ?></li>
      <li><?php echo lang('all').' '.lang('tasks').' '.lang('of_this').' '.lang('project') ?></li>
      <li><?php echo lang('all').' '.lang('expenses').' '.lang('of_this').' '.lang('project') ?></li>
      <li><?php echo lang('all').' '.lang('files').' '.lang('of_this').' '.lang('project') ?></li>
    </p>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="DeleteProject()" class="delete-button" ng-disabled="deletingProject == true" aria-label="add">
      <span ng-hide="deletingProject == true"><?php echo lang('delete');?></span>
      <md-progress-circular ng-show="deletingProject == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="new_proposal.html">
  <md-dialog aria-label="options dialog">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
        <h2>
          <strong class="text-success">
            <span ng-show="newProposal"><?php echo lang('new') ?></span> 
            <span ng-show="!newProposal"><?php echo lang('link') ?></span> 
            <?php echo lang('proposal') ?>
          </strong>
        </h2>
        <span flex></span> 
        <md-switch ng-model="newProposal" aria-label="Type"><strong class="text-muted"><?php echo lang('new').' '.lang('proposal') ?></strong></md-switch>
        <md-button class="md-icon-button" ng-click="close()" aria-label="add">
          <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
  <md-dialog-content layout-padding>
    <md-content ng-show="!newProposal" class="bg-white" layout-padding>
      <div layout-gt-xs="row">
        <p class="text-success"><?php echo lang('link_existing').' '.lang('proposal'); ?></p>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('link_existing').' '.lang('proposal'); ?></label>
          <md-select required placeholder="<?php echo lang('select').' '.lang('proposal'); ?>" ng-model="existing_proposal_id" name="customer" style="min-width: 200px;">
            <md-option ng-value="proposal.id" ng-repeat="proposal in proposalsList">{{proposal.subject}}</md-option>
          </md-select>
        </md-input-container>
      </div>
    </md-content>

    <md-content ng-show="newProposal" class="bg-white" layout-padding>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('subject')?></label>
          <input ng-model="newproposal.subject" name="subject">
        </md-input-container>
        <md-input-container>
          <label><?php echo lang('dateofissuance') ?></label>
          <md-datepicker name="created" ng-model="newproposal.created" md-open-on-focus></md-datepicker>
        </md-input-container>
        <md-input-container>
          <label><?php echo lang('opentill') ?></label>
          <md-datepicker md-min-date="created" name="opentill" ng-model="newproposal.opentill" md-open-on-focus></md-datepicker>
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('assigned'); ?></label> 
          <md-select required placeholder="<?php echo lang('assigned'); ?>" ng-model="newproposal.assigned" name="assigned" style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('status'); ?></label>
          <md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('draft'); ?>'}, {id: 2,name: '<?php echo lang('sent'); ?>'}, {id: 3,name: '<?php echo lang('open'); ?>'}, {id: 4,name: '<?php echo lang('revised'); ?>'}, {id:5,name: '<?php echo lang('declined'); ?>'}, {id: 6,name: '<?php echo lang('accepted'); ?>'}];" required placeholder="<?php echo lang('status'); ?>" ng-model="newproposal.status" name="status" style="min-width: 200px;">
            <md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
          </md-select>
        </md-input-container>
        <md-input-container>
          <md-checkbox class="pull-right" ng-model="newproposal.comment" aria-label="Comment"> <strong class="text-muted text-uppercase"><?php echo lang('allowcomments');?></strong> </md-checkbox>
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('detail') ?></label>
          <textarea ng-model="newproposal.content" rows="3"></textarea>
        </md-input-container>
      </div>
    </md-content>
    <md-content ng-show="newProposal" class="bg-white" layout-padding>
      <md-list-item ng-repeat="item in newproposal.items">
        <div layout-gt-sm="row">
          <md-autocomplete
          md-autofocus
          md-items="product in GetProduct(item.name)"
        md-search-text="item.name"
        md-item-text="product.name"   
        md-selected-item="selectedProduct"
        md-no-cache="true"
        md-min-length="0"
        md-floating-label="<?php echo lang('productservice'); ?>">
            <md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
          </md-autocomplete>
          <md-input-container class="md-block">
            <label><?php echo lang('description'); ?></label>
            <input type="hidden" ng-model="item.name">
            <bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
            <input ng-model="item.description" placeholder="<?php echo lang('description'); ?>">
            <bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
            <input type="hidden" ng-model="item.product_id">
            <bind-expression ng-init="selectedProduct.product_id = item.product_id" expression="selectedProduct.product_id" ng-model="item.product_id" />
            <input type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
            <bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('quantity'); ?></label>
            <input ng-model="item.quantity" >
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('unit'); ?></label>
            <input ng-model="item.unit" >
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('price'); ?></label>
            <input ng-model="item.price">
            <bind-expression ng-init="selectedProduct.price = 0" expression="selectedProduct.price" ng-model="item.price" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo $appconfig['tax_label']; ?></label>
            <input ng-model="item.tax">
            <bind-expression ng-init="selectedProduct.tax = 0" expression="selectedProduct.tax" ng-model="item.tax" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('discount'); ?></label>
            <input ng-model="item.discount">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('total'); ?></label>
            <input ng-value="item.quantity * item.price + ((item.tax)/100*item.quantity * item.price) - ((item.discount)/100*item.quantity * item.price)">
          </md-input-container>
        </div>
        <md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
      </md-list-item>
      <md-content class="bg-white" layout-padding>
        <div class="col-md-6">
          <md-button ng-click="add()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
            <md-icon class="ion-plus-round text-muted"></md-icon>
          </md-button>
        </div>
        <div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
          <div class="col-md-7">
            <div class="text-right text-uppercase text-muted"><?php echo lang('sub_total') ?>:</div>
            <div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
            <div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted"><?php echo lang('total').' '.$appconfig['tax_label'] ?>:</div>
            <div class="text-right text-uppercase text-black"><?php echo lang('grand_total') ?>:</div>
          </div>
          <div class="col-md-5">
            <div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
          </div>
        </div>
      </md-content>
    </md-content>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-show="newProposal" ng-click="CreateProposal()" class="template-button" ng-disabled="savingProposal == true" aria-label="add">
      <span ng-hide="savingProposal == true"><?php echo lang('create');?></span>
      <md-progress-circular class="white" ng-show="savingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
    <md-button ng-show="!newProposal" ng-click="LinkProposal()" class="template-button" ng-disabled="linkingProposal == true" aria-label="add">
      <span ng-hide="linkingProposal == true"><?php echo lang('link');?></span>
      <md-progress-circular class="white" ng-show="linkingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="projectReport.html">
    <md-dialog aria-label="Project Report">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class=""><?php echo lang('generate').' '.lang('project').' '.lang('report') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px;">
        <md-content padding-layout class="bg-white md-padding">
          <div ng-show="generating">
            <md-progress-circular ng-show="generating" md-mode="indeterminate" md-diameter="40" style="margin-left: auto;margin-right: auto;"></md-progress-circular>
            <p style="text-align:center"><br><span ng-show="generating"><?php echo lang('generate_project_pdf_msg') ?></span><br><br></p>
          </div>
          <md-list flex ng-show="!generating">
            <md-list-item>
              <div class="ciuis-custom-list-item-item col-md-12">
                <p><?php echo lang('select_items').' '.lang('for').' '.lang('project').' '.lang('report') ?></p>
                <md-input-container class="md-block" flex-gt-xs>
                  <md-checkbox ng-model="report.customer" ng-value="true" ng-checked="true">
                    <?php echo lang('customer').' '.lang('details') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.summary" ng-value="true" ng-checked="true">
                    <?php echo lang('project').' '.lang('summary') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.services" ng-value="true" ng-checked="true">
                    <?php echo lang('services') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.expenses" ng-value="true" ng-checked="true">
                    <?php echo lang('expenses') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.milestones" ng-value="true" ng-checked="report.tasks">
                    <?php echo lang('milestones') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.tasks" ng-value="true" ng-checked="report.milestones">
                    <?php echo lang('tasks') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.proposals" ng-value="true" ng-checked="true">
                    <?php echo lang('proposals') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.tickets" ng-value="true" ng-checked="true">
                    <?php echo lang('tickets') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.peoples" ng-value="false" ng-checked="false">
                    <?php echo lang('project').' '.lang('members') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.files" ng-value="false" ng-checked="false">
                    <?php echo lang('files').' '.lang('list') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.notes" ng-value="false" ng-checked="false">
                    <?php echo lang('project').' '.lang('notes') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="report.time_logs" ng-value="false" ng-checked="false">
                    <?php echo lang('task').' '.lang('timelogs') ?>
                  </md-checkbox>
                  <p><strong><?php echo lang('heading').' '.lang('color') ?>: </strong></p>
                  <md-radio-group ng-model="report.color">
                    <md-radio-button style="display: inline !important;" value="black" ng-selected="true">
                      <button class="black-color color-box"></button>
                    </md-radio-button>
                    <md-radio-button style="display: inline !important;" value="orange">
                      <button class="orange-color color-box"></button>
                    </md-radio-button>
                    <md-radio-button style="display: inline !important;" value="blue">
                      <button class="blue-color color-box"></button>
                    </md-radio-button>
                    <md-radio-button style="display: inline !important;" value="#42ca91">
                      <button class="green-color color-box"></button>
                    </md-radio-button>
                    <md-radio-button style="display: inline !important;" value="red">
                      <button class="red-color color-box"></button>
                    </md-radio-button>
                  </md-radio-group>
                </md-input-container>
              </div>
            </md-list-item>
          </md-list>
        </md-content>     
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button ng-click="close()"><?php echo lang('cancel') ?></md-button>
        <md-button target="_blank" ng-show="generated" ng-href="{{generated_url}}" class="text-success"><?php echo lang('download') ?></md-button>
        <md-button ng-click="generatePDFReport()" class="template-button" ng-disabled="generating == true">
          <span ng-hide="generating == true"><?php echo lang('generate');?></span>
          <span ng-show="generating == true"><?php echo lang('generating');?></span>
        </md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
  <div style="visibility: hidden">
    <div ng-repeat="milestone in milestones" class="md-dialog-container" id="ShowMilestone-{{milestone.id}}">
      <md-dialog aria-label="Milestone Detail">
        <form>
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
              <h2><?php echo lang('update') ?> {{milestone.name}}</h2>
              <span flex></span>
              <md-button class="md-icon-button" ng-click="close()" aria-label="add">
                <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
              </md-button>
            </div>
          </md-toolbar>
          <md-dialog-content style="max-width:800px;max-height:810px; ">
            <md-content class="bg-white" layout-padding>
              <md-input-container class="md-block">
                <label><?php echo lang('name') ?></label>
                <input required type="text" ng-model="milestone.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('duedate') ?></label>
                <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" show-icon="true" ng-model="milestone.duedate" class=" dtp-no-msclear dtp-input md-input">
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('description') ?></label>
                <textarea required ng-model="milestone.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <md-input-container class="md-block">
                <label><?php echo lang('milestone_order') ?></label>
                <input required type="text" ng-model="milestone.order" class="form-control" id="title" placeholder="<?php echo lang('order'); ?>"/>
              </md-input-container>
            </md-content>
          </md-dialog-content>
          <md-dialog-actions layout="row">
            <md-button ng-click="UpdateMilestone($index)" class="md-raised md-primary pull-right" ng-disabled="savingMilestone == true" aria-label="add">
              <span ng-hide="savingMilestone == true"><?php echo lang('update');?></span>
              <md-progress-circular class="white" ng-show="savingMilestone == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
          </md-dialog-actions>
        </form>
      </md-dialog>
    </div>
  </div>
</md-content>
<script type="text/ng-template" id="delete_project.html">
  <md-dialog aria-label="options dialog">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class="text-danger"><?php echo lang('delete_project_note') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()" aria-label="add">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>

  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="DeleteProject()" class="delete-button" ng-disabled="deletingProject == true" aria-label="add">
      <span ng-hide="deletingProject == true"><?php echo lang('delete');?></span>
      <md-progress-circular ng-show="deletingProject == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script> 

var minDate = new Date();

  var PROJECTID = "<?php echo $projects['id'];?>"; 
  var langs = {};
  langs.marked = '<?php echo lang("marked") ?>';
  langs.remove_staff = '<?php echo lang("remove_staff") ?>';
  langs.doIt = '<?php echo lang("doIt") ?>';
  langs.attention = '<?php echo lang("attention") ?>';
  langs.cancel = '<?php echo lang("cancel") ?>';
  langs.delete_milestone = '<?php echo lang("delete_milestone") ?>';
  langs.marked_as = '<?php echo lang("marked_as") ?>';
  langs.ticket = '<?php echo lang("ticket") ?>';
  langs.attention = '<?php echo lang("attention") ?>';
  langs.delete = '<?php echo lang("delete") ?>';
  langs.ticketattentiondetail = '<?php echo lang("ticketattentiondetail") ?>';
  langs.delete_service_message = "<?php echo lang('delete_service_message')?>";
  
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' ); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/delivery.js') ?>"></script>