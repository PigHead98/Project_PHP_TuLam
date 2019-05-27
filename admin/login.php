
<!DOCTYPE html>
<html lang="en-vn">
<head>
<title>Đăng nhập vào trang quản trị</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="api/bootstrap/css/bootstrap.min.css"> 
<link rel="stylesheet" href="api/bootstrap/js/bootstrap.min.js"> 
<link rel="stylesheet" href="css/font-awesome.css"> 
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /> 

</head>
<body>
		
		<div class="header-w3l">
			<h1>Glassy Login Form</h1>
		</div>
		
		<div class="main-w3layouts-agileinfo">
	           <!--form-stars-here-->
						<div class="wthree-form">
							<h2>Fill out the form below to login</h2>
							<form action="config/processlogin.php" method="POST">
								<div class="form-sub-w3">
									<input type="text" name="Usermail" placeholder="Email@exemple.com " required="" />
								<div class="icon-w3">
									<i class="fa fa-user" aria-hidden="true"></i>
								</div>
								</div>
								<div class="form-sub-w3">
									<input type="password" name="Password" placeholder="Password" required="" />
								<div class="icon-w3">
									<i class="fa fa-unlock-alt" aria-hidden="true"></i>
								</div>
								</div>
								<label class="anim">
								<input type="checkbox" class="checkbox">
									<span>Remember Me</span> 
									<a href="#">Forgot Password</a>
								</label> 
								<div class="clear"></div>
								<div class="submit-agileits">
									<input type="submit" name="abmlogin" value="Login">
								</div>
							</form>

						</div>
				

		</div>
		
		<div class="footer">
			<p><a></a></p>
		</div>
		
</body>
</html>