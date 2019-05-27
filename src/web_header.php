
<header>
	<div class="header top">

		<ul>
		
		<li id="rescallsuport"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span class="txt-b">012356469</span></a></li>
		<li id="ressearch"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
		</ul>
	</div>
	<div class="header bottom container">
		<ul class="logo w25">
		<li><a href="<?=$root_dir?>trang-chu.html"><img src="<?=$root_dir?>img/logo.jpg" alt="logo"></a>
		</li>
		</ul>
		<ul class="search w50">
			<li id="box-social" class="txt-b help_header container">
			Bạn cần giúp đỡ : <a href="tel:<?=$info['hotline']?>" id="callsuport" class="main-color"><?=$info['hotline']?></a>
			
			</li>
			<li >
				<form name="frmseach">
				<input class="form-control display-in" type="text" name="fname" placeholder="Bạn đang cần mua sản phẩm gì??"/>
				<button class="form-control display-in btn-search" name="btnseach"><i class="fa fa-search " aria-hidden="true"></i></button>
				</form>
			</li>
		</ul>
		<ul class="card w25">
		<li id="card">
		
		<a href="#" data-toggle="modal" data-target="#modalshoping">
		
		<div class="cart-icon w50 container"><i class="fa fa-cart-arrow-down  " aria-hidden="true"></i></div>
		<div class="f-right w50 container ">
		
		<span id="cart-text" class="txt-b ">Giỏ hàng: <?=$shopping->count_item_shopping_cart()?></span>
		<span id="cart-total" class="text-arrow"><b><?=number_format($shopping->total_after_discount_shopping_cart())?><u>đ</u></b></span>
		</div>
		
		</a>
		</li><?=$shopping->list_item_shopping_cart('modalshoping')?>
		</ul>
		</div>
	
	</header>