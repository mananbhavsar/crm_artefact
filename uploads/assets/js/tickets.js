function Tickets_Controller($scope, $http, $mdSidenav, fileUpload, $filter, $mdToast) {
	"use strict";

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'ticket').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = ($scope.all_custom_fields, {
			active: 'true',
		});
	});
	
  $scope.groupSetup = {
    multiple: true,
    formatSearching: 'Searching the group...',
    formatNoMatches: 'No group found'
  };
  
  // custom function to convert string into attay (string arra or integer array)
  $scope.split_custom = function(string, spliter, is_integer) {
    $scope.ret_arr = string.split(spliter); // convert string into array
    if (is_integer==1)
      $scope.ret_arr = $scope.ret_arr.map(Number); // convert string array into integer array
    return $scope.ret_arr;
  };

	$scope.Create = buildToggler('Create');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();

		};
	}
	$scope.close = function () {
		$mdSidenav('Create').close();
	};

	globals.get_departments();
	$scope.get_staff();
	$scope.createTicket = function() {
		$scope.uploading = true;
		if (!$scope.ticket) {
			var dataObj = {
				subject: '',
				customer: '',
				contact: '',
				department: '',
				employee: '',
				priority: '',
				message: '',
				file: '',
				due_date:moment('').format("YYYY-MM-DD")
			};
		} else {
			var dataObj = {
				subject: $scope.ticket.subject,
				customer: $scope.ticket.customer,
				contact: $scope.ticket.contact,
				department: $scope.ticket.department,
				employee: $scope.ticket.employee,
				priority: $scope.ticket.priority,
				message: $scope.ticket.message,
				file: $scope.ticket.ticket_attachment,
				due_date: moment($scope.ticket.due_date).format("YYYY-MM-DD")
			};
		}
		var uploadUrl = BASE_URL+'tickets/create/';
		fileUpload.uploadFileWithData(dataObj, uploadUrl, function(response) {
			if (response.success == true) {
				$mdSidenav('Create').close();
				globals.mdToast('success', response.message);
				$scope.ticketsLoader = true;
				$http.get(BASE_URL + 'api/tickets').then(function (Tickets) {
					$scope.tickets = Tickets.data;
					$scope.ticketsLoader = false;
				});
			} else {
				globals.mdToast('error', response.message);
			}
			$scope.uploading = false;
		});
	};

	$scope.ticket_list = {
		order: '',
		limit: 40,
		page: 1
	};
	$scope.ticketsLoader = true;
	$http.get(BASE_URL + 'api/tickets').then(function (Tickets) {
		$scope.tickets = Tickets.data;
		$scope.limitOptions = [40, 80, 120, 160];
		if ($scope.tickets.length > 40) {
			$scope.limitOptions = [40, 80, 120, 160, $scope.tickets.length];
		}
		$scope.ticketsLoader = false;
		$scope.GoTicket = function (TICKETID) {
			window.location.href = BASE_URL + 'tickets/ticket/' + TICKETID;
		};
		$scope.search = {
			subject: '',
			message: ''
		};

		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
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
			return Math.ceil($scope.tickets.length / $scope.itemsPerPage) - 1;
		};
	});

	$scope.ShowKanban = function () {
		$scope.KanbanBoard = true;
	};

	$scope.HideKanban = function () {
		$scope.KanbanBoard = false;
	};

	$http.get(BASE_URL + 'api/customers').then(function (Customers) {
		$scope.customers = Customers.data;
	});
		$http.get(BASE_URL + 'api/get_projects').then(function (Projects) {
		$scope.projects = Projects.data;
	});

	// $http.get(BASE_URL + 'api/contacts').then(function (Contacts) {
	// 	$scope.contacts = Contacts.data;
	// });
}

function Ticket_Controller($scope, $http, $mdDialog, fileUpload, $mdSidenav) {
	"use strict";

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function () {
		$mdDialog.hide();

	};

	$scope.get_staff();

	$scope.AssigneStaff = function (ev) {
		$mdDialog.show({
			templateUrl: 'insert-member-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$http.get(BASE_URL + 'api/custom_fields_data_by_type/' + 'ticket/' + TICKETID).then(function (custom_fields) {
		$scope.custom_fields = custom_fields.data;
	});

	globals.get_departments();
	$scope.replying = false;
	$scope.replyToTicket = function() { 
		$scope.replying = true;
		if (!$scope.reply) {
			var dataObj = {
				message: '',
				file: ''
			};
		} else {
			var dataObj = {
				message: $scope.reply.message,
				file: $scope.reply.attachment
			};
		}

		var uploadUrl = BASE_URL+'tickets/reply/'+TICKETID;
		fileUpload.uploadFileWithData(dataObj, uploadUrl, function(response) {
			if (response.success == true) {
				$('#chooseFile').val('');
				$scope.reply.message = '';
				//showToast(NTFTITLE, response.message, ' success');
				$http.get(BASE_URL + 'tickets/get_ticket/' + TICKETID).then(function (TicketDetails) {
					$scope.ticket = TicketDetails.data;
				});
			} else {
				showToast(NTFTITLE, response.message, ' danger');
			}
			$scope.replying = false;
		});
	};

	$scope.ticketsLoader = true;
	$http.get(BASE_URL + 'tickets/get_ticket/' + TICKETID).then(function (TicketDetails) {
		$scope.ticket = TicketDetails.data;
		$scope.ticketsLoader = false;
		$scope.AssignStaff = function () {
			var dataObj = $.param({
				staff: $scope.AssignedStaff,
			});
			var posturl = BASE_URL + 'tickets/assign_staff/' + TICKETID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if(response.data.success == true) {
							$mdDialog.hide();
							$scope.ticket.assigned_staff_name = response.data.name;
								$window.location.reload();
							//$scope.ticket.assignedto_staff_name = response.data.person;
						} else {
							$mdDialog.hide();
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						console.log(response);
					}
				);
			
		};
		$scope.Reply = function () {
			var dataObj = $.param({
				message: $scope.reply.message,
				attachment: $scope.reply.attachment,
			});
			var posturl = BASE_URL + 'tickets/reply/' + TICKETID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$scope.ticket.replies.push({
							'message': $scope.reply.message,
							'name': LOGGEDINSTAFFNAME,
							'date': new Date(),
							'attachment': $scope.reply.attachment,
						});
						$scope.reply.attachment = '';
						$scope.reply.message = '';
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.Delete = function () {
			// Appending dialog to document.body to cover sidenav in docs app
			var confirm = $mdDialog.confirm()
				.title(lang.attention)
				.textContent(lang.ticketattentiondetail)
				.ariaLabel(lang.delete +' ' + lang.ticket)
				.targetEvent(TICKETID)
				.ok(lang.doIt)
				.cancel(lang.cancel);

			$mdDialog.show(confirm).then(function () {
				$http.post(BASE_URL + 'tickets/remove/' + TICKETID, config)
					.then(
						function (response) {
							if(response.data.success == true){
								window.location.href = BASE_URL + 'tickets';
								globals.mdToast('error', response.data.message);
							} else {
								globals.mdToast('error', response.data.message);
							}
						},
						function (response) {
							console.log(response);
						}
					);

			}, function () {
				//
			});
		};
	});

	$scope.MarkAs = function (id, name) {
		var dataObj = $.param({
			status_id: id,
			ticket_id: TICKETID,
			name: name,
		});
		var posturl = BASE_URL + 'tickets/markas/';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if(response.data.success == true){
						globals.mdToast('success', response.data.message);
						window.location.reload();
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};
}

CiuisCRM.controller('Tickets_Controller', Tickets_Controller);
CiuisCRM.controller('Ticket_Controller', Ticket_Controller);
