<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  ======================================= 
 *  Author     : Team Tech Arise 
 *  License    : Protected 
 *  Email      : info@techarise.com 
 * 
 *  ======================================= 
 */
require_once APPPATH . "third_party/PHPExcel/Classes/PHPExcel/IOFactory.php";
class IOFactory extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}
?>