<?

if(isset($_POST["sbmpay"]))
{	
	$phone=$db->post('phone');
	$email=$db->post('email');
	$address=$db->post('address');
	$name_cus=$db->post('name');
	$requirement=$db->post('requirement');
	$mothedpay=$db->post('mothedpay');
	$sku=$db->post('sku_order');//kiemtra
	$sql_insert_customer="INSERT INTO ".$db_prifix."customer( `email`,`name`,`requirement`, `address`,`phone`) 
		VALUES 
		('$email','$name_cus','$requirement','$address','$phone')";
	if($db->myquery($sql_insert_customer))
	{
		$idcustomer=$db->last_insert_id();//lấy id vừa đc sinh ra
		$total=$shopping->total_after_discount_shopping_cart();
		$payment=$mothedpay;
		
		$date=time();
		
		$sql_insert_order="INSERT INTO ".$db_prifix."orders
		(`idcustomer`,`total`,`requirement`, `payment`,`date`,`sku`) VALUES 
		('$idcustomer','$total','$requirement','$payment','$date','$sku')";
		if($db->myquery($sql_insert_order))
		{	$verify_item=1;
			$idorder=$db->last_insert_id();
			foreach($_SESSION['shopping_cart'] as $key =>$values)
			{	
				$idproduct=$values['item_id'];
				$name=$values['item_name'];
				$price=$values['item_price'];
				$quantity=$values['item_quantity'];
				$discount=$values['item_discount'];
				$subtotal=number_format($values['item_price']*$values['item_quantity']-$values['item_price']*$values['item_quantity']*$values['item_discount']/100);
				$sql_insert_order_detail="INSERT INTO ".$db_prifix."order_detail( `idorder`,`idproduct`,`name`, `price`,`discount`,`subtotal`,`quantity`) 
				VALUES 
				('$idorder','$idproduct','$name','$price','$discount','$subtotal','$quantity')";
				if($db->myquery($sql_insert_order_detail))
				$verify_item=1;
				else
				$verify_item=0;	
			}
			if($verify_item=1)
			{
				$subject="Thông báo từ ".$info['sitename'];
				$message=$shopping->list_checkout_mail_shopping_cart($sku,$name_cus,$phone,$email,$address,$payment,$requirement);
				unset($_SESSION['shopping_cart']);
				if($db->sent_mail($email,$subject,$message,$name))
				message('thành công.Hãy kt mail',$root_dir);
				else
				message('thành công',$root_dir);
			}
		}
	}
}
$sku_order=time();//style

?>
<main>
	<section class="path txt-b">
	<a href="<?=$root_dir?>trang-chu.html"><i class="fa fa-home"></i>Trang chủ</a>
	<a href=""><i class="fa fa-angle-right"></i>Chi tiết đơn hàng</a>
	</section>
	<section class="billing">
			<div class="table-responsive">          
				
					<?=$shopping->list_checkout_shopping_cart();?>
					
			<form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="sku_order" value=<?=$sku_order?>>
				<div class="row">
				<div class="info col-sm-6 ">
				<section class="path txt-b">
				<H3>THÔNG TIN KHÁCH HÀNG</H3>
				</section><br>
					  <div class="form-group thanhtoan">
						<label for="pwd">Họ tên:</label>
						<input type="text" class="form-control" name="name" id="pwd" required>
					  </div>
					  <div class="form-group thanhtoan">
						<label for="phone">Số điện thoại:</label>
						<input type="number" class="form-control" name="phone" id="phone" required>
					  </div>
					  
					  <div class="form-group thanhtoan">
						<label for="email">email:</label>
						<input type="email" class="form-control" name="email" id="email" required>
					  </div>
					  <div class="form-group thanhtoan">
						<label for="address">Địa chỉ:</label>
						<input type="text" class="form-control" name="address" id="address" required>
					  </div>
					   <div class="form-group thanhtoan">
						<label for="requirement">Yêu cầu:</label>
						<textarea name="requirement" class="form-control" id="requirement"></textarea>	
					  </div>
					 <!--<div class="checkbox">
						<label><input type="checkbox"> </label>
					  </div>-->

				 
				  </div>
				  <div class="info col-sm-6">
				  <section class="path txt-b ">
				  <div >
				  <H3>MÃ ĐƠN HÀNG</H3>
				  </div>
				  <div>
				  <span type="button" class="btn btn-default"><?=$sku_order;?></span>
				  </div>
				<H3>PHƯƠNG THỨC THANH TOÁN</H3>
				 <div class="radio">
						<label><input type="radio" name="mothedpay" value="Tiền Mặt" checked>Tiền Mặt</label>
					  </div>
				 <div class="radio">
						<label><input type="radio" name="mothedpay" value="Thẻ ViSa">Thẻ ViSa</label>
					  </div>

				</section>
				 <button type="submit" name="sbmpay" class="btn btn-default">Submit</button>
			</div>
			</div>
	</form>
			</div>
</section>
	<?=$db->cat_produce('cat');?>
	
	<div></div>
	<div></div>
	<div></div>
	<div></div>
	</section>
	</main>
