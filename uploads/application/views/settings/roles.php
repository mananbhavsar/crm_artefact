<style type="text/css">
.hide {display: none;}
.width25 {width: 25%;}
.width15 {width:15%;}
.mrgn_lft30 {margin-left:30px}
.mrgn_lft60 {margin-left:60px;}
</style>
<?php if (check_privilege('settings', 'edit')) { ?> 
	<md-content ng-show="viewRole == true" class="md-padding bg-white">
		<md-button ng-click="addRole()" class="md-raised md-primary pull-right successButton" ng-disabled="getRoles == true">
			<span ng-hide="getRoles == true"><?php echo lang('create').' '.lang('role');?></span>
			<md-progress-circular class="white" ng-show="getRoles == true" md-mode="indeterminate" md-diameter="20">
			</md-progress-circular>
		</md-button>
	</md-content>
<?php } ?>
<md-content ng-show="viewRole == true" class="md-padding bg-white"> 
	<md-table-container>
		<table md-table md-progress="promise">
			<thead md-head>
				<tr md-row>
					<th md-column><?php echo lang('role').' '.lang('name'); ?></th>
					<th md-column><?php echo lang('role').' '.lang('type'); ?></th>
					<th md-column><?php echo lang('updated_at'); ?></th>
					<th md-column><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody md-body>
				<tr class="select_row" md-row ng-repeat="role in roles">
					<td md-cell>
						<span ng-bind="role.role_name"></span>
					</td>
					<td md-cell>
						<span ng-bind="role.role_type"></span>
					</td>
					<td md-cell>
						<span ng-bind="role.updated_at"></span>
					</td>
					<td md-cell>
						<?php if (check_privilege('settings', 'edit')) { ?> 
							<span ng-click="get_role(role.role_id)">
								<md-progress-circular ng-show="editLoader == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
								<md-icon  ng-hide="editLoader == true" md-menu-align-target class="md-raised md-primary mdi mdi-edit" style="margin: auto 3px auto 0;">
								</md-icon>
							</span>
						<?php } if (check_privilege('settings', 'delete')) { ?> 
							<span ng-click="delete_role(role.role_id)"> 
								<md-icon md-menu-align-target class="md-raised md-primary ion-trash-b" style="margin: auto 3px auto 0;">
								</md-icon>
							</span>
						<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>
	</md-table-container>
</md-content>
<br/>
<md-content ng-show="createRole == true" class="bg-white">
	<md-button ng-click="create_role()" class="md-raised md-primary btn-report pull-right" ng-disabled="creatingRole == true">
		<span ng-hide="creatingRole == true"><?php echo lang('create');?></span>
		<md-progress-circular class="white" ng-show="creatingRole == true" md-mode="indeterminate" md-diameter="20">
		</md-progress-circular>
	</md-button>
	<md-button ng-click="cancel_role()" class="md-raised md-primary btn-report pull-right">
		<?php echo lang('cancel');?>
	</md-button>
</md-content>
<md-content ng-show="createRole == true" class="bg-white"> 
	<div layout-gt-xs="row" layout-padding>
		<md-input-container class="md-block" flex-gt-xs> 
			<label><?php echo lang('role').' '.lang('name');?></label>
			<input required ng-model="newrole.new_role_name">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('role').' '.lang('type') ?></label>
			<md-select ng-model="newrole.usertype" ng-change="get_permissions_by_type(newrole.usertype)" name="usertype">
				<md-option value="admin" selected><?php echo lang('admin') ?></md-option>
				<md-option value="staff"><?php echo lang('staff') ?></md-option>
				<md-option value="other"><?php echo lang('other') ?></md-option>
			</md-select>
		</md-input-container>
	</div>
	<md-table-container>
		<table md-table md-progress="promise">
			<thead md-head>
				<tr md-row>
					<th md-column>
						<?php echo lang('staffdetailsdescription'); ?> ( 
						<md-checkbox ng-change="get_permissions_by_type(newrole.usertype)" md-no-ink aria-label="view_own" ng-model="permission_all" class="md-primary">
						</md-checkbox> <?php echo lang('select').' '.lang('all')?>)
					</th>
					<th md-column><?php echo lang('view').' '.lang('own'); ?></th>
					<th md-column><?php echo lang('view').' '.lang('all'); ?></th>
					<th md-column><?php echo lang('create'); ?></th>
					<th md-column><?php echo lang('edit'); ?></th>
					<th md-column><?php echo lang('delete'); ?></th>
				</tr>
			</thead>
			<tbody md-body>
				<tr ng-show="permission.key != 'quotes'" class="select_row" md-row ng-repeat-start='permission in all_permissions'>
				   <td md-cell class="width25">
				        <button class="btn btn-primary btn-xs" ng-show="permission.viewChilds == 1" ng-click="viewChilds= !viewChilds"><i class="fa fa-caret-down"></i></button>
						<span ng-bind="permission.permission_key"></span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-show="permission.key != 'staff' && permission.key != 'accounts' && permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'settings'" md-no-ink aria-label="view_own" ng-model="permission.permission_view_own" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">  
							<md-checkbox md-no-ink aria-label="view_all" ng-model="permission.permission_view_all" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'staff'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="permission.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && newrole.usertype != 'other' && permission.key != 'staff'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'"ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other'"md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'staff'"md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
				</tr>
				<tr class="select_row" ng-show="permission.viewChilds == 1" md-row ng-class="viewChilds == 1? '' : 'hide'">
					 <td colspan='6' ng-class="viewChilds == 1? '' : 'hide'">
						<table md-table>
							<tbody md-body>
								<tr class="select_row" md-row ng-repeat-start='chilItem in permission.child'>
									<td md-cell class="width25">
										<button class="btn btn-primary btn-xs mrgn_lft30" ng-show="chilItem.viewChilds == 1" ng-click="viewSubChilds= !viewSubChilds"><i class="fa fa-caret-down"></i></button>
										<span ng-class="{'mrgn_lft30': chilItem.viewChilds == 0 }">{{chilItem.permission_key}}</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-show="chilItem.key != 'accounts' && chilItem.key != 'report' && chilItem.key != 'emails' && chilItem.key != 'settings' && newrole.usertype != 'other'" md-no-ink aria-label="view_own" ng-model="chilItem.permission_view_own" class="md-primary">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>  
											<md-checkbox md-no-ink aria-label="view_all" ng-model="chilItem.permission_view_all" class="md-primary">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
								</tr>
								<tr class="select_row" ng-show="chilItem.viewChilds == 1" md-row ng-class="viewSubChilds == 1? '' : 'hide'">
									<td colspan='6' ng-class="viewSubChilds == 1? '' : 'hide'">
										<table md-table>
											<tbody md-body>
											<tr class="select_row" md-row ng-repeat='chilSubItem in chilItem.child'>
												<td md-cell class="width25">
													<span class="mrgn_lft60" ng-bind="chilSubItem.permission_key"></span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-show="chilSubItem.key != 'staff' && chilSubItem.key != 'accounts' && chilSubItem.key != 'report' && chilSubItem.key != 'emails' && chilSubItem.key != 'settings' && newrole.usertype != 'other'" md-no-ink aria-label="view_own" ng-model="chilSubItem.permission_view_own" class="md-primary">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
														<span>  
															<md-checkbox md-no-ink aria-label="view_all" ng-model="chilSubItem.permission_view_all" class="md-primary">
															</md-checkbox>
														</span>
													</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<tr ng-repeat-end ></tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr ng-repeat-end ></tr>
			</tbody>
		</table>
	</md-table-container>
	<br><br><br>
</md-content>  
<md-content ng-show="editRole == true" class="bg-white">
	<md-button ng-click="update_role(role_id)" class="md-raised md-primary btn-report pull-right" ng-disabled="updatingRole == true">
		<span ng-hide="updatingRole == true"><?php echo lang('update');?></span>
		<md-progress-circular class="white" ng-show="updatingRole == true" md-mode="indeterminate" md-diameter="20">
		</md-progress-circular>
	</md-button>
	<md-button ng-click="cancel_role()" class="md-raised md-primary btn-report pull-right">
		<?php echo lang('cancel');?>
	</md-button>
</md-content>
<md-content ng-show="editRole == true" class="bg-white"> 
	<div layout-gt-xs="row">
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('role').' '.lang('name');?></label>
			<input required ng-model="role_name">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('role').' '.lang('type') ?></label>
			<md-select ng-model="role_type" name="role_type" disabled>
				<md-option value="admin"><?php echo lang('admin') ?></md-option>
				<md-option value="staff"><?php echo lang('staff') ?></md-option>
				<md-option value="other"><?php echo lang('other') ?></md-option>
			</md-select>
		</md-input-container>
	</div>
	<md-table-container>
		<table md-table  md-progress="promise">
			<thead md-head>
				<tr md-row>
					<th md-column><?php echo lang('staffdetailsdescription'); ?></th>
					<th md-column><?php echo lang('view').' '.lang('own'); ?></th>
					<th md-column><?php echo lang('view').' '.lang('all'); ?></th>
					<th md-column><?php echo lang('create'); ?></th>
					<th md-column><?php echo lang('edit'); ?></th>
					<th md-column><?php echo lang('delete'); ?></th>
				</tr>
			</thead>
			<tbody md-body>
				<tr class="select_row" md-row ng-repeat-start='permission in permissions'>
				   <td md-cell class="width25">
				        <button class="btn btn-primary btn-xs" ng-show="permission.viewChilds == 1" ng-click="viewChilds= !viewChilds"><i class="fa fa-caret-down"></i></button>
						<span ng-bind="permission.permission_key"></span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-show="permission.key != 'staff' && permission.key != 'accounts' && permission.key != 'report' && permission.key != 'emails' && permission.key != 'settings' && role_type != 'other'" md-no-ink aria-label="view_own" ng-model="permission.permission_view_own" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">  
							<md-checkbox md-no-ink aria-label="view_all" ng-model="permission.permission_view_all" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="permission.key != 'report' && permission.key != 'emails' && role_type != 'other'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="role_type == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && role_type != 'other' && permission.key != 'staff'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="permission.key != 'report' && role_type != 'other'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="role_type == 'staff'" ng-show="permission.key != 'report' && role_type != 'other' && permission.key != 'staff'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="permission.key != 'report' && permission.key != 'emails' && role_type != 'other'" md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="role_type == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && role_type != 'other' && permission.key != 'staff'" md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
				</tr>
				<tr class="select_row" ng-show="permission.viewChilds == 1" md-row ng-class="viewChilds == 1? '' : 'hide'">
					 <td colspan='6' ng-class="viewChilds == 1? '' : 'hide'">
						<table md-table>
							<tbody md-body>
								<tr class="select_row" md-row ng-repeat-start='chilItem in permission.child'>
									<td md-cell class="width25">
										<button class="btn btn-primary btn-xs mrgn_lft30" ng-show="chilItem.viewChilds == 1" ng-click="viewSubChilds= !viewSubChilds"><i class="fa fa-caret-down"></i></button>
										<span ng-class="{'mrgn_lft30': chilItem.viewChilds == 0 }">{{chilItem.permission_key}}</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-show="chilItem.key != 'accounts' && chilItem.key != 'report' && chilItem.key != 'emails' && chilItem.key != 'settings' && role_type != 'other'" md-no-ink aria-label="view_own" ng-model="chilItem.permission_view_own" class="md-primary">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>  
											<md-checkbox md-no-ink aria-label="view_all" ng-model="chilItem.permission_view_all" class="md-primary">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="role_type == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilItem.key != 'report' && role_type != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="role_type == 'staff'" ng-show="chilItem.key != 'report' && role_type != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="role_type == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
								</tr>
								<tr class="select_row" ng-show="chilItem.viewChilds == 1" md-row ng-class="viewSubChilds == 1? '' : 'hide'">
									<td colspan='6' ng-class="viewSubChilds == 1? '' : 'hide'">
										<table md-table>
											<tbody md-body>
											<tr class="select_row" md-row ng-repeat='chilSubItem in chilItem.child'>
												<td md-cell class="width25">
													<span class="mrgn_lft60" ng-bind="chilSubItem.permission_key"></span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-show="chilSubItem.key != 'staff' && chilSubItem.key != 'accounts' && chilSubItem.key != 'report' && chilSubItem.key != 'emails' && chilSubItem.key != 'settings' && role_type != 'other'" md-no-ink aria-label="view_own" ng-model="chilSubItem.permission_view_own" class="md-primary">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
														<span>  
															<md-checkbox md-no-ink aria-label="view_all" ng-model="chilSubItem.permission_view_all" class="md-primary">
															</md-checkbox>
														</span>
													</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="role_type == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && role_type != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilSubItem.key != 'report' && role_type != 'other'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="role_type == 'staff'" ng-show="chilSubItem.key != 'report' && role_type != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="role_type == 'admin' || role_type == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && role_type != 'other'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="role_type == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && role_type != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<tr ng-repeat-end ></tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr ng-repeat-end ></tr>
			</tbody>
		</table>
	</md-table-container>
	<br><br><br>
</md-content>  