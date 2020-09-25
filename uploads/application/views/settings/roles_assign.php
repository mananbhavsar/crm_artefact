 <md-content class="bg-white" style="padding:0px">
 	<md-toolbar class="toolbar-white">
 		<div class="md-toolbar-tools">
 			<h2 flex md-truncate class="pull-left" ><strong><?php echo lang('User Group') ?></strong></h2>
 			<?php if (check_privilege('settings', 'create')) { ?> 
 				<md-button ng-click="CreateRoleAssign()" class="md-icon-button md-primary" aria-label="New">
 					<md-tooltip md-direction="top"><?php echo lang('new_roles_assign') ?></md-tooltip>
 					<md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
 				</md-button>
 			<?php } ?>
 		</div>
 	</md-toolbar>
 	<md-content ng-show="!rolesassignLoader" class="bg-white" ng-cloak> 
 		<md-table-container ng-show="rolesassign_lists.length > 0">
 			<table md-table  md-progress="promise">
 				<thead md-head md-order="rolesassign_lists.staffname">
 					<tr md-row>'
 						<th md-column md-order-by="staffname"><span><?php echo lang('staffname'); ?></span></th>
 						<th md-column md-order-by="role_name"><span><?php echo lang('Role'); ?></span></th>
 						<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
 						<th md-column><span><?php echo lang('actions'); ?></span></th>
 					</tr>
 				</thead>
 				<tbody md-body>
 					<tr class="select_row" md-row ng-repeat="field in rolesassign_lists | orderBy: rolesassignitem_lists.order | limitTo: rolesassignitem_lists.limit : (rolesassignitem_lists.page -1) * rolesassignitem_lists.limit"  class="cursor">
 						<td md-cell>
 							<strong>
 								<span ng-bind="field.staffname"></span>
 							</strong>
 						</td>
						<td md-cell>
 							<strong><span class="text-uppercase" ng-bind="field.role_name"></span></strong>
 						</td>
						<!--<td md-cell>
 							<strong><span class="text-uppercase" ng-bind="field.statusname"></span></strong>
 						</td>-->
						<td md-cell>
 							<md-switch style="margin:unset!important" ng-change="UpdateAssignStatus(field.staffId,field.login_access,field.admin)" ng-model="field.login_access"><label><?php echo lang('active');?></label></md-switch>
 						</td>
 						<td md-cell>
 							<?php if (check_privilege('settings', 'edit')) { ?> 
 								<md-button class="md-icon-button" aria-label="Edit" ng-click="GetstaffDetail(field.staffId);" ng-cloak>
 									<md-tooltip md-direction="bottom"><?php echo lang('edit_field') ?></md-tooltip>
 									<md-icon><i class="ion-compose text-muted"></i></md-icon>
 								</md-button>
 							<?php } ?>
							<?php if (check_privilege('settings', 'delete')) { ?> 
 								<span ng-click="delete_NonStaff(field.staffId)" ng-show="field.is_staff !=1"> 
									<md-icon md-menu-align-target class="md-raised md-primary ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
								</span>
 							<?php } ?>
 						</td>
 					</tr>
 				</tbody>
 			</table>
 		</md-table-container>
 		<md-table-pagination ng-show="rolesassign_lists.length > 0" md-limit="rolesassignitem_lists.limit" md-limit-options="limitOptions" md-page="rolesassignitem_lists.page" md-total="{{rolesassign_lists.length}}" ></md-table-pagination>
 		<md-content ng-show="!rolesassign_lists.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
 	</md-content>
 </md-content>