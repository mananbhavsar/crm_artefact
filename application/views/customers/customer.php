<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
 <style type="text/css">
  rect.highcharts-background {
    fill: #f3f3f3;
  }
  
  .highcharts-point {
	  cursor:pointer;
  }
  
.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: ''; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: ''; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }
  </style>
<div class="ciuis-body-content" ng-controller="Customer_Controller">
    <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9" >
        <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
                <h2 ng-bind="customer.customer_number"></h2>&nbsp;
                <h2 class="md-pl-10" flex md-truncate ng-show="customer.type =='0'" ng-bind="customer.company"></h2>
                <h2 class="md-pl-10" flex md-truncate ng-show="customer.type =='1'" ng-bind="customer.namesurname"></h2>
                <?php if (check_privilege('customers', 'edit')) { ?> 
                    <md-button ng-click="Update()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
                        <md-icon class="mdi mdi-edit"></md-icon>
                    </md-button>
                <?php } if (check_privilege('customers', 'delete')) { ?> 
                    <md-button ng-click="Delete()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
                        <md-icon class="ion-trash-b"></md-icon>
                    </md-button>
                <?php } ?>
            </div>
        </md-toolbar>
        <div ng-show="customersLoader" layout-align="center center" class="text-center" id="circular_loader">
            <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
            <p style="font-size: 15px;margin-bottom: 5%;">
                <span>
                    <?php echo lang('please_wait') ?> <br>
                    <small><strong><?php echo lang('loading'). ' '. lang('customer').'...' ?></strong></small>
                </span>
            </p>
        </div>
        <section ng-show="!customersLoader" layout="row" flex ng-cloak>
            <md-sidenav class="md-sidenav-left" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')" style="z-index:0" ng-cloak style="width: 450px;">
                <md-subheader class="md-primary"
                style="background-color: white; border-bottom: 1px #e0e0e0 solid; padding-bottom: 2px; border-right: 1px #f3f3f3 solid;">
                <?php echo lang('informations');?> </md-subheader>
                <md-content class="bg-white" style="border-right:1px solid #e0e0e0;">
                    <md-list flex class="md-p-0 sm-p-0 lg-p-0">
					<?php //echo "<pre>";
					//print_r($customers);?>
					<md-list-item>
								<!--	<md-icon class="ion-android-call"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/contact_number_office.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $customers['contact_number_office']?></p>[Contact Number Office]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="ion-android-call"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/contact_person.jpg') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $customers['account_contact_number']?></p>[Contact Person Office]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/credit_period.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $customers['creditperiod']?>"></p>[Credit Period]
								</md-list-item>
								<md-divider></md-divider>
									<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/credit_limit.jpg') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $customers['creditlimit']?>"></p>[Credit Limit]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/lisence_nmber.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $customers['licence_no']?></p>[Liscence Number]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/doc_expiry.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $customers['trade_expiry_date'];?></p>[Expiry Date]
								</md-list-item>
								<md-divider></md-divider>
								<?php if(isset($documents)){
									?>
								<h4>Liscence Documents</h4>
								<?php if(!empty($documents)){foreach($documents as $eachdoc){?>
								<md-list-item>
									<md-icon class="mdi mdi-city material-icons"></md-icon>
									<a href="<?php print base_url();?>customers/download_liscence_document/<?php print $eachdoc['doc_id'];?>"><?php print $eachdoc['trade_document'];?></a> <a href="<?php print base_url();?>customers/delete_liscence_document/<?php print $eachdoc['doc_id'];?>"><md-icon class="ion-trash-b ng-scope material-icons" role="img" aria-hidden="true"></md-icon></a>
								</md-list-item>
								<?php }}else{print "No Documents";}?>
								<md-divider></md-divider>
								<?php }?>
								
								<?php if($customers['sales_team']!=''){
									$sales=explode(',',$customers['sales_team']);
									?>
								<h4>Sales Team</h4>
								<?php $staffdet='';foreach($sales as $eachsale){
									
									$staffdet=$this->Staff_Model->get_staff( $eachsale );
									?>
								<md-list-item>
									<md-icon class="ion-person ng-scope material-icons"></md-icon>
								<p><?php print $staffdet['staffname'];?></p>
								</md-list-item>
								<?php }?>
								<md-divider></md-divider>
								
								<?php }?>
                        <md-list-item>
                           <!-- <md-icon class="ion-android-call"></md-icon> -->
                           <img src="<?php echo base_url('uploads/images/contact_number.png') ?>" alt="" width="30"
                                        height="30" /> 
                            <p ng-bind="customer.phone"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                           <!-- <md-icon class="mdi mdi-http"></md-icon> -->
                            <img src="<?php echo base_url('uploads/images/website.png') ?>" alt="" width="30"
                                        height="30" /> 
                            <p ng-bind="customer.web"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                           <!-- <md-icon class="ion-android-mail"></md-icon> -->
                            <img src="<?php echo base_url('uploads/images/mail_id.png') ?>" alt="" width="30"
                                        height="30" /> 
                            <p ng-bind="customer.email"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                            <md-icon class="ion-earth"></md-icon> 
                           <img src="<?php echo base_url('uploads/images/country.png') ?>" alt="" width="30"
                                        height="30" />  
                            <p ng-bind="customer.country"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                            <md-icon class="mdi mdi-map"></md-icon>
                            <p ng-bind="customer.state"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                           <!-- <md-icon class="mdi mdi-city"></md-icon> -->
                            <img src="<?php echo base_url('uploads/images/city.png') ?>" alt="" width="30"
                                        height="30" /> 
                            <p ng-bind="customer.city"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                            <md-icon class="mdi mdi-city-alt"></md-icon>
                            <p ng-bind="customer.town"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                           <!-- <md-icon class="ion-ios-home"></md-icon> -->
                            <img src="<?php echo base_url('uploads/images/address.png') ?>" alt="" width="30"
                                        height="30" />
                            <p ng-bind="customer.address"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                            <md-icon class="mdi mdi-markunread-mailbox"></md-icon>
                            <p ng-bind="customer.zipcode"></p>
                        </md-list-item>
                        <md-divider></md-divider>
                        <md-list-item>
                            <md-icon class="ion-android-contacts"></md-icon>
                            <p ng-bind="customer.group_name"></p>
                        </md-list-item>
                    </md-list>
                </md-content>
            </md-sidenav>
            <md-content class="bg-white information-section-hide" flex>
                <md-tabs md-dynamic-height md-border-bottom>
                    <md-tab label="<?php echo lang('summary');?>">
                        <md-content class="md-padding bg-white">
                            <div style="border-right: 1px solid rgb(234, 234, 234);"
                            class="col-md-4 hidden-xs xs-pt-20 lg-pt-0">
                            <div class='customer-42525'>
                                <div class='customer-42525__inner'>
                                    <h2><?php echo lang('riskstatus');?></h2>
                                    <small><?php echo lang('customerrisksubtext');?></small>
                                    <div ng-hide="customer.risk != '0'" class="stat"> <span
                                        style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i>
                                        <?php echo lang('norisk') ?></span> </div>
                                        <div ng-show="customer.risk > '50'" class="stat"><span
                                            ng-bind="customer.risk+'%'"></span></div>
                                            <div ng-show="customer.risk > '50'" class="progress">
                                                <div style="width:{{customer.risk}}%"
                                                class="progress-bar progress-bar-danger"></div>
                                            </div>
                                            <div ng-show="customer.risk > '0' && customer.risk < 50" class="stat"><span
                                                ng-bind="customer.risk+'%'"></span></div>
                                                <div ng-show="customer.risk > '0' && customer.risk < 50" class="progress">
                                                    <div style="width:{{customer.risk}}%"
                                                    class="progress-bar progress-bar-primary"></div>
                                                </div>
                                                <p><?php echo lang('customerrisksubtext');?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-right: 1px solid rgb(234, 234, 234);"
                                    class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
                                    <div class='customer-42525'>
                                        <div class='customer-42525__inner'>
                                            <h2><?php echo lang('netrevenue');?></h2>
                                            <small><?php echo lang('netrevenuedetail');?></small>
                                            <div class='stat'> <span ng-show="customer.netrevenue"
                                                ng-bind-html="customer.netrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
                                                <span class="text-success font-10"
                                                ng-show="!customer.netrevenue"><?php echo lang('nosalesyet') ?></span>
                                            </div>
                                            <p><?php echo lang('netrevenuedescription');?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
                                    <div class='customer-42525'>
                                        <div class='customer-42525__inner'>
                                            <h2><?php echo lang('grossrevenue');?></h2>
                                            <small><?php echo lang('grossrevenuedetail');?></small>
                                            <div class='stat'> <span ng-show="customer.grossrevenue"
                                                ng-bind-html="customer.grossrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
                                                <span
                                                ng-show="!customer.grossrevenue"><?php echo lang('nosalesyet') ?></span>
                                            </div>
                                            <p><?php echo lang('grossrevenuedescription');?></p>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-bottom: 10px;">
                                <md-content class="bg-white ciuis-chart" style="align-self: flex-end;">
                                <div class="card">
                                    <canvas width="650px" height="285px" id="customer_annual_sales_chart"></canvas>
                                    <div class="axis">
                                        <div ng-repeat="inline in customer.chart_data.inline_graph" class="tick">
                                            {{inline.month}} <span class="value value--this"
                                            ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span>
                                            <span class="value value--prev"
                                            ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span>
                                        </div>
                                    </div>
                                </div>
                            </md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('invoices');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="invoice in invoices" ng-click="GoInvoice($index)"
                                aria-label="Invoice">
                                <md-icon class="ico-ciuis-invoices"></md-icon>
                                <p><strong ng-bind="invoice.longid"></strong></p>
                                <h4><strong
                                    ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong>
                                </h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!invoices.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
					<!--
                    <md-tab label="<?php echo lang('proposals');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="proposal in proposals" ng-click="GoProposal($index)"
                                aria-label="Proposal">
                                <md-icon class="ico-ciuis-proposals"></md-icon>
                                <p><strong ng-bind="proposal.longid"></strong></p>
                                <h4><strong
                                    ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong>
                                </h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!proposals.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>-->
					<?php if(isset($estimations)){?>
					 <md-tab label="Estimations">
					 <md-content class="bg-white">
					  <?php if(!empty($estimations)){?>
					  <md-list flex class="md-p-0 sm-p-0 lg-p-0">
					  <?php foreach($estimations as $eachest){?>
					  <a href="<?php print base_url();?>estimations/view/<?php print $eachest['estimation_id']; ?>">
                                <md-list-item >
                                <md-icon class="ico-ciuis-proposals"></md-icon>
                                <p><strong ><?php print $eachest['project_name'];?></strong></p>
                                <h4><strong
                                    > <?php print number_format($eachest['estimation_total_amt'],2,'.',',');?> AED</strong>
                                </h4>
                                <md-divider></md-divider>
                            </md-list-item></a>
					  <?php }?>
                        </md-list>
					  <?php }?>
					 <?php if(empty($estimations)){?>
					 <md-content class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
					 <?php }?>
					  </md-content>
					   </md-tab>
					<?php }?>
                    <md-tab label="<?php echo lang('projects');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="project in projects" ng-click="GoProject($index)"
                                aria-label="Project">
                                <md-icon class="ico-ciuis-projects"></md-icon>
                                <p><strong ng-bind="project.name"></strong></p>
                                <h4><strong ng-bind="project.status"></strong></h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!projects.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('tickets');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="ticket in tickets" ng-click="GoTicket($index)"
                                aria-label="Ticket">
                                <md-icon class="ico-ciuis-supports"></md-icon>
                                <p><strong ng-bind="ticket.subject"></strong></p>
                                <p><strong ng-bind="ticket.contactname"></strong></p>
                                <h4><strong ng-bind="ticket.priority"></strong></h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!tickets.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('notes');?>">
                        <md-content class="md-padding bg-white">
                            <section class="ciuis-notes show-notes">
                                <article ng-repeat="note in notes" class="ciuis-note-detail">
                                    <div class="ciuis-note-detail-img"> <img
                                        src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50"
                                        height="50" /> </div>
                                        <div class="ciuis-note-detail-body">
                                            <div class="text">
                                                <p> <span ng-bind="note.description"></span> <a
                                                    ng-click='DeleteNote($index)' style="cursor: pointer;"
                                                    class="mdi ion-trash-b pull-right delete-note-button"></a> </p>
                                                </div>
                                                <p class="attribution"> by <strong><a
                                                    href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}"
                                                    ng-bind="note.staff"></a></strong> at <span
                                                    ng-bind="note.date"></span> </p>
                                                </div>
                                            </article>
                                        </section>
                                        <section class="md-pb-30">
                                            <md-input-container class="md-block">
                                                <label><?php echo lang('description') ?></label>
                                                <textarea required name="description" ng-model="note"
                                                placeholder="<?php echo lang('typeSomething'); ?>"
                                                class="form-control note-description"></textarea>
                                            </md-input-container>
                                            <div class="form-group pull-right">
                                                <button ng-click="AddNote()" type="button"
                                                class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
                                                <?php echo lang('addnote')?>
                                            </button>
                                        </div>
                                    </section>
                                </md-content>
                            </md-tab>
                            <md-tab label="<?php echo lang('reminders');?>">
                                <md-list ng-cloak>
                                    <md-toolbar class="toolbar-white">
                                        <div class="md-toolbar-tools">
                                            <h2><?php echo lang('reminders') ?></h2>
                                            <span flex></span>
                                            <md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip"
                                            aria-label="Add Reminder">
                                            <md-tooltip md-direction="left"><?php echo lang('addreminder') ?></md-tooltip>
                                            <md-icon><i class="ion-plus-round text-success"></i></md-icon>
                                        </md-button>
                                    </div>
                                </md-toolbar>
                                <md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)" class="noright"> <img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
                                    <p>{{ reminder.description }}</p>
                                    <md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3">
                                        <md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
                                        <i class="ion-ios-calendar-outline"></i>
                                    </md-icon>
                                    <md-icon ng-click="DeleteReminder($index)" aria-label="Send Email"
                                    class="md-secondary md-hue-3">
                                    <md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
                                    <i class="ion-ios-trash-outline"></i>
                                </md-icon>
                            </md-list-item>
                        </md-list>
                    </md-tab>
                    <md-tab label="<?php echo lang('customeractivities');?>">
                        <md-content class="md-padding bg-white">
                            <ul class="user-timeline">
                                <li ng-repeat="log in logs | filter: { customer_id: '<?php echo $customers['id'];?>' }">
                                    <div class="user-timeline-title" ng-bind="log.date"></div>
                                    <div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
                                </li>
                            </ul>
                        </md-content>
                    </md-tab>
                </md-tabs>
            </md-content>
            <md-content class="bg-white information-section-show" flex>
                <md-tabs md-dynamic-height md-border-bottom>
                    <md-tab label="<?php echo lang('informations');?>">
                        <md-content class="md-padding bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item>
                                    <md-icon class="ion-android-call"></md-icon>
                                    <p ng-bind="customer.phone"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="mdi mdi-http"></md-icon>
                                    <p ng-bind="customer.web"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="ion-android-mail"></md-icon>
                                    <p ng-bind="customer.email"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="ion-earth"></md-icon>
                                    <p ng-bind="customer.country"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="mdi mdi-map"></md-icon>
                                    <p ng-bind="customer.state"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="mdi mdi-city"></md-icon>
                                    <p ng-bind="customer.city"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="mdi mdi-city-alt"></md-icon>
                                    <p ng-bind="customer.town"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="ion-ios-home"></md-icon>
                                    <p ng-bind="customer.address"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="mdi mdi-markunread-mailbox"></md-icon>
                                    <p ng-bind="customer.zipcode"></p>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-list-item>
                                    <md-icon class="ion-android-contacts"></md-icon>
                                    <p ng-bind="customer.group_name"></p>
                                </md-list-item>
                            </md-list>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('summary');?>">
                        <md-content class="md-padding bg-white">
                            <div style="border-right: 1px solid rgb(234, 234, 234);"
                            class="col-md-4 hidden-xs xs-pt-20 lg-pt-0">
                            <div class='customer-42525'>
                                <div class='customer-42525__inner'>
                                    <h2><?php echo lang('riskstatus');?></h2>
                                    <small><?php echo lang('customerrisksubtext');?></small>
                                    <div ng-hide="customer.risk != '0'" class="stat"> <span style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i>
                                        <?php echo lang('norisk') ?></span> </div>
                                        <div ng-show="customer.risk > '50'" class="stat"><span
                                            ng-bind="customer.risk+'%'"></span></div>
                                            <div ng-show="customer.risk > '50'" class="progress">
                                                <div style="width:{{customer.risk}}%"
                                                class="progress-bar progress-bar-danger"></div>
                                            </div>
                                            <div ng-show="customer.risk > '0' && customer.risk < 50" class="stat"><span
                                                ng-bind="customer.risk+'%'"></span></div>
                                                <div ng-show="customer.risk > '0' && customer.risk < 50" class="progress">
                                                    <div style="width:{{customer.risk}}%"
                                                    class="progress-bar progress-bar-primary"></div>
                                                </div>
                                                <p><?php echo lang('customerrisksubtext');?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="border-right: 1px solid rgb(234, 234, 234);"
                                    class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
                                    <div class='customer-42525'>
                                        <div class='customer-42525__inner'>
                                            <h2><?php echo lang('netrevenue');?></h2>
                                            <small><?php echo lang('netrevenuedetail');?></small>
                                            <div class='stat'> <span ng-show="customer.netrevenue"
                                                ng-bind-html="customer.netrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
                                                <span class="text-success font-10"
                                                ng-show="!customer.netrevenue"><?php echo lang('nosalesyet') ?></span>
                                            </div>
                                            <p><?php echo lang('netrevenuedescription');?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
                                    <div class='customer-42525'>
                                        <div class='customer-42525__inner'>
                                            <h2><?php echo lang('grossrevenue');?></h2>
                                            <small><?php echo lang('grossrevenuedetail');?></small>
                                            <div class='stat'> <span ng-show="customer.grossrevenue"
                                                ng-bind-html="customer.grossrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
                                                <span
                                                ng-show="!customer.grossrevenue"><?php echo lang('nosalesyet') ?></span>
                                            </div>
                                            <p><?php echo lang('grossrevenuedescription');?></p>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-bottom: 10px;">
                                <md-content class="bg-white ciuis-chart" style="align-self: flex-end;">
                                <div class="card">
                                    <canvas width="650px" height="285px" id="customer_annual_sales_chart"></canvas>
                                    <div class="axis">
                                        <div ng-repeat="inline in customer.chart_data.inline_graph" class="tick">
                                            {{inline.month}} <span class="value value--this"
                                            ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span>
                                            <span class="value value--prev"
                                            ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span>
                                        </div>
                                    </div>
                                </div>
                            </md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('invoices');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="invoice in invoices" ng-click="GoInvoice($index)"
                                aria-label="Invoice">
                                <md-icon class="ico-ciuis-invoices"></md-icon>
                                <p><strong ng-bind="invoice.longid"></strong></p>
                                <h4><strong
                                    ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong>
                                </h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!invoices.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('proposals');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="proposal in proposals" ng-click="GoProposal($index)"
                                aria-label="Proposal">
                                <md-icon class="ico-ciuis-proposals"></md-icon>
                                <p><strong ng-bind="proposal.longid"></strong></p>
                                <h4><strong
                                    ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong>
                                </h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!proposals.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('projects');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="project in projects" ng-click="GoProject($index)"
                                aria-label="Project">
                                <md-icon class="ico-ciuis-projects"></md-icon>
                                <p><strong ng-bind="project.name"></strong></p>
                                <h4><strong ng-bind="project.status"></strong></h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!projects.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('tickets');?>">
                        <md-content class="bg-white">
                            <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                                <md-list-item ng-repeat="ticket in tickets" ng-click="GoTicket($index)"
                                aria-label="Ticket">
                                <md-icon class="ico-ciuis-supports"></md-icon>
                                <p><strong ng-bind="ticket.subject"></strong></p>
                                <p><strong ng-bind="ticket.contactname"></strong></p>
                                <h4><strong ng-bind="ticket.priority"></strong></h4>
                                <md-divider></md-divider>
                            </md-list-item>
                        </md-list>
                        <md-content ng-show="!tickets.length" class="md-padding bg-white no-item-data">
                            <?php echo lang('notdata') ?></md-content>
                        </md-content>
                    </md-tab>
                    <md-tab label="<?php echo lang('notes');?>">
                        <md-content class="md-padding bg-white">
                            <section class="ciuis-notes show-notes">
                                <article ng-repeat="note in notes" class="ciuis-note-detail">
                                    <div class="ciuis-note-detail-img"> <img
                                        src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50"
                                        height="50" /> </div>
                                        <div class="ciuis-note-detail-body">
                                            <div class="text">
                                                <p> <span ng-bind="note.description"></span> <a
                                                    ng-click='DeleteNote($index)' style="cursor: pointer;"
                                                    class="mdi ion-trash-b pull-right delete-note-button"></a> </p>
                                                </div>
                                                <p class="attribution"> by <strong><a
                                                    href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}"
                                                    ng-bind="note.staff"></a></strong> at <span
                                                    ng-bind="note.date"></span> </p>
                                                </div>
                                            </article>
                                        </section>
                                        <section class="md-pb-30">
                                            <md-input-container class="md-block">
                                                <label><?php echo lang('description') ?></label>
                                                <textarea required name="description" ng-model="note"
                                                placeholder="<?php echo lang('typeSomething'); ?>"
                                                class="form-control note-description"></textarea>
                                            </md-input-container>
                                            <div class="form-group pull-right">
                                                <button ng-click="AddNote()" type="button"
                                                class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
                                                <?php echo lang('addnote')?>
                                            </button>
                                        </div>
                                    </section>
                                </md-content>
                            </md-tab>
                            <md-tab label="<?php echo lang('reminders');?>">
                                <md-list ng-cloak>
                                    <md-toolbar class="toolbar-white">
                                        <div class="md-toolbar-tools">
                                            <h2><?php echo lang('reminders') ?></h2>
                                            <span flex></span>
                                            <md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip"
                                            aria-label="Add Reminder">
                                            <md-tooltip md-direction="left"><?php echo lang('addreminder') ?></md-tooltip>
                                            <md-icon><i class="ion-plus-round text-success"></i></md-icon>
                                        </md-button>
                                    </div>
                                </md-toolbar>
                                <md-list-item ng-repeat="reminder in in_reminders"
                                ng-click="goToPerson(person.name, $event)" class="noright"> <img
                                alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
                                <p>{{ reminder.description }}</p>
                                <md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3">
                                    <md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
                                    <i class="ion-ios-calendar-outline"></i>
                                </md-icon>
                                <md-icon ng-click="DeleteReminder($index)" aria-label="Send Email"
                                class="md-secondary md-hue-3">
                                <md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
                                <i class="ion-ios-trash-outline"></i>
                            </md-icon>
                        </md-list-item>
                    </md-list>
                </md-tab>
                <md-tab label="<?php echo lang('customeractivities');?>">
                    <md-content class="md-padding bg-white">
                        <ul class="user-timeline">
                            <li ng-repeat="log in logs | filter: { customer_id: '<?php echo $customers['id'];?>' }">
                                <div class="user-timeline-title" ng-bind="log.date"></div>
                                <div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
                            </li>
                        </ul>
                    </md-content>
                </md-tab>
            </md-tabs>
        </md-content>
    </section>
    <md-content ng-show="!customersLoader" ng-show="custom_fields.length" class="time-log-project bg-white" ng-cloak>
        <md-subheader ng-if="custom_fields"><?php echo lang('custom_fields') ?></md-subheader>
        <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
            <md-icon class="{{field.icon}} material-icons"></md-icon>
            <strong flex md-truncate>{{field.name}}</strong>
            <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
            <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
            <p ng-if="field.type === 'date'" class="text-right" flex md-truncate
            ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
            <p ng-if="field.type === 'select'" class="text-right" flex md-truncate
            ng-bind="custom_fields[$index].selected_opt.name"></p>
            <md-divider ng-if="custom_fields"></md-divider>
        </md-list-item>
    </md-content>
    <md-content ng-show="customer.subsidiaries.length" class="time-log-project bg-white" ng-cloak>
        <md-divider></md-divider>
        <md-subheader class="md-primary toolbar-white">
            <md-truncate><?php echo lang('subsidiary_companies') ?></md-truncate>
        </md-subheader>
    </md-content>
</div>
<div class="main-content container-fluid col-md-3 md-pl-0">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <h2 flex md-truncate class="pull-left"><strong><?php echo lang('customercontacts')?></strong></h2>
            <?php if (check_privilege('customers', 'edit')) { ?> 
                <md-button ng-click="NewContact();get_contact_permissions();GetCustomerContacts(customer.id);" class="md-icon-button md-primary" aria-label="Add contact" ng-cloak>
                    <md-icon class="ion-person-add"></md-icon>
                </md-button>
            <?php } ?>
        </div>
    </md-toolbar>
    <md-content ng-show="!customersLoader" class="bg-white">
        <md-list flex ng-cloak>
            <md-list-item class="md-2-line" ng-repeat="contact in contacts" 
            aria-label="Contact Detail">
            <div data-letter-avatar="{{contact.name.charAt(0)+contact.surname.charAt(0)}}" class="ticket-area-av-im2 md-avatar text-uppercase"></div>
            <div class="md-list-item-text" ng-class="{'md-offset': phone.options.offset }">
                <h3 ng-bind="contact.name+' '+contact.surname"></h3>
                <p ng-bind="contact.email"></p>
            </div>
            <?php if (check_privilege('customers', 'edit')) { ?> 
                <md-button class="md-icon-button" ng-click="ContactDetail($index)" aria-label="View" style="margin:auto">
                  <md-icon><i class="ion-compose text-muted"></i></md-icon>
              </md-button>
            <?php } if (check_privilege('customers', 'delete')) { ?> 
              <md-button class="md-icon-button" ng-click="RemoveContact(contact.id)" aria-label="Delete" style="margin:auto">
                  <md-icon><i class="ion-android-delete text-muted"></i></md-icon>
              </md-button>
            <?php } ?>
            <md-divider></md-divider>
        </md-list-item>
    </md-list>
</md-content>
<md-content ng-if="!contacts.length" class="text-center bg-white"><img width="100%"
    src="<?php echo base_url('assets/img/add_contact.png') ?>" alt=""></md-content>
</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewContact" ng-cloak style="width: 450px;">
        <md-tabs md-selected="tabIndex" md-dynamic-height="" md-border-bottom="">
            <md-tab label="<?php echo lang('create_contact_title') ?>">
                <md-content class="md-padding bg-white">
                  <div class="col-md-12 nopadding">
                      <md-content layout-padding>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactname') ?></label>
                            <input type="text" ng-model="newcontact.name" required>
                        </md-input-container>
						
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactsurname') ?></label>
                            <input type="text" ng-model="newcontact.surname">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactemail') ?></label>
                            <input type="text" ng-model="newcontact.email" required>
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactposition') ?></label>
                            <input type="text" ng-model="newcontact.position">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactphone') ?></label>
                            <input type="text" ng-model="newcontact.phone">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('extension') ?></label>
                            <input type="text" ng-model="newcontact.extension">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactmobile') ?></label>
                            <input type="text" ng-model="newcontact.mobile">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactskype') ?></label>
                            <input type="text" ng-model="newcontact.skype">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('contactlinkedin') ?></label>
                            <input type="text" ng-model="newcontact.linkedin">
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label><?php echo lang('address') ?></label>
                            <input type="text" ng-model="newcontact.address">
                        </md-input-container>
                        <md-input-container class="md-block password-input" ng-show="isPrimary">
                            <label><?php echo lang('password') ?></label>
                            <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc"
                            data-character-set="a-z,A-Z,0-9,#">
                            <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
                        </md-input-container>
                        <md-input-container class="md-block pull-left">
                            <md-checkbox ng-model="isPrimary"><?php echo lang('primarycontact') ?></md-checkbox>
                        </md-input-container>
                        <section >
                            <md-button ng-click="Contact()"  ng-href="#" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
                                <span ng-hide="saving == true"><?php echo lang('next');?></span>
                                <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate"
                                md-diameter="20"></md-progress-circular>
                            </md-button>
                            <br/><br/><br/><br/>
                        </section>
                    </md-content>
                </div>  
            </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('privileges') ?>">
         <md-content class="md-padding bg-white">
             <div layout="row" layout-wrap>
                 <div flex-gt-xs="100" flex-xs="100" ng-repeat="permission in permissions">
                     <md-switch ng-model="permission.value"  aria-label="Status"><strong class="text-muted"> {{permission.name}}</strong></md-switch>
                 </div>
             </div>
             <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                 <br>
                 <md-button ng-click="AddContact()" class="template-button block-button" ng-disabled="saving == true">
                     <span ng-hide="saving == true"><?php echo lang('create');?></span>
                     <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                 </md-button>
                 <br><br>
             </section>
         </md-content> 
     </md-tab>
 </md-tabs>
</md-sidenav>
<div style="visibility: hidden">
    <div ng-repeat="contact in contacts" class="md-dialog-container" id="ContactModal-{{contact.id}}">
        <md-dialog aria-label="ContactModal">
            <form>
                <md-toolbar class="toolbar-white">
                    <div class="md-toolbar-tools">
                        <h2>{{contact.name}} {{contact.surname}}</h2>
                        <span flex></span>
                        <md-button class="md-icon-button" ng-click="CloseModal()">
                            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black">
                            </md-icon>
                        </md-button>
                    </div>
                </md-toolbar>
                <md-dialog-content style="max-width:800px;max-height:810px; ">
                    <md-tabs md-dynamic-height md-border-bottom>
                        <md-tab label="<?php echo lang('contact') ?>">
                            <md-content class="md-padding bg-white">
                                <md-list flex>
                                    <md-list-item>
                                        <md-icon class="mdi mdi-case"></md-icon>
                                        <p><?php echo lang('contactposition')?></p>
                                        <p class="md-secondary" ng-bind="contact.position"></p>
                                    </md-list-item>
                                    <md-divider></md-divider>
                                    <md-list-item>
                                        <md-icon class="mdi mdi-phone"></md-icon>
                                        <p><?php echo lang('contactphone')?></p>
                                        <p class="md-secondary" ng-bind="contact.phone + '-' + contact.extension">
                                        </p>
                                    </md-list-item>
                                    <md-divider></md-divider>
                                    <md-list-item>
                                        <md-icon class="mdi ion-iphone"></md-icon>
                                        <p><?php echo lang('contactmobile')?></p>
                                        <p class="md-secondary" ng-bind="contact.mobile"></p>
                                    </md-list-item>
                                    <md-divider></md-divider>
                                    <md-list-item>
                                        <md-icon class="mdi mdi-pin"></md-icon>
                                        <p><?php echo lang('contactaddress')?></p>
                                        <p class="md-secondary" ng-bind="contact.address"></p>
                                    </md-list-item>
                                    <md-divider></md-divider>
                                    <md-list-item>
                                        <md-icon class="mdi mdi-skype"></md-icon>
                                        <p><?php echo lang('contactskype')?></p>
                                        <p class="md-secondary" ng-bind="contact.skype"></p>
                                    </md-list-item>
                                    <md-divider></md-divider>
                                    <md-list-item>
                                        <md-icon class="mdi mdi-linkedin"></md-icon>
                                        <p><?php echo lang('contactlinkedin')?></p>
                                        <p class="md-secondary" ng-bind="contact.linkedin"></p>
                                    </md-list-item>
                                </md-list>
                            </md-content>
                        </md-tab>
                        <md-tab label="<?php echo lang('update') ?>">
                            <md-content class="md-padding bg-white">
                                <div class="col-md-12 nopadding">
                                    <md-input-container flex-gt-sm class="col-md-4">
                                        <label><?php echo lang('contactname');?></label>
                                        <input ng-model="contact.name">
                                    </md-input-container>
									
                                    <md-input-container flex-gt-sm class="col-md-4">
                                        <label><?php echo lang('contactsurname');?></label>
                                        <input ng-model="contact.surname">
                                    </md-input-container>
                                    <md-input-container flex-gt-sm class="col-md-4">
                                        <label><?php echo lang('contactposition');?></label>
                                        <input ng-model="contact.position">
                                    </md-input-container>
                                </div>
                                <div class="col-md-12 nopadding">
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('contactphone');?></label>
                                        <input ng-model="contact.phone">
                                    </md-input-container>
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('extension');?></label>
                                        <input ng-model="contact.extension">
                                    </md-input-container>
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('contactmobile');?></label>
                                        <input ng-model="contact.mobile">
                                    </md-input-container>
                                </div>
                                <div class="col-md-12 nopadding">
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('contactemail');?></label>
                                        <input ng-model="contact.email">
                                    </md-input-container>
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('contactskype');?></label>
                                        <input ng-model="contact.skype">
                                    </md-input-container>
                                    <md-input-container class="col-md-4">
                                        <label><?php echo lang('contactlinkedin');?></label>
                                        <input ng-model="contact.linkedin">
                                    </md-input-container>
                                </div>
                                <div class="col-md-12 nopadding">
                                    <md-input-container class="col-md-12">
                                        <label><?php echo lang('contactaddress');?></label>
                                        <input ng-model="contact.address">
                                    </md-input-container>
                                </div>
                            </md-content>
                        </md-tab>
                        <md-tab label="<?php echo lang('privileges') ?>">
                            <md-content class="md-padding bg-white">
                                <div ng-repeat="privilege in contact.privileges">
                                    <md-switch ng-model="privilege.value"
                                    ng-change="UpdateContactPrivilege(contact.id,privilege.value,privilege.id)"
                                    aria-label="Status"><strong class="text-muted">{{privilege.name}}</strong>
                                </md-switch>
                            </div>
                        </md-content>
                    </md-tab>
                </md-tabs>
            </md-dialog-content>
            <md-dialog-actions layout="row">
                <md-button ng-click='ChangePassword(contact.id, contact.password)' md-autofocus>
                    <?php echo lang('changepassword')?> 
                </md-button>
                <span flex></span>
                <md-button ng-click='RemoveContact(contact.id)' ng-click="answer('not useful')">
                    <?php echo lang('delete')?>
                </md-button>
                <md-button ng-click="UpdateContact($index)" ng-click="answer('useful')"
                    style="margin-right:20px;" class="template-button" ng-disabled="updatingContact == true">
                    <span ng-hide="updatingContact == true"><?php echo lang('update');?></span>
                    <md-progress-circular class="white" ng-show="updatingContact == true"
                    md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                </md-button>
            </md-dialog-actions>
        </form>
    </md-dialog>
</div>
</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> </md-button>
                <md-truncate><?php echo lang('addreminder') ?></md-truncate>
            </div>
        </md-toolbar>
        <md-content layout-padding="">
            <md-content layout-padding>
                <md-input-container class="md-block">
                    <label><?php echo lang('datetobenotified') ?></label>
                    <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
                    placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true"
                    min-date="date" show-icon="true" ng-model="reminder_date"
                    class=" dtp-no-msclear dtp-input md-input">
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('setreminderto'); ?></label>
                    <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff"
                        name="country_id" style="min-width: 200px;">
                        <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
                    </md-select>
                </md-input-container>
                <br>
                <md-input-container class="md-block">
                    <label><?php echo lang('description') ?></label>
                    <textarea required name="description" ng-model="reminder_description"
                    placeholder="<?php echo lang('typeSomething'); ?>"
                    class="form-control note-description"></textarea>
                </md-input-container>
                <div class="form-group pull-right">
                    <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
                    type="submit">
                    <?php echo lang('addreminder')?>
                </button>
            </div>
        </md-content>
    </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="width: 450px" ng-cloak>
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> </md-button>
                <md-truncate flex><?php echo lang('update') ?></md-truncate>
                <md-switch ng-model="customer.customer_status_id" aria-label="Active"><strong class="text-muted"><?php echo lang('active')?></strong></md-switch>
            </div>
        </md-toolbar>
            <md-content layout-padding>
                <md-input-container ng-show="customer.isIndividual != true" class="md-block">
                    <label><?php echo lang('company'); ?></label>
                    <md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
                    <input name="company" ng-model="customer.company">
                </md-input-container>
				<md-input-container class="md-block">
                    <label>Business Type</label>
                    <md-select placeholder="<?php echo lang('customer').' '.lang('group'); ?>" ng-model="customer.group_id"
                        style="min-width: 200px;" required>
                        <md-option ng-value="name.id" ng-repeat="name in groups">{{name.name}}</md-option>
                    </md-select>
                </md-input-container>
                <br>
				<md-input-container class="md-block">
				  <label>Contact Person (Accounts)</label>
				   <input name="account_contact_number" ng-model="customer.account_contact_number">
				</md-input-container>
				<md-input-container class="md-block">
					<label>Contact Person Email(Accounts)</label>
					<input type="email" ng-model="customer.companyemail"  minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/">
				</md-input-container>
				<md-input-container class="md-block">
					<label>Company Address</label>
					<textarea ng-model="customer.address" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				 <md-input-container class="md-block">
                    <label><?php echo $appconfig['tax_label'].' '.lang('taxofficeedit'); ?></label>
                    <input name="taxoffice" ng-model="customer.taxoffice">
                </md-input-container>
				<md-input-container class="md-block">
                    <label><?php echo $appconfig['tax_label'].' '.lang('taxnumberedit'); ?></label>
                    <input name="taxnumber" ng-model="customer.taxnumber">
                </md-input-container>
				<md-input-container class="md-block">
                    <label><?php echo lang('phone'); ?></label>
                    <input name="phone" ng-model="customer.phone">
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('fax'); ?></label>
                    <input name="fax" ng-model="customer.fax">
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('customerweb'); ?></label>
                    <input name="web" ng-model="customer.web">
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('country'); ?></label>
                    <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id"
                        ng-change="getStates(customer.country_id)" name="country_id" style="min-width: 200px;">
                        <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
                    </md-select><br>
                </md-input-container>
                <br>
                <md-input-container class="md-block">
                    <label><?php echo lang('state'); ?></label>
                    <md-select placeholder="<?php echo lang('state'); ?>" ng-model="customer.state_id" name="state_id"
                        style="min-width: 200px;">
                        <md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
                    </md-select>
                </md-input-container>
				 <md-input-container class="md-block">
                    <label><?php echo lang('zipcode'); ?></label>
                    <input name="zipcode" ng-model="customer.zipcode">
                </md-input-container>
				
			    <h5>Trade Details</h5>
			   <md-input-container >
				  <label for="licence_no">Licence No.</label>
				 <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no" ng-model="customer.licence_no">
			   </md-input-container>
			   <md-input-container>
					<label for="expiry_date"> Expiry Date</label>
					<md-datepicker name="trade_expiry_date" ng-model="customer.trade_expiry_date" md-open-on-focus></md-datepicker>
			   </md-input-container>
			   <md-input-container class="md-block">
					<label for="inputAddress"> Documents</label><br>
					<input type="file" multiple  id="upload_file" name="upload_file[]" onchange="preview_image();">
					<div class="loder col-md-1"></div>
					<div id="image_preview" ></div> 
			   </md-input-container>
			   <md-input-container class="md-block">
				   <label for="inputAddress">Terms And Conditions</label>
				   <textarea type="text"  id="terms_and_conditions" placeholder="Terms And Conditions" name="terms_and_conditions" ng-model="customer.terms_and_conditions" md-maxlength="500" rows="3"></textarea>
			  </md-input-container class="md-block">
			   <md-input-container class="md-block">
					<label for="inputAddress">Notes</label>
					<textarea type="text" class="" id="notes" placeholder="Notes" name="notes" ng-model="customer.notes"md-maxlength="500" rows="3"></textarea>
			  </md-input-container>
			  <label>Individual/Team</label>
				<div class="switchToggle">
					
					<div class="row">
						<div class="col-md-1"><i class="fa fa fa-user fa-2x" style="padding-left:15%;"></i></div>
						<div class="col-md-2">
							<input type="checkbox" ng-model='customer.is_individual' ng-change="switchcheck(customer.is_individual,customer.main_sales_person)" id="switch"><label for="switch">Toggle</label>
						</div>
						<div class="col-md-9"><i class="fa fa fa-users fa-2x" style="padding-left:8%;"></i></div>
					</div>
				</div>
			<md-input-container class="md-block">
				  <label>Sales Managers </label>
				  <md-select placeholder="Sales Managers" name="main_sales_person" style="min-width: 200px;" ng-model="customer.main_sales_person" required ng-change="selectSaleTeam(customer.main_sales_person)" id="main_sales_person">
					<?php
					foreach ($saleswise as $eachsale) { 
					?>
						<md-option ng-value='"<?php echo $eachsale['id'] ?>"'><?php echo $eachsale['staffname']; ?></md-option>
					<?php } ?>
				  </md-select>
		    </md-input-container>
			<div id="sale_team_div"  ng-show="customer.is_individual ==true">
			<md-input-container class="md-block">
				  <label>Sales Teams </label>
				  <md-select placeholder="Sales Teams" name="sales_team[]" style="min-width: 200px;" ng-model="customer.sales_team" multiple>
					<?php
					foreach ($saleswise as $eachsale) {
					$selected = in_array($eachsale['id'],$sales_res) ? "selected=selected" : '';
					?>
					  <md-option class="sales_team_opt" ng-value='"<?php echo $eachsale['id'] ?>"' <?php echo $selected;?>><?php echo $eachsale['staffname']; ?></md-option>
					<?php } ?>
				  </md-select>
		    </md-input-container>
			</div>
			<md-input-container class="md-block">
                    <label><?php echo lang('default_payment_method'); ?></label>
                    <md-select placeholder="<?php echo lang('default_payment_method'); ?>"
                        ng-model="customer.default_payment_method" name="default_payment_method" style="min-width: 200px;">
                        <?php 
                        $gateways = get_active_payment_methods();
                        foreach ($gateways as $gateway) { ?>
                          <md-option ng-value='"<?php echo $gateway['relation'] ?>"'><?php echo lang($gateway['relation'])?lang($gateway['relation']):$gateway['name'] ?></md-option>
                      <?php } ?>
                    </md-select>
             </md-input-container>
                <br>
		     <md-input-container class="md-block">
				<label for="creditperiod">Credit Period(Days)</label>
				<input type="text" class=" required" required id="creditperiod" placeholder="Credit Period" name="creditperiod" ng-model="customer.creditperiod">
			</md-input-container>
			<md-input-container class="md-block">
			  <label for="creditlimit">Credit Limit(AED)</label>
			  <input type="text" class=" required" required id="creditlimit" placeholder="Credit Limit" name="creditlimit" ng-model="customer.creditlimit">
			</md-input-container>
	
				<!--
                <md-input-container ng-show="customer.isIndividual == true" class="md-block">
                    <label><?php echo lang('namesurname'); ?></label>
                    <md-icon md-svg-src="<?php echo base_url('assets/img/icons/individual.svg') ?>"></md-icon>
                    <input name="namesurname" ng-model="customer.namesurname">
                </md-input-container>
               
               
                <md-input-container ng-show="customer.isIndividual == true" class="md-block">
                    <label><?php echo lang('ssn'); ?></label>
                    <input name="ssn" ng-model="customer.ssn" ng-pattern="/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/" />
                    <div class="hint" ng-if="showHints">###-##-####</div>
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('executiveupdate'); ?></label>
                    <input name="executive" ng-model="customer.executive">
                </md-input-container>

                <md-input-container class="md-block">
                    <label><?php echo lang('city'); ?></label>
                    <input name="city" ng-model="customer.city">
                </md-input-container>
                <md-input-container class="md-block">
                    <label><?php echo lang('town'); ?></label>
                    <input name="town" ng-model="customer.town">
                </md-input-container>-->
				<!--<md-input-container class="md-block">
				  <label>Contact Person Office</label>
				  <input name="contact_number_office" ng-model="customer.contact_number_office">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('Contact Person Mail Id'); ?></label>
					<input name="email" ng-model="customer.email" required minlength="10" maxlength="100"
					ng-pattern="/^.+@.+\..+$/" />
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="customer.address" name="address" md-maxlength="500" rows="3"
					md-select-on-focus></textarea>
				</md-input-container>-->
                <md-slider-container> <span><?php echo lang('riskstatus');?></span>
                    <md-slider flex min="0" max="100" ng-model="customer.risk" aria-label="red" id="red-slider">
                    </md-slider>
                    <md-input-container>
                        <input name="risk" flex type="number" ng-model="customer.risk" aria-label="red"
                        aria-controls="red-slider">
                    </md-input-container>
                </md-slider-container>
            </md-content>
            <md-subheader class="md-primary">
                <md-truncate><?php echo lang('billing_address') ?></md-truncate>
                <md-button ng-click='SameAsCustomerAddress()' class="md-icon-button" aria-label="Copy Customer Address">
                    <md-icon class="ion-ios-copy">
                        <md-tooltip md-direction="right"><?php echo lang('same_as_customer') ?></md-tooltip>
                    </md-icon>
                </md-button>
                <md-button class="pull-right hide-pinned-projects md-icon-button"
                aria-label="<?php echo lang('billing_address') ?>">
                <a data-toggle="collapse" data-parent="#billing_address" href="#billing_address">
                    <md-icon class="ion-chevron-down">
                    </md-icon>
                </a>
            </md-button>
        </md-subheader>
        <md-content layout-padding id="billing_address" class="panel-collapse collapse out">
            <md-input-container class="md-block">
                <label><?php echo lang('address') ?></label>
                <textarea ng-model="customer.billing_street" name="address" md-maxlength="500" rows="3"
                md-select-on-focus></textarea>
            </md-input-container>
            <md-input-container class="md-block">
                <label><?php echo lang('country'); ?></label>
                <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.billing_country"
                    ng-change="getBillingStates(customer.billing_country)" name="billing_country"
                    style="min-width: 200px;">
                    <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
                </md-select><br>
            </md-input-container>
            <md-input-container class="md-block">
                <label><?php echo lang('state'); ?></label>
                <md-select placeholder="<?php echo lang('state'); ?>" ng-model="customer.billing_state_id"
                    name="billing_state_id" style="min-width: 200px;">
                    <md-option ng-value="state.id" ng-repeat="state in billingStates">{{state.state_name}}</md-option>
                </md-select>
            </md-input-container>
            <md-input-container class="md-block">
                <label><?php echo lang('city'); ?></label>
                <input name="city" ng-model="customer.billing_city">
            </md-input-container>
            <md-input-container class="md-block">
                <label><?php echo lang('zipcode'); ?></label>
                <input name="zipcode" ng-model="customer.billing_zip">
            </md-input-container>
        </md-content>
        <md-subheader class="md-primary">
            <md-truncate><?php echo lang('shipping_address') ?></md-truncate>
            <md-button ng-click='SameAsBillingAddress()' class="md-icon-button" aria-label="Favorite">
                <md-icon class="ion-ios-copy">
                    <md-tooltip md-direction="right"><?php echo lang('same_as_billing') ?></md-tooltip>
                </md-icon>
            </md-button>
            <md-button class="pull-right hide-pinned-projects md-icon-button"
            aria-label="<?php echo lang('shipping_address') ?>">
            <a data-toggle="collapse" data-parent="#shipping_address" href="#shipping_address">
                <md-icon class="ion-chevron-down">
                </md-icon>
            </a>
        </md-button>
    </md-subheader>
    <md-content layout-padding id="shipping_address" class="panel-collapse collapse out">
        <md-input-container class="md-block">
            <label><?php echo lang('address') ?></label>
            <textarea ng-model="customer.shipping_street" name="address" md-maxlength="500" rows="3"
            md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
            <label><?php echo lang('country'); ?></label>
            <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.shipping_country"
                ng-change="getShippingStates(customer.shipping_country)" name="shipping_country"
                style="min-width: 200px;">
                <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
            </md-select><br>
        </md-input-container>
        <md-input-container class="md-block">
            <label><?php echo lang('state'); ?></label>
            <md-select placeholder="<?php echo lang('states'); ?>" ng-model="customer.shipping_state_id"
                name="shipping_state_id" style="min-width: 200px;">
                <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
            </md-select>
        </md-input-container>
        <md-input-container class="md-block">
            <label><?php echo lang('city'); ?></label>
            <input name="city" ng-model="customer.shipping_city">
        </md-input-container>
        <md-input-container class="md-block">
            <label><?php echo lang('zipcode'); ?></label>
            <input name="zipcode" ng-model="customer.shipping_zip">
        </md-input-container>
    </md-content>
    <custom-fields-vertical></custom-fields-vertical>
    <br>
    <md-content layout-padding>
        
    </md-content>
    <br>
    <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
        <md-button ng-click="UpdateCustomer()" class="md-raised md-primary btn-report block-button" ng-disabled="savingCustomer == true">
            <span ng-hide="savingCustomer == true"><?php echo lang('update');?></span>
            <md-progress-circular class="white" ng-show="savingCustomer == true" md-mode="indeterminate"
            md-diameter="20"></md-progress-circular>
        </md-button>
        <br/><br/><br/><br/>
    </section>
</md-sidenav>
</div>
<script>
    var CUSTOMERID = "<?php echo $customers['id'];?>";
    var lang ={};
    lang.doIt = "<?php echo lang('doIt')?>";
    lang.cancel = "<?php echo lang('cancel')?>";
    lang.attention = "<?php echo lang('attention')?>";
    lang.delete_customer = "<?php echo lang('customerattentiondetail')?>";
    lang.delete_contact = "<?php echo lang('contactattentiondetail')?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/customers.js') ?>"></script>
<script>
function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;

 for(var i=0;i<total_file;i++)
 {
 //console.log(event.target.files[i]['name']);
 //$('.loder').html('<img src="<?php print base_url();?>front/LoaderIcon.gif">');
 var file_data = event.target.files[i];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
		
  $.ajax({
            url: '<?php print base_url();?>supplier/form_add_image',
			 type        : 'post',
            cache       : false,
        contentType : false,
        processData : false,
        data        : form_data,
            success: function(response){
                if(response != 0){
					if(response.error){
					$('.error').show();
					$('.error').html(response.error);
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					}else{
					//$('.loder').html('');
                    //$("#img").attr("src",response); 
                    //$(".preview img").show(); // Display image element
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					$('#image_preview').append("<div class='col-md-3' id='clients-edit-wrapper'><div class='close-wrapper'> <a  class='close-div text-danger' style='cursor:pointer;'>Delete</a></div><input type='hidden' name='test_image[]' value='"+response.image_name+"' ng-model='customer.test_image' id='test_image' class='imagename'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
					}
                }else{
                    alert('file not uploaded');
                }
            },
        });  
 
 }
}

$(document).on('click', '.close-div', function(){
	
    $(this).closest("#clients-edit-wrapper").remove();
});


</script>