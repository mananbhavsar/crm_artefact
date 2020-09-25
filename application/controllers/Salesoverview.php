<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Salesoverview extends CIUIS_Controller
{

	function __construct()
	{
		parent::__construct();
		$path = $this->uri->segment(1);
		$this->load->model('Customers_Model');
		$this->load->model('Sales_Model');
	}

	function index()
	{

		$data['title'] = lang('staff');
		$data['staff'] =  $this->Customers_Model->get_all_salesstaffamount('16');
		$data['customer'] = $this->Customers_Model->get_all_customerstotalinvoice();
		$data['saledata'] = $this->Sales_Model->get_allsalestargetdata();
		$this->load->view('salesoverview/index', $data);
	}

	function get_all_customers()
	{
		$staff_uid = 	$this->input->post('staff_uid');
		if ($staff_uid == "") {
			$customers = $this->Customers_Model->get_all_customerstotalinvoice();
		} else {
			$customers = $this->Customers_Model->get_all_custinvoicebystaff($staff_uid);
		}
		echo json_encode($customers);
	}

	function get_all_salesoverview()
	{
		$i = 0;
		$salesarray =  array();
		$salesarray[] = array('Months', 'Achieved', 'Target');
		$month	 = date('F');
		$months = ["1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May","6"=> "June","7"=> "July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"];
		$staff_uid = 	$this->input->post('staff_uid');
		if ($staff_uid == "") {
			$sales_invoice = $this->Customers_Model->get_all_salesdatainvoice();
			$monthly_target = $this->Sales_Model->get_company_monthlysales();
		} else {
			$sales_invoice = $this->Customers_Model->get_all_salesdatainvoicebystaff($staff_uid);
			$monthly_target = $this->Sales_Model->get_company_monthlysalesforstaff($staff_uid);
		}
		if (!empty($sales_invoice)) {
			$i = 0;
			$existingmonths = array_column($sales_invoice, 'months');
			foreach($months as $key=>$eachmonth) {
				if(!in_array($eachmonth, $existingmonths)) {
					$sales_invoice[] = array('monthnumber'=>$key, 'months'=>$eachmonth, 'total'=> 0);
				}
			}
			array_multisort( array_column($sales_invoice, "monthnumber"), SORT_ASC, $sales_invoice );
			
			foreach ($sales_invoice as $row) {
				$salesarray[] = array($row["months"], intval($row["total"]), intval($monthly_target[0]["company_monthtarget"]));
				if ($row["months"] == $month) {
					break;
				}
			}
		}
		echo json_encode($salesarray);
	}

	function addsalestarget()
	{
		$sales_uid = $this->Sales_Model->salestarget_add();
		echo json_encode($sales_uid);
	}

	function editsalestarget()
	{
		$salestarget_uid =  $this->input->post('salestarget_id');
		$sales_uid = $this->Sales_Model->get_salestargetdata($salestarget_uid);
		echo json_encode($sales_uid);
	}

	function get_companymetredata()
	{
		$salesarray =  array();
		$totalquaterly = 0;
		$quater_target = $this->Sales_Model->get_companytargetquaterly();
		$total_targetachived = $this->Sales_Model->get_companytotaltargetachived();
		if (!empty($quater_target)) {
			foreach ($quater_target as $row) {
				$quater1 = $row["qtr1"];
				$quater2 = $row["qtr2"];
				$quater3 = $row["qtr3"];
				$quater4 = $row["qtr4"];
				$totalquaterly =  $row["total_amount"];
			}
		}

		/* 	$quater1per = round($quater1/$totalquaterly  *100);
		$quater2per = round($quater2/$totalquaterly  *100);
		$quater3per = round($quater3/$totalquaterly  *100);
		$quater4per = round($quater4/$totalquaterly  *100); */

		$Q1  = intval($quater1);
		$Q2  = $Q1 + $quater2;
		$Q3  = $Q2 + $quater3;
		$Q4  = $Q3 + $quater4;
		$salesarray[] =  array("minvalue" => 0, "maxvalue" => $Q1, "code" => "#F2726F");
		$salesarray[] =  array("minvalue" => $Q1, "maxvalue" => $Q2, "code" => "#F2728F");
		$salesarray[] =  array("minvalue" => $Q2, "maxvalue" => $Q3, "code" => "#FFC533");
		$salesarray[] =  array("minvalue" => $Q3, "maxvalue" => $Q4, "code" => "#62B58F");
		echo json_encode(array("sales" => $salesarray, "upperlimit" => $totalquaterly, "total_targetachived" => $total_targetachived[0]["total_targetachived"]));
	}
}
