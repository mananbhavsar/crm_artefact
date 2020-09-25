function Salesreview_Controller($scope, $http, $mdSidenav,$mdDialog, $q, $timeout,fileUpload) {
	"use strict";
	
	/*$http.get(BASE_URL + 'api/get_projects/').then(function (Projects) {
		console.log(Projects);
		$scope.projects = Projects.data;
	});*/
	
	$http.get(BASE_URL + 'salesoverview/get_all_customers/').then(function (Customers) {
		$scope.customers = Customers.data;
	});
	
	$http.get(BASE_URL + 'salesoverview/get_all_sales_staff').then(function (Staff) {
		$scope.staffs = Staff.data;
	});
	
	
}

CiuisCRM.controller('Salesreview_Controller', Salesreview_Controller);