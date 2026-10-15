<?php
// Local CLI server only. Run from project root; never deploy this router.
if (PHP_SAPI !== 'cli-server') { http_response_code(404); exit; }
$path=rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (preg_match('#^/(app|scheme|console|runtime|database|docs|tests|\.git)(/|$)#i',$path)) { http_response_code(403); exit; }
$file=realpath(__DIR__.'/../public'.$path);
$root=realpath(__DIR__.'/../public').DIRECTORY_SEPARATOR;
if($file && str_starts_with($file,$root) && is_file($file) && preg_match('/\.(css|js|svg|png|jpg|ico)$/i',$file)) {
 $types=['css'=>'text/css','js'=>'text/javascript','svg'=>'image/svg+xml','png'=>'image/png','jpg'=>'image/jpeg','ico'=>'image/x-icon'];
 header('Content-Type: '.$types[strtolower(pathinfo($file,PATHINFO_EXTENSION))]); readfile($file); return;
}
$_SERVER['SCRIPT_NAME']='/index.php';
require __DIR__.'/../public/index.php';
