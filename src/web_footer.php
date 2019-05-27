
<footer class="foo-top bg-footer text-color">
	<ul class="support w17 ">
	<h3 class="center-f"><i class="fa fa-phone-square" aria-hidden="true"></i>Tổng Đài Hỗ Trợ</h3>
		<li class="out-list">
			<span >Mọi thắc mắc vui lòng liên hệ:</span>
		</li>	
			<li class="out-list">
			<a class="text-color"> Số điện thoại:<?=$info['phone']?></a>
				
		</li>
	</ul>
	<ul class="hidden-ft w20">
	<h3 class="center-f"><i class="fa fa-info" aria-hidden="true"></i></i>Về Chúng Tôi</h3>
	<div class="inf-ft center-f"><?=$db->list_footer('cattask')?></div>
	</ul>
	<ul class="mid-footer center-f w21">
	<h3><i class="fa fa-map-marker" aria-hidden="true"></i>Địa Chỉ</h3>
	<a class="text-color"><?=$info['address']?></a>
	</ul>
	<ul class="contact center-f w26 "><h3>Liên Hệ Với Chúng Tôi Qua:</h3>
		<li>
			<a href="<?=$info['facebook']?>" target="blank" class="main-bg"> <i class="fa fa-facebook-square " aria-hidden="true"></i></a>
			<a href="<?=$info['twitter']?>" target="blank" class="color-tw"> <i class="fa fa-twitter " aria-hidden="true"></i></a>
			<a href="<?=$info['googleplus']?>" target="blank" class="color-yt"> <i class="fa fa-google-plus-square " aria-hidden="true"></i></a>
			<a href="<?=$info['instagram']?>" target="blank" class="color-itg"> <i class="fa fa-instagram " aria-hidden="true"></i></a>
		</li>
	</ul>
</footer>
