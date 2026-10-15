<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
require_once APP_DIR.'controllers/Memorial.php';
class Public_site extends Memorial {
 public function index() { $this->render('public','home'); }
 public function page($page) { $this->render('public',$page); }
 public function plan($slug) { $this->render('public','plans',$slug); }
}
