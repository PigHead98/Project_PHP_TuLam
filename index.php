<?php
require("config/init.php")?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$data['name']?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="<?=$data['keyword']?>">
<meta name="description" content="<?=$data['description']?>">
<!--fb-->
 <meta content="<?=$data['sitename']?>" property="og:site_name"/>
        <meta property="og:url" itemprop="url" content="<?=$data['domain']?>" />
        <meta property="og:image" itemprop="thumbnailUrl" content="<?=$data['domain']?>/img/logo.jpg" />
        <meta content="<?=$data['name']?>" itemprop="headline" property="og:title" />
        <meta content="<?=$data['description']?>" itemprop="description" property="og:description"/>
<!--gg-->
		 <meta name="dc.created" content="<?=$data['date']?>" />
        <meta name="dc.publisher" content="<?=$data['name']?>" />
        <meta name="dc.rights.copyright" content="<?=$data['name']?>" />
        <meta name="dc.creator.name" content="<?=$data['name']?>" />
        <meta name="dc.creator.email" content="<?=$data['email']?>" />
        <meta name="dc.identifier" content="<?=$data['domain']?>" />
        <meta name="copyright" content="<?=$data['email']?>" />
        <meta name="author" content="<?=$data['email']?>" />
        <meta name="dc.language" content="vi-VN" />
        <meta name="robots" content="index,follow" />
        <meta http-equiv="content-language" content="vi"/>
        <meta name="geo.placename" content="TP Ho Chi Minh, Viet Nam" />
        <meta name="geo.region" content="VN-HCM" />
        <meta name="geo.position" content="<?=$data['map']?>" />
        <meta name="ICBM" content="<?=$data['map']?>" />
        <meta name="revisit-after" content="days">
        <link rel="alternate" href="<?=$data['domain']?>" hreflang="vi-vn" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?=$data['name']?>" />
		<meta property="og:description" content="<?=$data['description']?>" />
		<meta property="og:url" content="<?=$data['domain']?>" />
		<meta property="og:site_name" content="<?=$data['sitename']?>" />
<!--tw-->
 <meta name="twitter:card" value="summary">
		<meta name="twitter:url" content="<?=$data['domain']?>">
				<meta name="twitter:title" content="Tin nhanh VnExpress - Đọc báo, tin tức online 24h">
				<meta name="twitter:description" content="<?=$data['description']?>">
				<meta name="twitter:image" content="<?=$data['domain']?>/img/logo.jpg"/>
		<meta name="twitter:site" content="@<?=$data['twitter']?>">
        <meta name="twitter:creator" content="@<?=$data['twitter']?>">


<link rel="icon" href="<?=$root_dir?>img/a.jpg">
<link rel="stylesheet" type="text/css" href="<?=$root_dir?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?=$root_dir?>css/menu.css">

<link rel="stylesheet" type="text/css" href="<?=$root_dir?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?=$root_dir?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?=$root_dir?>api/owlcarousel/owl.carousel.min.css">
<link rel="stylesheet" href="<?=$root_dir?>api/owlcarousel/owl.theme.default.min.css">
<script src="<?=$root_dir?>js/jquery-3.2.1.min.js"></script>
<script src="<?=$root_dir?>api/owlcarousel/owl.carousel.min.js"></script>
<script src="<?=$root_dir?>api/elevatezoom/jquery.elevatezoom.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=$root_dir?>api/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=$root_dir?>api/bootstrap/css/bootstrap-theme.min.css">
<script src="<?=$root_dir?>api/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$root_dir?>css/style.css">
<script src="<?=$root_dir?>js/script.js"></script>
<script src="<?=$root_dir?>js/cart.js"></script>
<script src="<?=$root_dir?>js/jscolor.js"></script>
<script src="<?=$root_dir?>js/jscolor.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111426510-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111426510-1');
</script>

</head>
<body>

<?
//$root_dir="../../web/"
include("src/web_login.php");
include("src/web_header.php");
include("src/web_".$cmd.".php");
include("src/web_footer.php");
?>

<div id="resultajax"></div>
</body>
<form  name="frmcart" method="post" action="">  
		<input type="hidden" name="id" id="id" value="" /> 
	   <input type="hidden" name="quantity" id="quantity" value="1" />  
	   <input type="hidden" name="hidden_color"  id="hidden_color" value="" />  
	   <input type="hidden" name="hidden_size"  id="hidden_size" value="" />  
	   <input type="hidden" name="hidden_name"  id="hidden_name" value="" />  
	   <input type="hidden" name="hidden_price" id="hidden_price" value="" />
	   <input type="hidden" name="hidden_discount" id="hidden_discount" value="" />
	   <input type="hidden" name="command" id="command" value="" />
</form>
</html>
