<?
	session_start();
	require('db.php');
	require('func.php');
	require('dbconfig.php');
	$db->checklogin("./");
?>