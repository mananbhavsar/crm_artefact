<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Reports_Controller">
	<md-content class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
	<md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
		  <md-icon><i class="ico-ciuis-leads text-warning"></i></md-icon>
		</md-button>
		<h2 flex md-truncate><?php echo lang('reports') ?></h2>
	  </div>
	</md-toolbar>
	<md-content class="">
		<md-tabs md-dynamic-height md-border-bottom md-selected="ctrl.selectedIndex">
		  <md-tab label="<?php echo lang('overview') ?>">
		  	<div ng-show="overview.loader" layout-align="center center" class="text-center" id="circular_loader">
		  		<md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
				<p style="font-size: 15px;margin-bottom: 5%;">
					<span>
						<?php echo lang('please_wait') ?> <br>
						<small><strong><?php echo lang('loading'). ' '. lang('overview').'...' ?></strong></small>
					</span>
				</p>
			</div>
			<md-content class="md-padding"  ng-show="!overview.loader">
				<md-content class="widget-fullwidth ciuis-body-loading">
					<md-card flex-xs flex-gt-xs="100" layout="column">
						<div layout-xs="column" layout="row" class="bg-white">
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card1">
								<a href="tickets">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalTickets"></strong></span>
											<span class="md-subhead"><?php echo lang('total_tickets') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card2">
								<a href="customers">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalCustomers"></strong></span>
											<span class="md-subhead"><?php echo lang('total_customers') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card3">
								<a href="leads">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalLeads"></strong></span>
											<span class="md-subhead"><?php echo lang('total_leads') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card4">
								<a href="projects">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalProjects"></strong></span>
											<span class="md-subhead"><?php echo lang('total_projects') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card5">
								<a href="products">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalProducts"></strong></span>
											<span class="md-subhead"><?php echo lang('total_products') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
						</div>
					</md-card>
					<div layout-xs="column" layout="row" class="">
						<div flex-xs flex-gt-xs="45" layout="column">
							<md-card>
								<div class="widget-chart-container">
									<div class="widget-counter-group widget-counter-group-right">
										<div style="width: auto;" class="pull-left">
											<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
											<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
												<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('payments_vs_expenses');?></b></h4>
												<small><?php echo lang('payments_vs_expenses_chart');?></small>
											</div>
										</div>
										<div class="pull-right">
											<md-input-container class="md-block">
												<md-select ng-model="paymentsExpensesByYear" ng-change="getPaymentsExpensesByYear(paymentsExpensesByYear)" style="min-width: 100px;">
													<md-option ng-value="2020">2020</md-option>
													<md-option ng-value="2019" ng-selected="true">2019</md-option>
													<md-option ng-value="2018">2018</md-option>
													<md-option ng-value="2017">2017</md-option>
													<md-option ng-value="2016">2016</md-option>
													<md-option ng-value="2015">2015</md-option>
													<md-option ng-value="2014">2014</md-option>
												</md-select>
											</md-input-container>
										</div>
									</div>
									<div class="my-2">
										<div class="chart-wrapper" style="">
											<canvas style="" id="incomingsvsoutgoins"></canvas>
										</div>
									</div>
								</div>
							</md-card>
						</div>
						<div flex-xs flex-gt-xs="50" layout="column">
							<md-card>
								<div class="widget-chart-container">
									<div class="widget-counter-group widget-counter-group-right">
										<div style="width: auto;" class="pull-left">
											<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
											<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
												<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('payments_vs_expenses_weekly');?></b></h4>
												<small><?php echo lang('payments_vs_expenses_chart_weekly');?></small>
											</div>
										</div>
									</div>
									<div class="my-2">
										<div id="incomingsvsoutgoins_weekly" style="">
										</div>
									</div>
								</div>
							</md-card>
						</div>
					</div>
					<md-card flex-xs flex-gt-xs="100" layout="column" class="text-center">
						<h3><?php echo lang('sales_data') ?></h3>
						<div layout-xs="column" layout="row">
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card6">
								<a href="invoices">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalInvoices"></strong></span>
											<span class="md-subhead"><?php echo lang('total_invoices') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card7">
								<a href="#">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalQotations">0</strong></span>
											<span class="md-subhead"><?php echo lang('total_qotations') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card1">
								<a href="orders">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalOrders"></strong></span>
											<span class="md-subhead"><?php echo lang('total_orders') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card8">
								<a href="leads">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalLeads"></strong></span>
											<span class="md-subhead"><?php echo lang('total_leads') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
							<md-card flex-xs flex-gt-xs="20" layout="column" class="text-center card9">
								<a href="tasks">
									<md-card-title>
										<md-card-title-text>
											<span class="md-headline"><strong ng-bind="report.totalTasks"></strong></span>
											<span class="md-subhead"><?php echo lang('total_tasks') ?></span>
										</md-card-title-text>
									</md-card-title>
								</a>
							</md-card>
						</div>
					</md-card>
				</md-content>
				<div layout-xs="column" layout="row" class="">
					<div flex-xs flex-gt-xs="45" layout="column">
						<md-card>
							<div class="widget-chart-container">
								<div class="widget-counter-group widget-counter-group-right">
									<div style="width: auto;" class="pull-left">
										<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
										<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
											<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('incomingsvsoutgoings');?></b></h4>
											<small><?php echo lang('currentyearstats');?></small>
										</div>
									</div>
								</div>
								<div class="my-2">
									<div class="chart-wrapper" style="height:auto">
										<canvas style="padding-top: 25px;" id="expensesbycategories"></canvas>
									</div>
								</div>
							</div>
						</md-card>
					</div>
					<div flex-xs flex-gt-xs="45" layout="column">
						<md-card>
							<div class="widget-chart-container">
								<div class="widget-counter-group widget-counter-group-right">
									<div style="width: auto;" class="pull-left">
										<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
										<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
											<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('staffbasedgraphics');?></b></h4>
											<small><?php echo lang('currentweekstats');?></small>
										</div>
									</div>
								</div>
								<div class="my-2">
									<div class="chart-wrapper" style="height:auto">
										<canvas style="padding-top: 25px;" id="top_selling_staff_chart"></canvas>
									</div>
								</div>
							</div>
						</md-card>
					</div>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('invoicessummary') ?>">
			
		  	<md-content class="md-padding">
			  	<div layout-xs="column" layout="row" class="">
			  		<div flex-xs flex-gt-xs="45" layout="column">
			  			<md-card>
							<div class="widget-counter-group widget-counter-group-right">
								<div style="width: auto" class="pull-left">
									<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
									<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
										<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('invoicesbystatuses');?></b></h4>
										<small><?php echo lang('billsbystatus');?></small>
									</div>
								</div>
							</div>
							<div class="my-2">
								<div class="chart-wrapper">
									<canvas id="invoice_chart_by_status"></canvas>
								</div>
							</div>
						</md-card>
					</div>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('customersummary') ?>">
		  	<md-content class="md-padding">
			  	<div layout-xs="column" layout="row" class="">
			  		<div flex-xs flex-gt-xs="100" layout="column">
			  			<md-card>
							<div layout="row" layout-align="start" flex>
								<md-input-container flex="50">
									<?php
									echo '<md-select ng-model="CustomerReportMonth" placeholder="Select a state" ng-change="CustomerMonthChanged()">' . PHP_EOL;
									for ( $m = 1; $m <= 12; $m++ ) {
										$_selected = '';
										if ( $m == date( 'm' ) ) {
											$_selected = ' selected';
										}
										echo '<md-option ng-value="' . $m . '"' . $_selected . '>' . ( date( 'F', mktime( 0, 0, 0, $m, 1 ) ) ) . '</md-option>' . PHP_EOL;
									}
									echo '</md-select>' . PHP_EOL;
									?>
								</md-input-container>
							</div>
							<canvas class="customergraph_ciuis-xe chart mtop20" id="customergraph_ciuis-xe" height="400px" style="height: 400px"></canvas>
						</md-card>
					</div>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('lead') ?>">
		  	<md-content class="md-padding">
			  	<div layout-xs="column" layout="row" class="">
			  		<div flex-xs flex-gt-xs="100" layout="column">
			  			<md-card>
							<div layout-align="start" flex>
								<md-input-container flex="50">
									<?php
									echo '<md-select ng-model="LeadReportMonth" placeholder="Select a state" ng-change="LeadMonthChanged()">' . PHP_EOL;
									for ( $m = 1; $m <= 12; $m++ ) {
										$_selected = '';
										if ( $m == date( 'm' ) ) {
											$_selected = ' selected';
										}
										echo '<md-option ng-value="' . $m . '"' . $_selected . '>' . ( date( 'F', mktime( 0, 0, 0, $m, 1 ) ) ) . '</md-option>' . PHP_EOL;
									}
									echo '</md-select>' . PHP_EOL;
									?>
								</md-input-container>
							</div>
							<canvas class="lead_graph chart mtop20" id="lead_graph" height="300px" style="height: 300px"></canvas>
						</md-card>
					</div>
				</div>
				<div layout-xs="column" layout="row" class="">
					<div flex-xs flex-gt-xs="40" layout="column">
			  			<md-card>
			  				<div class="widget-chart-container">
								<div class="widget-counter-group widget-counter-group-right">
									<div style="width: auto" class="pull-left">
										<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
										<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
											<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('leads_by_source') ?></b></h4>
											<small><?php echo lang('billsbystatus') ?></small>
										</div>
									</div>
								</div>
								<div class="my-2">
									<div class="chart-wrapper">
										<canvas id="leads_by_leadsource"></canvas>
									</div>
								</div>
							</div>
						</md-card>
					</div>
					<div flex-xs flex-gt-xs="40" layout="column">
			  			<md-card>
			  				<div class="widget-chart-container">
								<div class="widget-counter-group widget-counter-group-right">
									<div style="width: auto" class="pull-left">
										<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
										<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
											<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('leads_win_source') ?></b></h4>
											<small><?php echo lang('billsbystatus') ?></small>
										</div>
									</div>
								</div>
								<div class="my-2">
									<div class="chart-wrapper">
										<canvas id="leads_to_win_by_leadsource"></canvas>
									</div>
								</div>
							</div>
						</md-card>
					</div>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('timesheet') ?>" ng-click="getTimesheet()" id="timesheetTab">
			<md-content class="md-padding">
				<md-content class="widget-fullwidth ciuis-body-loading">
					<div ng-show="timesheet.loader" layout-align="center center" class="text-center" id="circular_loader">
						<md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
						<p style="font-size: 15px;margin-bottom: 5%;">
							<span>
								<?php echo lang('please_wait') ?> <br>
								<small><strong><?php echo lang('loading'). ' '. lang('timesheet').'...' ?></strong></small>
							</span>
						</p>
					</div>
					<md-card flex-xs flex-gt-xs="100" layout="column" ng-show="!timesheet.loader">
						<md-content class="md-pt-0">
							<h3 class="md-padding"><?php echo lang('timesheet_data') ?></h3>
					        <ul class="custom-ciuis-list-body" style="padding: 0px;cursor: auto;">
					          <li ng-repeat="timesheet in timesheets | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
					            <ul class="list-item-for-custom-list">
					              <li class="ciuis-custom-list-item-item col-md-12">
					                <div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="Assigned: {{lead.assigned}}" class="assigned-staff-for-this-lead user-avatar"><a ng-href="<?php echo base_url('staff/staffmember/')?>{{timesheet.staff_id}}"> <img src="<?php echo base_url('uploads/images/{{timesheet.avatar}}')?>" alt="{{timesheet.staff}}"></a> </div>
					                <div class="pull-left col-md-4"><a ng-href="<?php echo base_url('staff/staffmember/')?>{{timesheet.staff_id}}"><strong ng-bind="timesheet.staff"></strong></a><br>
					                  <small ng-bind="timesheet.note"></small> </div>
					                <div class="col-md-8">
					                	<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('task') ?> <i class="ion-ios-stopwatch-outline"></i></small><br>
					                    <a ng-href="<?php echo base_url('tasks/task/')?>{{timesheet.relation_id}}"><strong ng-bind="timesheet.name"></strong></a></span></div>
					                  	<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('start_time') ?> <i class="ion-ios-stopwatch-outline"></i></small><br>
					                    <strong ng-bind="timesheet.start_time"></strong></span></div>
					                    <div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('end_time') ?> <i class="ion-ios-stopwatch-outline"></i></small><br>
					                    	<strong ng-bind="timesheet.end_time"></strong>
					                    	<span class="badge ng-binding" style="border-color: #fff;background-color: #26c281;" ng-if="!timesheet.end_time"><?php echo lang('in_progress') ?></span>
					                    	</span>
					                    </div>
					                    <div class="col-md-3">
					                    	<span class="date-start-task">
						                    	<small class="text-muted text-uppercase"><?php echo lang('timeCaptured') ?> 
						                    	<i class="ion-ios-stopwatch-outline"></i>
						                    </small>
						                    <br>
						                    <strong ng-bind="timesheet.total_time"></strong>
						                    </span>
					                	</div>
					                </div>
					              </li>
					            </ul>
					          </li>
					        </ul>
					        <div class="ciuis-custom-list-item-item col-md-12">
					        	<div class="pull-right col-md-2">
					        		<span class="text-muted"><?php echo lang('time_captured') ?>: </span>
					        		<md-tooltip md-direction="bottom" ng-bind='lang.time_format'></md-tooltip>
					        		 <strong ng-bind="total_time"></strong>
					        	</div>
					        </div>
					        <div ng-hide="timesheets.length < 5" class="pagination-div">
					          <ul class="pagination">
					            <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
					            <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
					            <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
					          </ul>
					        </div>
					        <md-content ng-show="!timesheets.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
					      </md-content>
					</md-card>
				</md-content>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('exportdata') ?>"> 
		  	<md-content class="md-padding bg-white">
			  	<div layout-gt-xs="row">
		  			<md-input-container class="md-block" flex-gt-xs>
			          <label><?php echo lang('report') ?></label>
			          <md-select ng-model="exportType" name="exportType" required>
			            <md-option value="invoices"><?php echo lang('invoices') ?></md-option>
			            <md-option value="expenses"><?php echo lang('expenses') ?></md-option>
			            <md-option value="customers"><?php echo lang('customers') ?></md-option>
			            <md-option value="proposals"><?php echo lang('proposals') ?></md-option>
			            <md-option value="deposits"><?php echo lang('depositstitle') ?></md-option>
			            <md-option value="orders"><?php echo lang('orders') ?></md-option>
			            <md-option value="vendors"><?php echo lang('vendors') ?></md-option>
			            <md-option value="purchases"><?php echo lang('purchases') ?></md-option>
			            <md-option value='contacts'><?php echo lang('customers').' '.lang('customercontacts');?></md-option>
			            <md-option value="tasks"><?php echo lang('tasks') ?></md-option>
			            <md-option value="tickets"><?php echo lang('tickets') ?></md-option>
			            <md-option value="leads"><?php echo lang('leads') ?></md-option>
			            <md-option value="products"><?php echo lang('products') ?></md-option>
			            <md-option value="projects"><?php echo lang('projects') ?></md-option>
			            <md-option value="staff"><?php echo lang('staff') ?></md-option>
			          </md-select>
			        </md-input-container>
		  			<md-input-container class="md-block" flex-gt-xs>
			         <label><?php echo lang('period') ?></label>
			          <md-select ng-model="period" name="period">
			            <md-option value="0" selected><?php echo lang('all') ?></md-option>
			            <md-option value="1"><?php echo lang('this_year') ?></md-option>
			            <md-option value="2"><?php echo lang('this').' '.lang('month') ?></md-option>
			            <md-option value="3"><?php echo lang('this').' '.lang('week') ?></md-option>
			            <md-option value="4"><?php echo lang('lastyear') ?></md-option>
			            <md-option value="5"><?php echo lang('lastmonth') ?></md-option>
			            <md-option value="6"><?php echo lang('last').' '.lang('week') ?></md-option>
			            <md-option value="7"><?php echo lang('custom') ?></md-option>
			          </md-select>
			        </md-input-container>
	  				<md-input-container ng-show="period == '7'" flex-gt-xs>
				          <label><?php echo lang('from') ?></label>
				          <md-datepicker name="from" ng-model="from" md-open-on-focus></md-datepicker>
				    </md-input-container>
	        		<md-input-container ng-show="period == '7'" flex-gt-xs>
			          <label><?php echo lang('to') ?></label>
			          <md-datepicker md-min-date="to" name="to" ng-model="to" md-open-on-focus></md-datepicker>
			        </md-input-container>
					<md-button ng-click="viewReport()" class="md-raised md-primary btn-report" aria-label='New'>
                        <span ng-hide="loadingReport == true"><?php echo lang('submit'); ?></span>
                        <md-progress-circular class="white" ng-show="loadingReport == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                        <md-tooltip ng-hide="loadingReport == true" md-direction="bottom"><?php echo lang('submit') ?></md-tooltip>
                    </md-button>
				</div>
		  	</md-content>
	  		<md-divider></md-divider>
			<md-toolbar class="toolbar-white" ng-show="invoiceReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('invoices'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="invoice_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('invoice')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('invoices',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('invoices',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
	  		<md-content ng-show="invoiceReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="invoices.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="invoice_list.order">
							<tr md-row>
								<th md-column><span><?php echo lang('invoice'); ?></span></th>
								<th md-column md-order-by="created"><span><?php echo lang('billeddate'); ?></span></th>
								<th md-column md-order-by="duedate"><span><?php echo lang('invoiceduedate'); ?></span></th>
								<th md-column md-order-by="staffname"><span><?php echo lang('addedby'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="invoice in invoices  | orderBy: invoice_list.order | limitTo: invoice_list.limit : (invoice_list.page -1) * invoice_list.limit | filter: invoice_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link" href="<?php echo base_url('invoices/invoice/{{invoice.id}}') ?>">
										<span ng-bind="invoice.longid"></span>
									</a><br>
									<a class="link" href="<?php echo base_url('customers/customer/{{invoice.customer_id}}') ?>">
										<small ng-bind="invoice.customer"></small>
									</a>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="invoice.created"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="invoice.duedate"></span>
								</td>
								<td md-cell>
									<span ng-bind="invoice.staffname"></span>
								</td>
								<td md-cell>
									<span class="text-uppercase text-{{invoice.color}}" ng-bind="invoice.status"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
							</tr>
							<tr md-row >
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell><?php echo lang('total');?></td>
								<td md-cell>
									<strong ng-bind-html="subtotal | currencyFormat:cur_code:null:true:cur_lct"></strong>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="invoices.length > 0" md-limit="invoice_list.limit" md-limit-options="inv_limitOptions" md-page="invoice_list.page" md-total="{{invoices.length}}" >
				</md-table-pagination>
				<md-content ng-show="!invoices.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="customersReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('customers'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="customer_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('customer')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('customers',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('customers',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="customersReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="customers.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="customer_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="group_name"><span><?php echo lang('group'); ?></span></th>
								<th md-column md-order-by="address"><span><?php echo lang('address'); ?></span></th>
								<th md-column md-order-by="balance"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="customer in customers  | orderBy: customer_list.order | limitTo: customer_list.limit : (customer_list.page -1) * customer_list.limit | filter: customer_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('customers/customer/{{customer.id}}') ?>">
										<span ng-bind="customer.customer_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="customer.name"></span><br>
          							<small ng-bind="customer.email"></small>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="customer.group_name"></span>
								</td>
								<td md-cell>
									<span class="date-start-task">
										<small class="text-muted text-uppercase" ng-bind="customer.address"></small><br>
										<i ng-show="customer.phone" class="ion-ios-telephone"></i>&nbsp;
										<span ng-bind="customer.phone"></span>
									</span>
								</td>
								<td md-cell>
									<span ng-show="customer.balance !== 0">
										<span ng-bind-html="customer.balance | currencyFormat:cur_code:null:true:cur_lct"></span>
									</span>
									<span ng-show="customer.balance === 0">
                    					<span class="text-success"><?php echo lang('nobalance') ?></span> 
                    				</span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="customers.length > 0" md-limit="customer_list.limit" md-limit-options="cust_limitOptions" md-page="customer_list.page" md-total="{{customers.length}}" >
				</md-table-pagination>
				<md-content ng-show="!customers.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="expensesReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('expenses'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="expense_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('expense')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('expenses',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('expenses',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="expensesReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="expenses.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="expense_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column><span><?php echo lang('title'); ?></span></th>
								<th md-column md-order-by="type"><span><?php echo lang('type'); ?></span></th>
								<th md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="billstatus"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="date"><span><?php echo lang('date'); ?></span></th>
								<th md-column md-order-by="amount"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="expense in expenses  | orderBy: expense_list.order | limitTo: expense_list.limit : (expense_list.page -1) * expense_list.limit | filter: expense_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('expenses/expense/{{expense.id}}') ?>">
										<span ng-bind="expense.longid"></span><br>
									</a>
									<small ng-bind="expense.category"></small>
								</td>
								<td md-cell>
									<span ng-bind="expense.title"></span>
								</td>
								<td md-cell>
									<span ng-bind="expense.type"></span>
								</td>
								<td md-cell>
									<span ng-bind="expense.customername"></span><br>
									<a class="link" ng-show="expense.internal == '1'"  href="<?php echo base_url('staff/staffmember/{{expense.staffid}}') ?>">
										<small ng-bind="expense.customer"></small>
									</a>
									<a class="link" ng-show="expense.internal != '1'"  href="<?php echo base_url('customers/customer/{{expense.customerid}}') ?>">
										<small ng-bind="expense.customer"></small>
									</a>
								</td>
								<td md-cell>
									<span class="text-uppercase text-{{expense.color}}" ng-bind="expense.billstatus"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="expense.date"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="expense.amount | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
							</tr>
							<tr md-row >
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell><?php echo lang('total');?></td>
								<td md-cell>
									<strong ng-bind-html="subtotal | currencyFormat:cur_code:null:true:cur_lct"></strong>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="expenses.length > 0" md-limit="expense_list.limit" md-limit-options="exp_limitOptions" md-page="expense_list.page" md-total="{{expenses.length}}" >
				</md-table-pagination>
				<md-content ng-show="!expenses.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="proposalsReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('proposals'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="proposal_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('proposal')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('proposals',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('proposals',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="proposalsReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="proposals.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="proposals_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="subject"><span><?php echo lang('subject'); ?></span></th>
								<th md-column md-order-by="date"><span><?php echo lang('date'); ?></span></th>
								<th md-column md-order-by="opentill"><span><?php echo lang('opentill'); ?></span></th>
								<th md-column md-order-by="assigned"><span><?php echo lang('assigned'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="proposal in proposals  | orderBy: proposals_list.order | limitTo: proposals_list.limit : (proposals_list.page -1) * proposals_list.limit | filter: proposal_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('proposals/proposal/{{proposal.id}}') ?>">
										<span ng-bind="proposal.longid"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="proposal.subject"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="proposal.date"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="proposal.opentill"></span>
								</td>
								<td md-cell>
										<span ng-bind="proposal.assigned"></span><br>
										<a class="link"  href="<?php echo base_url('staff/staffmember/{{proposal.staffid}}') ?>">
											<small ng-bind="proposal.staff_number"></small>
										</a>
								</td>
								<td md-cell>
									<span class="text-uppercase label {{proposal.class}} label-default" ng-bind="proposal.status"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
							</tr>
							<tr md-row >
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell><?php echo lang('total');?></td>
								<td md-cell>
									<strong ng-bind-html="subtotal | currencyFormat:cur_code:null:true:cur_lct"></strong>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="proposals.length > 0" md-limit="proposals_list.limit" md-limit-options="proposal_limitOptions" md-page="proposals_list.page" md-total="{{proposals.length}}" >
				</md-table-pagination>
				<md-content ng-show="!proposals.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="depositsReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('depositstitle'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="deposits_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('depositstitle')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('deposits',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('deposits',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="depositsReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="deposits.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="deposit_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="title"><span><?php echo lang('title'); ?></span></th>
								<th md-column md-order-by="category"><span><?php echo lang('category'); ?></span></th>
								<th md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="created"><span><?php echo lang('created'); ?></span></th>
								<th md-column md-order-by="date"><span><?php echo lang('deposit').' '.lang('date'); ?></span></th>
								<th md-column md-order-by="billstatus"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="amount"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="deposit in deposits  | orderBy: deposit_list.order | limitTo: deposit_list.limit : (deposit_list.page -1) * deposit_list.limit | filter: deposits_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('deposits/deposit/{{deposit.id}}') ?>">
										<span ng-bind="deposit.longid"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="deposit.title"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="deposit.category"></span>
								</td>
								<td md-cell>
									<span ng-bind="deposit.customername"></span><br>
									<a ng-show="deposit.status == '2'" class="link"  href="<?php echo base_url('staff/staffmember/{{deposit.staffid}}') ?>">
										<small ng-bind="deposit.customer"></small>
									</a>
									<a ng-show="deposit.status != '2'" class="link"  href="<?php echo base_url('customers/customer/{{deposit.customerid}}') ?>">
										<small ng-bind="deposit.customer"></small>
									</a>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="deposit.created"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="deposit.date"></span>
								</td>
								<td md-cell>
									<span class="text-uppercase text-{{deposit.color}}" ng-bind="deposit.billstatus"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="deposit.amount | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="deposits.length > 0" md-limit="deposit_list.limit" md-limit-options="dep_limitOptions" md-page="deposit_list.page" md-total="{{deposits.length}}" >
				</md-table-pagination>
				<md-content ng-show="!deposits.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="ordersReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('orders'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="orders_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('order')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('orders',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('orders',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="ordersReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="orders.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="order_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="subject"><span><?php echo lang('subject'); ?></span></th>
								<th md-column md-order-by="date"><span><?php echo lang('order').' '.lang('date'); ?></span></th>
								<th md-column md-order-by="opentill"><span><?php echo lang('opentill'); ?></span></th>
								<th md-column md-order-by="customer_number"><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="staff"><span><?php echo lang('assigned'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="order in orders  | orderBy: order_list.order | limitTo: order_list.limit : (order_list.page -1) * order_list.limit | filter: orders_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('orders/order/{{order.id}}') ?>">
										<span ng-bind="order.longid"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="order.subject"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="order.date"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="order.opentill"></span>
								</td>
								<td md-cell>
									<span ng-bind="order.customer"></span><br>
									<a class="link"  href="<?php echo base_url('customers/customer/{{order.customerid}}') ?>">
										<small ng-bind="order.customer_number"></small>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="order.assigned"></span><br>
									<a class="link"  href="<?php echo base_url('staff/staffmember/{{order.staffid}}') ?>">
										<small ng-bind="order.staff"></small>
									</a>
								</td>
								<td md-cell>
									<span class="text-uppercase label {{order.class}} label-default" ng-bind="order.status"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="order.total | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="orders.length > 0" md-limit="order_list.limit" md-limit-options="odr_limitOptions" md-page="order_list.page" md-total="{{orders.length}}" >
				</md-table-pagination>
				<md-content ng-show="!orders.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white" ng-show="vendorsReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('vendors'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="vendors_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('vendor')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('vendors',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('vendors',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="vendorsReport=='false'" class="bg-white"> 
				<md-table-container ng-show="vendors.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="vendor_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column><span><?php echo lang('vendors'); ?></span></th>
								<th md-column md-order-by="group_name"><span><?php echo lang('group'); ?></span></th>
								<th md-column md-order-by="address"><span><?php echo lang('address'); ?></span></th>
								<th md-column md-order-by="balance"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="vendor in vendors  | orderBy: vendor_list.order | limitTo: vendor_list.limit : (vendor_list.page -1) * vendor_list.limit | filter: vendors_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('vendors/vendor/{{vendor.id}}') ?>">
										<span ng-bind="vendor.vendor_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="vendor.name"></span><br>
          							<small ng-bind="vendor.email"></small>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="vendor.group_name"></span>
								</td>
								<td md-cell>
									<span class="date-start-task">
										<small class="text-muted text-uppercase" ng-bind="vendor.address"></small><br>
										<i ng-show="vendor.phone" class="ion-ios-telephone"></i>&nbsp;
										<span ng-bind="vendor.phone"></span>
									</span>
								</td>
								<td md-cell>
									<span ng-show="vendor.balance !== 0">
										<span ng-bind-html="vendor.balance | currencyFormat:cur_code:null:true:cur_lct"></span>
									</span>
									<span ng-show="vendor.balance === 0">
                    					<span class="text-success"><?php echo lang('nobalance') ?></span> 
                    				</span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="vendors.length > 0" md-limit="vendor_list.limit" md-limit-options="ven_limitOptions" md-page="vendor_list.page" md-total="{{vendors.length}}" >
				</md-table-pagination>
				<md-content ng-show="!vendors.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="purchaseReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('purchases'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="purchases_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('purchase')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('purchases',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('purchases',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="purchaseReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="purchases.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="purchase_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="vendor_number"><span><?php echo lang('vendor'); ?></span></th>
								<th md-column md-order-by="created"><span><?php echo lang('billeddate'); ?></span></th>
								<th md-column md-order-by="duedate"><span><?php echo lang('invoiceduedate'); ?></span></th>
								<th md-column md-order-by="staffname"><span><?php echo lang('addedby'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="purchase in purchases  | orderBy: purchase_list.order | limitTo: purchase_list.limit : (purchase_list.page -1) * purchase_list.limit | filter: purchases_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link" href="<?php echo base_url('purchases/purchase/{{purchase.id}}') ?>">
										<span ng-bind="purchase.longid"></span>
									</a><br>
									<small ng-bind="purchase.serie"></small>
								</td>
								<td md-cell>
									<span ng-bind="purchase.vendor"></span><br>
									<a class="link" href="<?php echo base_url('vendors/vendor/{{purchase.vendor_id}}') ?>">
										<small ng-bind="purchase.vendor_number"></small>
									</a>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="purchase.created"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="purchase.duedate"></span>
								</td>
								<td md-cell>
									<span ng-bind="purchase.staffname"></span>
								</td>
								<td md-cell>
									<span class="text-uppercase text-{{purchase.color}}" ng-bind="purchase.status">       </span>
								</td>
								<td md-cell>
									<span ng-bind-html="purchase.total | currencyFormat:cur_code:null:true:cur_lct">		
									</span>
								</td>
							</tr>
							<tr md-row >
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell></td>
								<td md-cell><?php echo lang('total');?></td>
								<td md-cell>
									<strong ng-bind-html="subtotal | currencyFormat:cur_code:null:true:cur_lct"></strong>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="purchases.length > 0" md-limit="purchase_list.limit" md-limit-options="po_limitOptions" md-page="purchase_list.page" md-total="{{purchases.length}}" >
				</md-table-pagination>
				<md-content ng-show="!purchases.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="contactsReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('contacts'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="contacts_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contact')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('contacts',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('contacts',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content ng-show="contactsReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="contacts.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="contact_list.order">
							<tr md-row>
								<th md-column md-order-by="name"><?php echo lang('name') ?></th>
								<th md-column md-order-by="email"><span><?php echo lang('email'); ?></span></th>
								<th md-column md-order-by="mobile"><span><?php echo lang('contactmobile').'/'.lang('phone'); ?></span></th>
								<th md-column md-order-by="customer_number"><span><?php echo lang('customer') ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="contact in contacts  | orderBy: contact_list.order | limitTo: contact_list.limit : (contact_list.page -1) * contact_list.limit | filter: contacts_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link" href="<?php echo base_url('customers/customer/{{contact.customerid}}') ?>">
										<span ng-bind="contact.name"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="contact.email"></span>
								</td>
								<td md-cell>
									<span ng-bind="contact.mobile"></span>
								</td>
								<td md-cell>
									<span ng-bind="contact.customer"></span><br>
									<a class="link" href="<?php echo base_url('customers/customer/{{contact.customerid}}') ?>">
										<small ng-bind="contact.customer_number"></small>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="contacts.length > 0" md-limit="contact_list.limit" md-limit-options="contact_limitOptions" md-page="contact_list.page" md-total="{{contacts.length}}" >
				</md-table-pagination>
				<md-content ng-show="!contacts.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white" ng-show="ticketsReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('tickets'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="ticket_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('ticket')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('tickets',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('tickets',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
	  		<md-content ng-show="ticketsReport == 'false'" class="bg-white"> 
				<md-table-container ng-show="tickets.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="ticket_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="subject"><span><?php echo lang('subject'); ?></span></th>
								<th md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="department"><span><?php echo lang('department'); ?></span></th>
								<th md-column md-order-by="priority"><span><?php echo lang('priority'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="assigned_staff_name"><span><?php echo lang('assigned'); ?></span></th>
								<th md-column md-order-by="last_reply_date"><span><?php echo lang('lastreply'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="ticket in tickets  | orderBy: ticket_list.order | limitTo: ticket_list.limit : (ticket_list.page -1) * ticket_list.limit | filter: ticket_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link" href="<?php echo base_url('tickets/ticket/{{ticket.id}}') ?>">
										<span ng-bind="ticket.ticket_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="ticket.subject"></span>
								</td>
								<td md-cell>
									<span ng-bind="ticket.customer"></span><br/>
									<small ng-bind="ticket.contactname"></small>
								</td>
								<td md-cell>
									<span ng-bind="ticket.department"></span>
								</td>
								<td md-cell>
									<span class="text-uppercase" ng-bind="ticket.priority"></span>
								</td>
								<td md-cell>
									<span class="text-uppercase" ng-bind="ticket.status"></span>
								</td>
								<td md-cell>
									<span ng-bind="ticket.assigned_staff_name"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="ticket.last_reply_date"></span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="tickets.length > 0" md-limit="ticket_list.limit" md-limit-options="tkt_limitOptions" md-page="ticket_list.page" md-total="{{tickets.length}}" >
				</md-table-pagination>
				<md-content ng-show="!tickets.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="taskReport == 'false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('tasks'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('tasks')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('tasks',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('tasks',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="taskReport=='false'" class="bg-white"> 
				<md-table-container ng-show="tasks.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="task_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column><span><?php echo lang('task'); ?></span></th>
								<th md-column md-order-by="project"><span><?php echo lang('project'); ?></span></th>
								<th md-column md-order-by="startdate"><span><?php echo lang('start'); ?></span></th>
								<th md-column md-order-by="duedate"><span><?php echo lang('duedate'); ?></span></th>
								<th md-column md-order-by="priority"><span><?php echo lang('priority'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="staffname"><span><?php echo lang('assigned'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="task in tasks  | orderBy: task_list.order | limitTo: task_list.limit : (task_list.page -1) * task_list.limit | filter: task_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('tasks/task/{{task.id}}') ?>">
										<span ng-bind="task.task_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="task.name"></span><br>
								</td>
								<td md-cell>
									<span ng-bind="task.projectname"></span><br>
									<a class="link"  href="<?php echo base_url('projects/project/{{task.projectid}}') ?>">
										<small ng-bind="task.project"></small>
									</a>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="task.startdate"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="task.duedate"></span>
								</td>
								<td md-cell>
									<span ng-bind="task.priority"></span><br>
								</td>
								<td md-cell>
									<span ng-bind="task.status"></span><br>
								</td>
								<td md-cell>
									<span ng-bind="task.staffname"></span><br>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="task_limitOptions" md-page="task_list.page" md-total="{{tasks.length}}" >
				</md-table-pagination>
				<md-content ng-show="!tasks.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="leadsReport=='false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('leads'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="lead_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('lead')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('leads',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('leads',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="leadsReport=='false'" class="bg-white"> 
				<md-table-container ng-show="leads.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="lead_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
								<th md-column md-order-by="phone"><span><?php echo lang('phone'); ?></span></th>
								<th md-column md-order-by="statusname"><span><?php echo lang('status'); ?></span></th>
								<th md-column md-order-by="sourcename"><span><?php echo lang('source'); ?></span></th>
								<th md-column md-order-by="assigned"><span><?php echo lang('assigned'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="lead in leads  | orderBy: lead_list.order | limitTo: lead_list.limit : (lead_list.page -1) * lead_list.limit | filter: customer_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('leads/lead/{{lead.id}}') ?>">
										<span ng-bind="lead.lead_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="lead.name"></span><br>
          							<small ng-bind="lead.company"></small>
								</td>
								<td md-cell>
									<i ng-show="lead.phone" class="ion-ios-telephone">
									<span ng-bind="lead.phone"></span>
								</td>
								<td md-cell>
									<span class="badge" style="border-color: #fff;background-color: {{lead.color}};" ng-bind="lead.statusname"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="lead.sourcename"></span>
								</td>
								<td md-cell>
									<span  ng-bind="lead.assigned"></span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="leads.length > 0" md-limit="lead_list.limit" md-limit-options="lead_limitOptions" md-page="lead_list.page" md-total="{{leads.length}}" >
				</md-table-pagination>
				<md-content ng-show="!leads.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="productsReport=='false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('products'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="product_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('product')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('products',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('products',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="productsReport=='false'" class="bg-white"> 
				<md-table-container ng-show="products.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="product_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="code"><span><?php echo lang('productcode'); ?></span></th>
								<th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
								<th md-column md-order-by="category"><span><?php echo lang('category'); ?></span></th>
								<th md-column md-order-by="purchase_price"><span><?php echo lang('purchaseprice'); ?></span></th>
								<th md-column md-order-by="sales_price"><span><?php echo lang('salesprice'); ?></span></th>
								<th md-column md-order-by="tax"><span><?php echo $appconfig['tax_label']; ?></span></th>
								<th md-column md-order-by="stock"><span><?php echo lang('instock'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="product in products  | orderBy: product_list.order | limitTo: product_list.limit : (product_list.page -1) * product_list.limit | filter: product_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('products/product/{{product.product_id}}') ?>">
										<span ng-bind="product.product_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="product.code"></span>
								</td>
								<td md-cell>
									<span ng-bind="product.name"></span><br/>
									<small ng-bind="product.description| limitTo:35"></small>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="product.category_name"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="product.purchase_price | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="product.sales_price | currencyFormat:cur_code:null:true:cur_lct">	</span>
								</td>
								<td md-cell>
									<span ng-bind="product.tax+'%'"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="product.stock"></span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="products.length > 0" md-limit="product_list.limit" md-limit-options="product_limitOptions" md-page="product_list.page" md-total="{{products.length}}" >
				</md-table-pagination>
				<md-content ng-show="!products.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="staffReport=='false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('staff'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="staff_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('staff')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('staff',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('staff',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="staffReport=='false'" class="bg-white"> 
				<md-table-container ng-show="staff.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="staff_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
								<th md-column md-order-by="department"><span><?php echo lang('department'); ?></span></th>
								<th md-column md-order-by="type"><span><?php echo lang('type'); ?></span></th>
								<th md-column md-order-by="address"><span><?php echo lang('address'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="member in staff  | orderBy: staff_list.order | limitTo: staff_list.limit : (staff_list.page -1) * staff_list.limit | filter: staff_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('staff/staffmember/{{member.id}}') ?>">
										<span ng-bind="member.staff_number"></span>
									</a>
								</td>
								<td md-cell>
									<span ng-bind="member.name"></span><br>
									<small ng-bind="member.email"></small>
								</td>
								<td md-cell>
									<span  ng-bind="member.department"></span>
								</td>
								<td md-cell>
									<span ng-bind="member.type"></span>
								</td>
								<td md-cell>
									<span ng-bind="member.address"></span><br/>
									<i ng-show="member.phone" class="ion-ios-telephone">
									<small ng-bind="member.phone"></small>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="staff.length > 0" md-limit="staff_list.limit" md-limit-options="staff_limitOptions" md-page="staff_list.page" md-total="{{staff.length}}" >
				</md-table-pagination>
				<md-content ng-show="!staff.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
			<md-toolbar class="toolbar-white"  ng-show="projectsReport=='false'">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('projects'); ?></h2>
					<div class="ciuis-external-search-in-table">
						<input ng-model="project_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('project')?>"> 
						<md-button class="md-icon-button" aria-label="Search">
							<md-icon><i class="ion-search text-muted"></i></md-icon>
						</md-button>
					</div>
					<md-button ng-click="generatePdf('projects',period)" aria-label="New"  class="md-icon-button">
		        		<img class="download-export-image" ng-hide="pdfLoader == true" src="<?php echo base_url('assets/img/pdf.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('pdf').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="pdfLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
		        	<md-button ng-click="exportData('projects',period)" class="md-icon-button"  aria-label="New">
		        		<img class="download-export-image" ng-hide="csvLoader == true" src="<?php echo base_url('assets/img/csv.png');?>">
		        		<md-tooltip md-direction="bottom"><?php echo lang('csv').' '.lang('export') ?></md-tooltip>
		        		<md-progress-circular ng-show="csvLoader == true" md-mode="indeterminate"
                       	md-diameter= '20'></md-progress-circular>
				    </md-button>
				</div>
			</md-toolbar>
			<md-content  ng-show="projectsReport=='false'" class="bg-white"> 
				<md-table-container ng-show="projects.length > 0">
					<table md-table  md-progress="promise">
						<thead md-head md-order="project_list.order">
							<tr md-row>
								<th md-column>#</th>
								<th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
								<th md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
								<th md-column md-order-by="startdate"><span><?php echo lang('project_start_date'); ?></span></th>
								<th md-column md-order-by="enddate"><span><?php echo lang('project_end_date') ?></span></th>
								<th md-column md-order-by="value"><span><?php echo lang('project_value'); ?></span></th>
								<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
								<th md-column><span><?php echo lang('project').' '.lang('members'); ?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="project in projects  | orderBy: project_list.order | limitTo: project_list.limit : (project_list.page -1) * project_list.limit | filter: project_search | filter: FilteredData" class="cursor">
								<td md-cell>
									<a class="link"  href="<?php echo base_url('projects/project/{{projects.id}}') ?>">
										<span ng-bind="project.project_number"></span>
									</a>
								</td>
								<td md-cell>
									<span  ng-bind="project.name"></span>
								</td>
								<td md-cell>
									<span  ng-bind="project.customer"></span><br>
									<a ng-show="project.template != '1'" class="link"  href="<?php echo base_url('customers/customer/{{project.customerid}}') ?>">
										<small ng-show="project.customer_number" ng-bind="project.customer_number"></small>
									</a>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="project.startdate"></span>
								</td>
								<td md-cell>
									<span class="badge" ng-bind="project.enddate"></span>
								</td>
								<td md-cell>
									<span ng-bind-html="project.value | currencyFormat:cur_code:null:true:cur_lct"></span>
								</td>
								<td md-cell>
									<span ng-bind="project.status"></span>
								</td>
								<td md-cell>
									<span ng-repeat="member in project.members">
										<a class="link badge" href="<?php echo base_url('staff/staffmember/{{member.staff_id}}') ?>">
											<span ng-bind="member.staffname"></span>
										</a>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="projects.length > 0" md-limit="project_list.limit" md-limit-options="pro_limitOptions" md-page="project_list.page" md-total="{{projects.length}}" >
				</md-table-pagination>
				<md-content ng-show="!projects.length" class="md-padding no-item-data"><?php echo lang('notdata') ?>
				</md-content>	
			</md-content>
		  </md-tab>
		</md-tabs>
	  </md-content>		
	</md-content>
</div>
<script type="text/javascript">
	var lang = {};
	lang.payments = '<?php echo lang('payments') ?>';
	lang.expenses = '<?php echo lang('expenses') ?>';
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' );?>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/reports.js') ?>"></script>