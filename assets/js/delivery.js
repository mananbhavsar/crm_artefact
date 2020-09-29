function Delivery_Controller($scope, $http, $mdSidenav, $mdDialog, $filter, $q) {
	"use strict";

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'project').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});


	$scope.get_customers();
	$scope.get_staff();


	$scope.Create = buildToggler('Create');
	$scope.toggleFilter = buildToggler('ContentFilter');
	$scope.ProjectSettings = buildToggler('ProjectSettings');

	$scope.CreateGroup = buildToggler('CreateGroup');


	$http.get(BASE_URL + 'delivery/get_all_installation').then(function (Projects) {
		$scope.stages = Projects.data;
	});

	$scope.projectLoader = true;
	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}
	$scope.close = function () {
		$mdSidenav('Create').close();
		$mdDialog.hide();
	};
	



	$scope.updateColumns = function(column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/projects';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
			}, function(error) {}
			);
	};

	$scope.showGrid = true;
	$http.get(BASE_URL + 'api/table_columns/' + 'delivery').then(function (Data) {
		$scope.table_columns = Data.data;
		if ($scope.table_columns.list_view == true) {
			$scope.showList = true;
			$scope.showGrid = false;
		} else {
			$scope.showList = false;
			$scope.showGrid = true;
		}
	});

	$scope.projects_list = {
		order: '',
		limit: 10,
		page: 1
	};
	var deferred = $q.defer();


	$http.get(BASE_URL + 'projects/get_projects').then(function (Projects) {
		$scope.projectname = Projects.data;
	});
	$http.get(BASE_URL + 'delivery/get_delivery').then(function (Projects) {
		console.log(Projects)
		$scope.projects = Projects.data;
		$scope.projectLoader = false;
		var searchCustomer = $scope.projects.name?cust.split(' ')[0]:'';
		$scope.search_customers(searchCustomer);

		deferred.resolve();
		$scope.limitOptions = [5, 10, 15, 20];
		if($scope.projects.length > 20 ) {
			$scope.limitOptions = [5, 10, 15, 20, $scope.projects.length];
		}

		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			//alert(propName);
			return ($scope.projects || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;
		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		$scope.updateDropdown = function (_prop) { 
			var _opt = this.filter_select,
				_optList = this.getOptionsFor(_prop),
				len = _optList.length;
				console.log(_optList);

			if (_opt == 'all') {
				for (var j = 0; j < len; j++) {
					$scope.filter[_prop][_optList[j]] = true;
				}
			} else {
				for (var j = 0; j < len; j++) {
					console.log($scope.filter[_prop], $scope.filter[_prop][_optList[j]])
					$scope.filter[_prop][_optList[j]] = false;
				}
				$scope.filter[_prop][_opt] = true;
			}
		};
	});

	$http.get(BASE_URL + 'delivery/get_all_installation').then(function (Projects){
		$scope.stages = Projects.data;
		$scope.NewInstallation = function () {
			globals.createDialog($scope.lang.new+' ' + $scope.lang.project+' ' + $scope.lang.stage, $scope.lang.type_stage_name, $scope.lang.stage +' '+ $scope.lang.name, '', $scope.lang.add, $scope.lang.cancel, 'delivery/add_installation/',  function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
				} else {
					globals.mdToast('error', response.message);
				}
				$http.get(BASE_URL + 'delivery/get_all_installation').then(function (Stages) {
					$scope.stages = Stages.data;
				});
			});
		};

		$scope.EditProjectStage = function (id, name, event) {
			globals.editDialog($scope.lang.edit+' ' + $scope.lang.stage+' ' + $scope.lang.name, $scope.lang.type_stage_name,  $scope.lang.stage +' '+ $scope.lang.name, name, event, $scope.lang.save, $scope.lang.cancel, 'delivery/update_installation/' + id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'delivery/get_all_installation').then(function (StageData) {
						$scope.stages = StageData.data;
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		$scope.DeleteProjectStage = function (index) {
			var name = $scope.stages[index];
			globals.deleteDialog(lang.attention, $scope.lang.delete_meesage+' '+$scope.lang.stage, name.id, lang.doIt, lang.cancel, 'delivery/remove_installation/' + name.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'delivery/get_all_installation').then(function (StageData) {
						$scope.stages = StageData.data;
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};
	});


	$scope.saving = false;
	$scope.CreateNew = function () { 
		$scope.saving = true;
		$scope.tempArr = [];
		angular.forEach($scope.custom_fields, function (value) {
			if (value.type === 'input') {
				$scope.field_data = value.data;
			}
			if (value.type === 'textarea') {
				$scope.field_data = value.data;
			}
			if (value.type === 'date') {
				$scope.field_data = moment(value.data).format("YYYY-MM-DD");
			}
			if (value.type === 'select') {
				$scope.field_data = JSON.stringify(value.selected_opt);
			}
		
			$scope.tempArr.push({
				id: value.id,
				name: value.name,
				type: value.type,
				order: value.order,
				data: $scope.field_data,
				relation: value.relation,
				permission: value.permission,
			});
		});
	
			if ($scope.delivery.delivery_date) {
				$scope.delivery.delivery_date = moment($scope.delivery.delivery_date).format("YYYY-MM-DD")
			}
			
			var dataObj = $.param({
				projectname: $scope.delivery.projectname,
				installation: $scope.delivery.installation,
				delivery_date: $scope.delivery.delivery_date,
				description: $scope.delivery.description,
				custom_fields: $scope.tempArr,
			});
		

		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'delivery/create';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if (response.data.success == true) {
						globals.mdToast('success', response.data.message);
						$scope.delivery.projectname= '';
						$scope.delivery.installation = '';
						$scope.delivery.delivery_date = '';
						$scope.delivery.description = '';
					
						$mdSidenav('Create').close();
						$http.get(BASE_URL + 'delivery/get_delivery').then(function (Projects) {
							$scope.projects = Projects.data;
						});
						$scope.get_project_stat();
					} else {
						globals.mdToast('error', response.data.message);
					}
					$scope.saving = false;
				},
				function (response) {
					console.log(response);
					showToast(NTFTITLE, 'Error occured!', ' danger');
					$scope.saving = false;
					$http.get(BASE_URL + 'delivery/get_delivery').then(function (Projects) {
						$scope.projects = Projects.data;
					});
				}
			);
	};

}
	//edit delivery

	function DeliveryCust_Controller($scope, $http, $mdSidenav, $q, $timeout, $mdDialog, $filter, $sce, fileUpload) {
		"use strict";
		
		$scope.viewChilds = 1;
		
		$scope.sectionToShow = function(id) {
			$('#item_'+id).toggle();
		}
		$scope.NewMilestone = buildToggler('NewMilestone');
		$scope.NewTask = buildToggler('NewTask');
		$scope.NewExpense = buildToggler('NewExpense');
		$scope.NewService = buildToggler('NewService');
		$scope.Update = buildToggler('Update');
		$scope.NewTicket = buildToggler('NewTicket');
	
		function buildToggler(navID) {
			return function () {
				$mdSidenav(navID).toggle();
			};
		}
	
		$scope.get_customers();
		$scope.get_staff();
		globals.get_departments();
	
		$scope.close = function () {
			$mdSidenav('NewMilestone').close();
			$mdSidenav('NewTask').close();
			$mdSidenav('NewExpense').close();
			$mdSidenav('NewService').close();
			$mdSidenav('Update').close();
			$mdSidenav('UpdateService').close();
			$mdSidenav('NewTicket').close();
			$mdDialog.hide();
			$scope.invoiceButton = false;
		};
	
		$scope.UploadFile = function (ev) {
			$mdDialog.show({
				templateUrl: 'addfile-template.html',
				scope: $scope,
				preserveScope: true,
				targetEvent: ev
			});
		};
		$scope.project;
	$http.get(BASE_URL + 'delivery/get_deliverys/' + PROJECTID).then(function (Project) {
		$scope.project = Project.data;
		var cust = $scope.project.customer;
	});


	


		/*project stage*/
$scope.title = 'Stages';
$http.get(BASE_URL + 'delivery/subdelivery/' + PROJECTID).then(function (Subprojects) {
	$scope.subprojects = Subprojects.data;
	$scope.createProject = function () {
		var dataObj = $.param({
			description: $scope.newTitle,
			taskid: PROJECTID,
		});
		var posturl = BASE_URL + 'projects/addsubproject';
		
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				if(response.data.success == true) {
					$scope.subprojects.unshift({
						description: $scope.newTitle,
						date: Date.now()
					});
					$scope.newTitle = '';
					console.log(response);
				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
	};

	$scope.removeProject = function (index) {
		var subproject = $scope.subprojects[index];
		var dataObj = $.param({
			subproject: subproject.id
		});
		$http.post(BASE_URL + 'projects/removesubprojects', dataObj, config)
		.then(
			function (response) {
				if(response.data.success == true){
					$scope.subprojects.splice($scope.subprojects.indexOf(subproject), 1);
				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
	};

	$scope.completeProject = function (index) {
		var subproject = $scope.subprojects[index];
		var dataObj = $.param({
			subdelivery: subproject.id,
			deliveryid: PROJECTID
		});
		$http.post(BASE_URL + 'delivery/completesubdelivery', dataObj, config)
		.then(
			function (response) {
				if(response.data.success == true){
					subproject.complete = true;
					$scope.subprojects.splice($scope.subprojects.indexOf(subproject), 1);
					$scope.SubProjectsComplete.unshift(subproject);
					
					$http.get(BASE_URL + 'delivery/get_deliverys/'+PROJECTID).then(function (Projects) {
								$scope.project = Projects.data;
					});
				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
	};

	$scope.uncompleteProject = function (index) {
		var project = $scope.SubProjectsComplete[index];
		var dataObj = $.param({
			subdelivery: project.id,
			deliveryid:project.projectid
		});
		$http.post(BASE_URL + 'delivery/uncompletesubdelivery', dataObj, config)
		.then(
			function (response) {
				if(response.data.success == true) {
					var project = $scope.SubProjectsComplete[index];
					$scope.SubProjectsComplete.splice($scope.SubProjectsComplete.indexOf(project), 1);
					$scope.subprojects.unshift(project);
					
					$http.get(BASE_URL + 'delivery/get_deliverys/'+PROJECTID).then(function (Projects) {
					$scope.project = Projects.data;
				});
				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
	};
});


$http.get(BASE_URL + 'delivery/subdeliverycomplete/' + PROJECTID).then(function (SubProjectsComplete) {
	$scope.projectCompletionTotal = function (unit) {
		var total = $scope.projectLength();
		return isNaN(Math.floor(100 / total * unit)) ? 0 : Math.floor(100 / total * unit);
	};
	$scope.SubProjectsComplete = SubProjectsComplete.data;
	$scope.projectLength = function () {
		return $scope.subprojects.length + $scope.SubProjectsComplete.length;
	};
});
/* 
$http.get(BASE_URL + 'projects/subprojectscomplete/' + PROJECTID).then(function (SubProjectsComplete) {
	$scope.projectCompletionTotal = function (unit) {
		var total = $scope.projectLength();
		return isNaN(Math.floor(100 / total * unit)) ? 0 : Math.floor(100 / total * unit);
	};
	$scope.SubProjectsComplete = SubProjectsComplete.data;
	$scope.projectLength = function () {
		return $scope.subprojects.length + $scope.SubProjectsComplete.length;
	};
}); */

$scope.MarkAs = function (index) {
	var subproject = $scope.subprojects[index];
	var dataObj = $.param({
		subdelivery: subproject.id,
		delivery_stage_id: subproject.delivery_stage_id,
		deliveryid: PROJECTID
	});
	var config = {
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
		}
	};
	var posturl = BASE_URL + 'delivery/markas/';
	$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				if(response.data.success == true) {
					$http.get(BASE_URL + 'delivery/get_deliverys/'+PROJECTID).then(function (Projects) {
						$scope.project = Projects.data;
					});
					showToast(NTFTITLE, langs.marked+' <b>'+name+'</b>', ' success');
					location.reload();

				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
};


$scope.uploading = false; 
$scope.uploadProjectFile = function() {
	//alert("1`2`1");
	$scope.uploading = true;
	var file = $scope.project_file;
	var uploadUrl = BASE_URL+'delivery/add_file/'+PROJECTID;
	fileUpload.uploadFileToUrl(file, uploadUrl, function(response) {
		if (response.success == true) {
			globals.mdToast('success', response.message);
		} else {
			globals.mdToast('error', response.message);
		}
		$scope.projectFiles = true;
		$http.get(BASE_URL + 'delivery/projectfiles/' + PROJECTID).then(function (Files) {
			$scope.files = Files.data;
			$scope.projectFiles = false;
		});
		$scope.uploading = false;
		$mdDialog.hide();
	});
};


$scope.projectFiles = true;
$http.get(BASE_URL + 'delivery/projectfiles/' + PROJECTID).then(function (Files) {
	$scope.files = Files.data;
	$scope.projectFiles = false;

	$scope.itemsPerPage = 6;
	$scope.currentPage = 0;
	$scope.range = function () {
		var rangeSize = 6;
		var ps = [];
		var start;

		start = $scope.currentPage;
		if (start > $scope.pageCount() - rangeSize) {
			start = $scope.pageCount() - rangeSize + 1;
		}
		for (var i = start; i < start + rangeSize; i++) {
			if (i >= 0) {
				ps.push(i);
			}
		}
		return ps;
	};
	$scope.prevPage = function () {
		if ($scope.currentPage > 0) {
			$scope.currentPage--;
		}
	};
	$scope.DisablePrevPage = function () {
		return $scope.currentPage === 0 ? "disabled" : "";
	};
	$scope.nextPage = function () {
		if ($scope.currentPage < $scope.pageCount()) {
			$scope.currentPage++;
		}
	};
	$scope.DisableNextPage = function () {
		return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
	};
	$scope.setPage = function (n) {
		$scope.currentPage = n;
	};
	$scope.pageCount = function () {
		return Math.ceil($scope.files.length / $scope.itemsPerPage) - 1;
	};
	
	$scope.ViewFile = function(index, image) {
		$scope.file = $scope.files[index];
		$mdDialog.show({
			templateUrl: 'view_image.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: $scope.file.id
		});
	}

	$scope.DeleteFile = function(id) {
		var confirm = $mdDialog.confirm()
			.title($scope.lang.delete_file_title)
			.textContent($scope.lang.delete_file_message)
			.ariaLabel($scope.lang.delete_file_title)
			.targetEvent(PROJECTID)
			.ok($scope.lang.delete)
			.cancel($scope.lang.cancel);

		$mdDialog.show(confirm).then(function () {
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'delivery/delete_file/' + id, config)
				.then(
					function (response) {
						if(response.data.success == true) {
							showToast(NTFTITLE, response.data.message, ' success');
							$http.get(BASE_URL + 'delivery/projectfiles/' + PROJECTID).then(function (Files) {
								$scope.files = Files.data;
							});
						} else {
							showToast(NTFTITLE, response.data.message, ' danger');
						}
					},
					function (response) {
						console.log(response);
					}
				);

		}, function() {
			//
		});
	};
});




$scope.AddProjectMember = function () {
	var dataObj = $.param({
		project: PROJECTID,
		staff: $scope.insertedStaff
	});
	console.log(dataObj, "hi")
	var config = {
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
		}
	};
	var posturl = BASE_URL + 'delivery/addmember';
	$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				if (response.data.success == true) {
					globals.mdToast('success', response.data.message);
					$mdDialog.hide(); 
					$scope.project.members.push({
						'id': response.data.member.staffavatar,
						'staffname': response.data.member.staffname,
						'staffavatar': response.data.member.staffavatar,
						'email': response.data.member.email,
					});
				} else {
					globals.mdToast('error', response.data.message);
				}
			},
			function (response) {
				console.log(response);
			}
		);
};


$scope.InsertMember = function (ev) {
	$mdDialog.show({
		templateUrl: 'insert-member-template.html', 
		scope: $scope,
		preserveScope: true,
		targetEvent: ev
	});
};



		$scope.UnlinkMember = function (index) { 
			var link = $scope.project.members[index];
			var confirm = $mdDialog.confirm()
				.title(langs.attention)
				.textContent(langs.remove_staff)
				.targetEvent(PROJECTID)
				.ok(langs.doIt)
				.cancel(langs.cancel);

			$mdDialog.show(confirm).then(function () {
				var linkid = link.id;
				var dataObj = $.param({
					linkid: linkid
				});
				var config = {
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
					}
				};
				$http.post(BASE_URL + 'delivery/unlinkmember/' + linkid, dataObj, config)
					.then(
						function (response) {
							if(response.data.success == true) {
								showToast(NTFTITLE, response.data.message, ' success');
								//location.reload();
							} else {
								globals.mdToast('error', response.data.message);
							}
						},
						function (response) {
							console.log(response);
						}
					);
				});
		};



		$scope.saving = false;
		$scope.UpdateProject = function () {
			$scope.saving = true;
			$scope.tempArr = [];
			angular.forEach($scope.custom_fields, function (value) {
				if (value.type === 'input') {
					$scope.field_data = value.data;
				}
				if (value.type === 'textarea') {
					$scope.field_data = value.data;
				}
				if (value.type === 'date') {
					$scope.field_data = moment(value.data).format("YYYY-MM-DD");
				}
				if (value.type === 'select') {
					$scope.field_data = JSON.stringify(value.selected_opt);
				}
				$scope.tempArr.push({
					id: value.id,
					name: value.name,
					type: value.type,
					order: value.order,
					data: $scope.field_data,
					relation: value.relation,
					permission: value.permission,
				});
			});

			if (!$scope.project) {
				var dataObj = $.param({
					name: '',
					customer: '',
					value: '',
					description: '',
					start: moment('').format("YYYY-MM-DD"),
					deadline: moment('').format("YYYY-MM-DD"),
					custom_fields: '',
				});
			} else {
				if ($scope.project.template != true || !$scope.project.template) {
					$scope.project.template = false;
				} else {
					$scope.project.template = true;
				}
				if ($scope.project.start) {
					$scope.project.start = moment($scope.project.start).format("YYYY-MM-DD")
				}
				if ($scope.project.deadline_edit) {
					$scope.project.deadline_edit = moment($scope.project.deadline_edit).format("YYYY-MM-DD")
				}
				var dataObj = $.param({
					name: $scope.project.name,
					customer: $scope.project.customer_id,
					value: $scope.project.value,
					tax: $scope.project.tax,
					description: $scope.project.description,
					start: $scope.project.start_edit,
					deadline: $scope.project.deadline_edit,
					custom_fields: $scope.tempArr,
					template: $scope.project.template
				});
			}

			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'delivery/update/' + PROJECTID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.saving = false;
						if (response.data.success == true) {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color success'
							});
							$mdSidenav('Update').close();
							$http.get(BASE_URL + 'delivery/get_project/'+PROJECTID).then(function (Projects) {
								$scope.project = Projects.data;
							});
						} else {
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						$scope.saving = false;
						console.log(response);
					}
				);
		};
		


};

CiuisCRM.controller('Delivery_Controller', Delivery_Controller);
CiuisCRM.controller('DeliveryCust_Controller', DeliveryCust_Controller);
