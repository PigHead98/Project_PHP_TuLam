<?		
	require('init.php');
	$usermail=$db->post('Usermail');
	$password=$db->post('Password');
	if($db->post('abmlogin')!='')//quan trọng
	{
	$db->login($usermail,$password);
	}
	?>
	