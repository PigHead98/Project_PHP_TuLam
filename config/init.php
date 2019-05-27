<?//htaccess <- tìm hiểu
	session_start();
	require('db.php');
	require('func.php');
	require('admin/config/dbconfig.php');
	require('shopping_process.php');
	require('api/mailer/PHPMailerAutoload.php');
	
	$shopping= new shopping($host, $user, $password, $database);
	$link=getlink();
	$db->seo($cmd,$link,$id,$data);
	$db->info($info);
	
?>
