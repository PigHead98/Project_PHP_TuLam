<?
	$host="127.0.0.1"; 
	$user="root"; 
	$password=""; 
	$database="banhang";
	$folder="banhang/";
	$root_dir="../../".$folder;
	//$root_dir=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/".$folder;
	$absolute_dir=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/".$folder."upload/thumb/"; //ECHO $absolute_dir;
	$upload_dir=$root_dir."upload/";
	$thumb_dir=$upload_dir."thumb/";
	$small_dir=$upload_dir."small/";
	$max_file_size_upload=5000000;
	$paper=20;
	$thumb_width=100;
	$thumb_height=50;
	$small_width=550;
	$small_height=450;
	$db_prifix='db_tbl';
	$db=new db($host, $user, $password, $database);
	$db->get('cmd')!=""?$cmd=$db->get('cmd'):$cmd="main";
	$db->get('act')!=""?$act=$db->get('act'):$act="manager";
	$db->get('id')!=""?$id=$db->get('id'):$id=0;
	
?>