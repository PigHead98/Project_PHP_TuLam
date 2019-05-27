<?
require("config/init.php");
$db_table='product';
$id=$db->post('id');
$sql="select * from ".$db_prifix."product where id=$id and status=1";
$resual=$db->myquery($sql);
$data=$db->fetch_row($resual);
if($data['discount']==0)
			{
				$unprice='undiscount';
			}
			else{
				$unprice='line-through txt-b';
			}
?>
<script>
$( document ).ready(function() {
   $('#buynowmodal').modal('show');
});
</script>

<div id="buynowmodal" class="modal fade  " role="dialog">
  <div class="modal-dialog"> 

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thông tin sản phẩm</h4>
      </div>
      <div class="modal-body">
       <div class=" w100">
	<div class="box-slider ">
	
			<?=img_display($data['img'],400)?>
	</div>
	
	<div class="box-info txt-center">
		<form action="" name="formorder" method="POST">
		   <input type="hidden" name="id" id="id" value="<?=$data['id']?>" /> 
			<input type="hidden" name="hidden_color"  id="hidden_color" value="" /> 
		   <input type="hidden" name="hidden_size"  id="hidden_size" value="" /> 
		   <input type="hidden" name="hidden_name"  id="hidden_name" value="<?=$data['name']?>" />  
		   <input type="hidden" name="hidden_price" id="hidden_price" value="<?=$data['price']?>" />
		   <input type="hidden" name="hidden_discount" id="hidden_discount" value="<?=$data['discount']?>" />
		   <input type="hidden" name="command" id="command" value="add" />
		<ul>
		<h3><?=$data['name']?>
		</h3>
		
		</ul>
		<h3>
		<span class="main-color txt-b"><?=number_format($data['price']-$data['price']*$data['discount']/100)?> <u>đ</u></span>
		<span class="<?=$unprice?>"><b><?=$data['price']?><u>đ</u></b></span></h3>
		
		
		
		
		<span>SL:
		<a href=""><i class="fa fa-minus" aria-hidden="true"></i></a>
			<select name="quantity" >
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>
		<a href=""><i class="fa fa-plus" aria-hidden="true"></i></a>
		</span>
		
		<div>
		<button type="submit" class="btn main-bg white"><i class="fa fa-shopping-cart"></i>Đặt Hàng</button>
				
		<a href="tel:<?=$info['hotline']?>" class="btn "><span><i class="fa fa-mobile" aria-hidden="true"></i>Gọi điện tư vấn
				  </span></a>
				  
		</div>
		
		<p>
		Mã: <?=$data['sku']?>
		</p>
		<p>
		Category: <?=$db->id_to_name("db_tblcat",$data['idcat'])?>
		</p>
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
	</div>
	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>