<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** Read-only fixtures. No database connection or writes. */
class Demo_model extends Model {
 public function plans() { return [
 'individual'=>['name'=>'Individual Plan','price'=>25000,'tag'=>'A thoughtful beginning','coverage'=>['Basic memorial service','Documentation assistance','Chapel usage']],
 'family'=>['name'=>'Family Plan','price'=>50000,'tag'=>'Care for those closest to you','coverage'=>['Family service coverage','Documentation assistance','Transportation service']],
 'premium'=>['name'=>'Premium Plan','price'=>100000,'tag'=>'Considered care, every step','coverage'=>['Comprehensive memorial service','Priority scheduling','Chapel and transportation service']]]; }
 public function schedule() { return [['Oct 20, 2026','₱5,000','Paid'],['Nov 20, 2026','₱5,000','Pending'],['Dec 20, 2026','₱5,000','Pending'],['Jan 20, 2027','₱5,000','Pending'],['Feb 20, 2027','₱5,000','Pending']]; }
 public function table($page) {
 $tables=[
 'customers'=>[['Client','Customer','Email','Status'],[['CL-001','Juan Dela Cruz','juan@example.test','Active'],['CL-002','Maria Santos','maria@example.test','Active'],['CL-003','Pedro Reyes','pedro@example.test','Pending']]],
 'contracts'=>[['Contract','Customer','Plan','Amount','Status'],[['CON-001','Juan Dela Cruz','Individual Plan','₱25,000','Active']]],
 'billing'=>[['Due date','Amount due','Status'],$this->schedule()],
 'payments'=>[['Payment','Customer','Date','Amount','Method','Status'],[['PAY-001','Juan Dela Cruz','Oct 20, 2026','₱5,000','GCash','Paid']]],
 'history'=>[['Payment','Date','Amount','Method','Status'],[['PAY-001','Oct 20, 2026','₱5,000','GCash','Paid']]],
 'methods'=>[['Method','Provider','Status'],[['GCash','Demo wallet','Active'],['Bank Transfer','Demo bank','Active'],['Credit / Debit Card','Demo gateway','Active']]],
 'receipts'=>[['Receipt','Contract','Issued','Amount','Status'],[['RCP-001','CON-001','Oct 20, 2026','₱5,000','Sample']]],
 'documents'=>[['File','Contract','Type','Status'],[['DOC-001','CON-001','Contract illustration','Sample']]],
 'inquiries'=>[['Inquiry','Customer','Subject','Status'],[['INQ-001','Juan Dela Cruz','Plan coverage','Pending']]],
 'support'=>[['Inquiry','Subject','Date','Status'],[['INQ-001','Plan coverage','Oct 12, 2026','Pending']]],
 'notifications'=>[['Reference','Message','Channel','Status'],[['NTF-001','Sample reminder for Nov 20, 2026','In-app','Sample']]],
 'users'=>[['Name','Email','Role','Status'],[['Demo Administrator','admin@example.test','Administrator','Active'],['Juan Dela Cruz','juan@example.test','Customer','Active']]]];
 return $tables[$page] ?? [[],[]];
 }
}
