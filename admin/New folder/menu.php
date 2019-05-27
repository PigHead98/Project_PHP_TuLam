<div class="crbnMenu">
	<div class="link-stack">
		<img src="<?=$upload_dir.$db->display('image')?>" width="50"/>
		<span class="brand all"><?=$db->display('name')?></span>
			<a id="nav-toggle" class="nav-toggle">
				<span></span>
			 </a>
	</div>
	<ul class="menu">
		<li>
			<a class="nav-link" href="#">
				<i class="fa fa-th"></i> <span>Quản lí sản phẩm</span>
				<span class="menu-toggle"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
			</a>
			<ul>
				<li>
					<a href="index.php?cmd=cat">Danh mục</a>
				</li>
				<li>
					<a href="index.php?cmd=product">Sản phẩm</a>
				</li>
				<li>
					<a href="index.php?cmd=poster">Poster</a>
				</li>
				<li>
					<a href="index.php?cmd=list_footer">Footer</a>
				</li>
				<li>
					<a href="index.php?cmd=inf_footer">inf_Footer</a>
				</li>
				<li>
					<a href="index.php?cmd=info">Info</a>
				</li>
			</ul>
		</li>
		<li>
			<a class="nav-link" href="#">
				<i class="fa fa-cogs"></i> <span>Cấu hình website</span>
				<span class="menu-toggle"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
			</a>
			<ul>
				<li>
					<a href="index.php?cmd=account">Quản lí tài khoản</a>
				</li>
				<li>
					<a href="index.php?cmd=client">Quản lí khách hàng</a>
				</li>
				<li>
					<a href="index.php?cmd=seo">Quản lí SEO</a>
				</li>
				<li>
					<a href="#">Tạo sitemap</a>
				</li>
			</ul>
		</li>
		<li>
			<a class="nav-link" href="#">
				<i class="fa fa-cogs"></i> <span>Quản lý đơn hàng</span>
				<span class="menu-toggle"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
			</a>
			<ul>
				<li>
					<a href="index.php?cmd=customer">Khách hàng</a>
				</li>
				<li>
					<a href="index.php?cmd=orders">Quản lí đơn hàng</a>
				</li>
				<li>
					<a href="index.php?cmd=order_detail">Chi tiết đơn hàng</a>
				</li>
			</ul>
		</li>
		<li>
			<a class="nav-link" href="index.php?cmd=logout">
				<i class="fa fa-sign-in"></i> <span>Thoát</span>
			</a>
		</li>
	</ul>
</div>
<div class="content">
	<div class="row">
<div class="col-sm-12 ">
		<div class="col-sm-6 ">
			<a href="index.php" class="btn btn-default"> <i class="fa fa-home"></i>&nbsp;Trang chủ</a>
			<a href="index.php?cmd=<?=$cmd?>&act=manager" class="btn btn-primary"> <i class="fa fa-th"></i>&nbsp;Quản lý</a>
			<a href="index.php?cmd=<?=$cmd?>&act=add" class="btn btn-danger"> <i class="fa fa-plus"></i>&nbsp;Tạo mới</a>
		</div>
		<div class="col-sm-6 ">
			<div class="col-sm-8 ">
				<form name="frmsearch" class="from-inline" action="" method="POST">
				<div class="form-group">
					<input type="text" name="search" class="fromcontrol" placeholder="search " value="" />
					<button type="submit" class="btn btn-info"><i class="fa  fa-search"></i>&nbsp;Tìm kiếm</button>
				</form>
				</div>
				
			</div>
			<div class="col-sm-4 message">
				<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope-o " aria-hidden="true"></i></a>
			</div>
			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				  </div>
				  <div class="modal-body">
					<p>Some text in the modal.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>

			  </div>
			</div>
		</div>
		</div>



<script>
	$(document).ready(function(){
		$('.menu').crbnMenu({
			hideActive: true
		});
	});
</script>
