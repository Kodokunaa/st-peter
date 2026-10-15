<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
require_once APP_DIR.'controllers/Memorial.php';
class Customer_portal extends Memorial {
 public function page($page='dashboard',$detail=null) { $this->render('customer',$page,$detail); }
}
