<?$db->update_view($id,$data['view']);
if($data['discount']==0)
			{
				$unprice='undiscount';
			}
			else{
				$unprice='line-through txt-b display';
			}
?>
<main>
	<section class="path txt-b">
	<a href="<?=$root_dir?>trang-chu.html"><i class="fa fa-home"></i>Trang chủ</a>
	<?=$db->path('cat',$data['idcat'])?>
	</section>
	<section class="slider">
	<?include("src/web_menu.php");?>
	<div class="box w75">
	<div class="box-slider wc">
	
			<?=zoom_slider($data['img'])?>
	</div>
	
	<div class="box-info w40">
		<form action="" name="formorder" method="post">
		   <input type="hidden" name="id" id="id" value="<?=$data['id']?>" /> 
		   
		   <input type="hidden" name="hidden_name"  id="hidden_name" value="<?=$data['name']?>" />  
		   <input type="hidden" name="hidden_color"  id="hidden_color" value="" /> 
		   <input type="hidden" name="hidden_size"  id="hidden_size" value="" /> 
		   <input type="hidden" name="hidden_price" id="hidden_price" value="<?=$data['price']?>" />
		   <input type="hidden" name="hidden_discount" id="hidden_discount" value="<?=$data['discount']?>" />
		   <input type="hidden" name="command" id="command" value="add" />
		<ul>
		<h3><?=$data['name']?>
		</h3>
		
		</ul>
		<h3>
		<span class="color-price txt-b"><?=number_format($data['price']-$data['price']*$data['discount']/100)?> <u>đ</u></span>
		<span ><h5 class="<?=$unprice?>"><?=$data['price']?><u>đ</u></h5></span></h3>
		
		
		
		
		<span>SL:
			<select name="quantity" >
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>
		</span>
		
		<div>
		<button type="submit" class="btn main-bg white"><i class="fa fa-shopping-cart"></i>Đặt hàng</button>
				
		<a href="tel:<?=$info['hotline']?>" class="btn "><span class="hotline_span"><i style="width=5px" class="fa fa-mobile main-bg white" aria-hidden="true"></i>Gọi điện tư vấn
				  </span></a>
				  
		</div>
		<div >
		
		Màu:
		<p id="colorpanel" class="color-panel">
		<?=color_display($data['color']);?>
	</p>
		</div>
		<div>
		Size:
		<?=size_display($data['size']);?>

		</div>
		<p>
		Mã: <?=$data['sku']?>
		</p>
		<p>
		Category: <?=$db->id_to_name("db_tblcat",$data['idcat'])?>
		</p>
		<ul>
		Thông tin: 
		</ul>
		<ul>
		Nguồn gốc:
		</ul>
		<ul>
		Chứng nhận:
		</ul>
		<ul>
		Lượt xem: <?=number_format($data['view'])?>
		</ul>
		</form>
	</div>
	<div class="box-text ">
	<li>
			<a href="" class="color-fb"> <i class="fa fa-facebook-square " aria-hidden="true"></i></a>
			<a href="" class="color-tw"> <i class="fa fa-twitter " aria-hidden="true"></i></a>
			<a href="" class="color-yt"> <i class="fa fa-google-plus-square " aria-hidden="true"></i></a>
	</li>
	<ul>
	Mô tả: <?=$data['description']?>
	</ul>
	<ul>
	Nội dung: <?=$data['content']?>
	</ul>
	</div>
	</div>
	</div>
	</section>
	<?include("web_box_produce.php")?>
	
	<div></div>
	<div></div>
	<div></div>
	<div></div>
	</section>
	</main>