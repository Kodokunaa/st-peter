<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
return [
 'public'=>['home'=>'Home','about'=>'About Us','plans'=>'Memorial Plans','faq'=>'Frequently Asked Questions','contact'=>'Contact & Support','login'=>'Login','register'=>'Register','forgot-password'=>'Forgot Password','reset-password'=>'Reset Password'],
 'customer'=>['dashboard'=>'Dashboard','profile'=>'My Profile','plans'=>'My Plans','contracts'=>'Contract Details','billing'=>'Billing & Installments','payment'=>'Make a Payment','history'=>'Payment History','receipts'=>'Digital Receipts','documents'=>'My Documents','support'=>'Support Requests','notifications'=>'Notifications','beneficiaries'=>'Beneficiaries'],
 'admin'=>['dashboard'=>'Dashboard','customers'=>'Customers','plans'=>'Memorial Plans','contracts'=>'Plan Contracts','billing'=>'Billing & Installments','payments'=>'Payments & Transactions','methods'=>'Payment Methods','receipts'=>'Digital Receipts','documents'=>'Document Management','inquiries'=>'Inquiries Management','notifications'=>'Notifications','users'=>'Users & Roles','reports'=>'Reports','services'=>'Services Catalog','refunds'=>'Refunds'],
 'children'=>[
 'customer'=>['profile'=>['edit','password'],'contracts'=>['CON-001','coverage','schedule','documents'],'billing'=>['upcoming','details'],'payment'=>['checkout','status'],'history'=>['PAY-001'],'receipts'=>['RCP-001'],'documents'=>['DOC-001'],'support'=>['new','INQ-001'],'notifications'=>['NTF-001']],
 'admin'=>['customers'=>['add','CL-001','CL-002','CL-003','edit','contracts','payments','documents'],'plans'=>['add','individual','family','premium','edit'],'contracts'=>['create','CON-001','edit'],'billing'=>['create','edit','status'],'payments'=>['record','PAY-001','transaction','qr'],'methods'=>['add','edit'],'receipts'=>['RCP-001'],'documents'=>['upload','DOC-001'],'inquiries'=>['INQ-001','respond'],'notifications'=>['NTF-001','delivery'],'users'=>['add','edit','roles','status'],'reports'=>['collections','contracts','enrollments','overdue','methods']]
 ]
];
