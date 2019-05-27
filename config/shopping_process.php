<?
	class shopping extends db
	{	 
	function __construct($host, $user, $password, $database) 
	{
		parent::__construct($host, $user, $password, $database);
		$command=$this->post("command");
		if($command=="add")  
		{	
		echo '<script>alert("Item Already Added")</script>';  
			  if(isset($_SESSION["shopping_cart"]))  
			  {  
				   $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
				   if(!in_array($this->post("id"), $item_array_id))  
				   {  
						$count = count($_SESSION["shopping_cart"]);  
						$item_array = array(  
							 'item_id'=>$this->post("id"),  
							 'item_name'=>$this->post("hidden_name"),  
							 'item_price'=>$this->post("hidden_price"),  
							 'item_quantity'=>$this->post("quantity"),
							 'item_color'=>$this->post("hidden_color"),   
							'item_size'=>$this->post("hidden_size"),
							 'item_discount'=>$this->post("hidden_discount")  
						);  
						$_SESSION["shopping_cart"][$count] = $item_array;  
				   }  
				   else  
				   {  	
						echo '<script>alert("Item Already Added");window.location="'.$root_dir.'"</script>';   
				   }  
			  }  
			  else  
			  {  
				   $item_array = array(  
						'item_id'=>$this->post("id"),  
						'item_name'=>$this->post("hidden_name"),  
						'item_price'=>$this->post("hidden_price"),
						'item_color'=>$this->post("hidden_color"),   
						'item_size'=>$this->post("hidden_size"), 						
						'item_quantity'=>$this->post("quantity")  ,
						 'item_discount'=>$this->post("hidden_discount") 
				   );  
				   $_SESSION["shopping_cart"][0] = $item_array;  
			  }  
		}
		elseif($command=="update")  
		{		$count = count($_SESSION["shopping_cart"]); 
			   foreach($_SESSION["shopping_cart"] as $keys => $values)  
			   {  	$update_quatity=$values["item_quantity"]+$this->post("quantity");
					if($update_quatity>0 and $update_quatity<=100)
					{
						if($values["item_id"] == $this->post("id"))  
						{ 
						$item_array = array(  
							 'item_id'=>$values["item_id"],  
							 'item_name'=>$values["item_name"],  
							 'item_price'=>$values["item_price"], 
							'item_color'=>$values["item_color"],  
							 'item_size'=>$values["item_size"],
							 'item_quantity'=>$update_quatity,
							  'item_discount'=>$values["item_discount"]
							  
							 
						);
						$_SESSION["shopping_cart"][$keys] = $item_array;
						break;
						}
					}
					else
					{
					 echo '<script>alert("Số lượng tối thiểu 1 và nhiều nhất là 100");window.location="'.$root_dir.'"</script>';  
					}
			   }
		} 
		elseif($command=="delete")  
		{    
		   foreach($_SESSION["shopping_cart"] as $keys => $values)  
		   {  
				if($values["item_id"] == $this->post("id"))  
				{  
					 unset($_SESSION["shopping_cart"][$keys]);  
					 echo '<script>alert("Item Removed");window.location="'.$root_dir.'"</script>';    
				}  
		   }   
		}  


		 elseif($command=="clear")  
		{    
		   foreach($_SESSION["shopping_cart"] as $keys => $values)  
		   {  
					 unset($_SESSION["shopping_cart"][$keys]);  
					   
		   }   
		   echo '<script>alert("Item Removed");window.location="'.$root_dir.'"</script>';  
		}
		 //var_dump($_SESSION["shopping_cart"]);
		}

	function count_item_shopping_cart()
		{
			isset($_SESSION['shopping_cart'])?$count=count($_SESSION['shopping_cart']):$count=0;
			return $count;
		}
		function total_shopping_cart_one()
		{
			$total=0;
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$total=$values['item_price']*$values['item_quantity']-$values['item_price']*$values['item_quantity']*$values['item_discount']/100;
			}
			return $total;
		}
		function total_shopping_cart()
		{
			$total=0;
			if(isset($_SESSION['shopping_cart']))
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$total=$total+$values['item_quantity']*$values['item_price'];
			}
			return $total;
		}
		function total_after_discount_shopping_cart()
		{
			$total=0;
			if(isset($_SESSION['shopping_cart']))
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$total=$total+$values['item_quantity']*$values['item_price']-($values['item_quantity']*($values['item_price']*$values['item_discount']/100));
				
			}
			return $total;
		}
		function list_item_shopping_cart($idmodal)
		{	global $root_dir;
			$resual="";$stt=1;
			if(isset($_SESSION['shopping_cart']))
			{
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$resual.='
						  <tr>
							<td>'.($stt++).'</td>
							<td><a href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$this->item_img_shopping_cart($values['item_id']).'</a></td>
							<td ><a style="width:200px!important" href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$values['item_name'].'</a></td>
							<td><span style="background:#'.$values['item_color'].';padding:8px 16px"></span></td>
							<td><span style="padding:8px 16px">'.$values['item_size'].'</span></td>
							<td>'.$values['item_quantity'].'</td>
							<td>'.number_format($values['item_price']*$values['item_quantity']).'</td>
							<td>'.$values['item_discount'].'%</td>
							<td><a href="#" class="btn btn-success" onclick="update('.$values['item_id'].',1)">+1</a></td>
							<td><a href="#" class="btn btn-info" onclick="update('.$values['item_id'].',-1)">-1</a></td>
							<td><a href="#" class="btn btn-danger" onclick="del('.$values['item_id'].')"><i class="fa fa-trash-o"></i></a></td>
						  </tr>
						  
						</tbody>';
			}
			}
			$rs='
				<div id="'.$idmodal.'" class="modal fade" role="dialog">
			  <div class="modal-dialog wShop">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thông tin giỏ hàng</h4>
				  </div>
				  <div class="modal-body">
					<div class="col-sm-12">
						<div class=" table-responsive">      
				  <table class="table">
					<thead class="main-bg " >
					  <tr>
						<th>STT</th>
						<th>Ảnh</th>
						<th style="padding:0px 50px; line-height: 38px">Name</th>
						<th>Màu</th>
						<th>Size</th>
						<th>Quantity</th>
						<th>Giá</th>
						<th>Discount</th>
						<th>Tăng</th>
						<th>Giảm</th>
						<th>Xóa</th>
					  </tr>
					</thead>
					<tbody>
					'.$resual.'
					</tbody>
				  </table>
				</div>

				  </div>
				  <div class="modal-footer">
				  <a href="'.$root_dir.'thanh-toan-don-hang/"" class="btn btn-danger" >Thanh toán đơn hàng</a>
				  <a href="#"  class="btn btn-warning" onclick="clearall()" >Xóa toàn bộ đơn hàng</a>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
				  </div>
				</div>

			  </div>
			</div>
			';
			return $rs;
		}
	function list_checkout_shopping_cart()
		{	global $root_dir,$db_table;
			
		
			$resual="";$stt=1;
			if(isset($_SESSION['shopping_cart']))
			{
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$resual.='
						  
						<tr>
						<td>'.($stt++).'</td>
						<td><a href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$this->item_img_shopping_cart($values['item_id'],70).'</a></td>
						<td><a href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$values['item_name'].'</a></td>
						<td>35</td>
						<td>'.$values['item_quantity'].'</td>
						<td>'.$values['item_price'].'đ</td>
						<td>'.$values['item_discount'].'%</td>
						<td><a href="#" class="btn btn-success" onclick="update('.$values['item_id'].',1)">+1</a></td>
						<td><a href="#" class="btn btn-info" onclick="update('.$values['item_id'].',-1)">-1</a></td>
						<td><a href="#" class="btn btn-danger" onclick="del('.$values['item_id'].')"><i class="fa fa-trash-o"></i></a></td>
						<td><u>'.number_format($values['item_price']*$values['item_quantity']-$values['item_price']*$values['item_quantity']*$values['item_discount']/100).'đ</u></td>
						</tr>
					
						  
						';
			}
			}
			$rs='<table class="table">
				<thead>
						<tr>
						<th>#</th>
						<th>Hình ảnh</th>
						<th>Tên sản phẩm</th>
						<th>Mã sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th>Giảm giá</th>
						<th>Tăng</th>
						<th>Giảm</th>
						<th>Xóa</th>
						<th>Thành tiền</th>
						</tr>
					</thead>
					<tbody>
						'.$resual.'
					</tbody>
					</table>
					<a href="'.$root_dir.'danh-muc/tat-ca-san-pham-0.html"><button type="button" class="btn btn-primary  main-bg">Mua thêm sản phẩm khác</button></a>
				<a href="#"  class="btn btn-right btn-warning main-bg" onclick="clearall()" >Xóa hết giỏ hàng</a>
				<table>
				<form method="post">
					<div class="row">
					  <div class="col-sm-6"><h2 class="class-padding">Mã giảm giá</h2>
						
						  <div class="form-group">
							<label for="discount">Mã giảm giá (nếu có):</label>
							<input type="discount" class="form-control" id="discount">
						  </div>
						  <a href=""><button type="button" class="btn btn-primary main-bg">Kiểm Tra</button></a>
						
					  </div>
					  <div class="col-sm-6"><h2 class="class-padding">Tổng tiền thanh toán</h2>
					<div class="row row-border">
						  <div class="col-sm-8 txt-b">Chưa bao gồm Phí Vận Chuyển</div>
						  <div class="col-sm-4 txt-b">'.number_format($this->total_after_discount_shopping_cart()).'đ</div>
						  <div class="col-sm-8 txt-b main-color">Tổng</div>
						  <div class="col-sm-4 txt-b main-color">'.number_format($this->total_after_discount_shopping_cart()).'đ</div>
					</div>
						
					  </div>
					  
					</div>
				</form>
			';
			return $rs;
		}	
	function list_checkout_mail_shopping_cart($sku,$name_cus,$phone,$email,$address,$payment,$requirement)
		{	global $root_dir,$db_table;
			
			
			$resual="";$stt=1;
			if(isset($_SESSION['shopping_cart']))
			{
			foreach($_SESSION['shopping_cart'] as $key =>$values)//$values để lấy giá trị
			{
				$resual.='
						  
						<tr style="background:#fff">
						<td>'.($stt++).'</td>
						<td><a href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$this->item_img_shopping_cart($values['item_id'],50).'</a></td>
						<td><a href="'.$root_dir.'chi-tiet/'.locdau($values['item_name']).'-'.$values['item_id'].'.html">'.$values['item_name'].'</a></td>
						<td>35</td>
						<td>'.$values['item_quantity'].'</td>
						<td>'.$values['item_price'].'đ</td>
						<td>'.$values['item_discount'].'%</td>
						<td><u>'.number_format($values['item_price']*$values['item_quantity']-$values['item_price']*$values['item_quantity']*$values['item_discount']/100).'đ<u></td>
						</tr>
					
						  
						';
			}
			}
			$rs='<h4>Xin chào '.$name_cus.'</h4>
				<p>Sau đây là thông tin đặt hàng từ bạn</p>
				<table style="background:#444" cellpadding="5" cellspacing="1">
				<tr style="background:#fff"><td ><b>Thông tin đặt hàng từ:</b></td><td>'.$name_cus.'</td></tr>
				<tr style="background:#fff"><td><b>Điện thoại:</b></td><td>'.$phone.'</td></tr>
				<tr style="background:#fff"><td><b>Email:</b></td><td>'.$email.'</td></tr>
				<tr style="background:#fff"><td><b>Địa chỉ giao hàng:</b></td><td>'.$address.'</td></tr>
				<tr style="background:#fff"><td><b>Thanh toán :</b></td><td>'.$payment.'</td></tr>
				<tr style="background:#fff"><td><b>Yêu cầu :</b></td><td>'.$requirement.'</td></tr>
				</table>
				<div >
					<table  style="background:#444" cellpadding="5" cellspacing="1">
					<thead>
						<tr style="color:#fff">
						<th>#</th>
						<th>Hình ảnh</th>
						<th>Tên sản phẩm</th>
						<th>Mã sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th>Giảm giá</th>
						<th>Thành tiền</th>
						</tr>
					</thead>
					
					<tbody>
						'.$resual.'
					<tr style="background:#444" cellpadding="5" cellspacing="1">
					<tr>
						<td colspan="8" style="color:#fff"><b>Mã đơn hàng: </b> '.$sku.'</td>
					</tr>
					<tr>
						<td colspan="8" style="color:#fff"><b>Tổng tiền thanh toán:</b> '.number_format($this->total_after_discount_shopping_cart()).'đ</td>
					</tr>	
					</tr>
					</tbody>
					</table>
					<p>
				Xin chân thành cảm ơn.
				<br>
				Mọi thắc mắc xin liên hệ: 01634217575
				Hoặc email: reystay.rz@gmail.com
				</p>
			</div>
			';
			return $rs;
		}	
	function item_img_shopping_cart($id,$width=50)
	{	global $db_prifix;
		$sql="select img from ".$db_prifix."product where id=$id and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		$rs=$this->img_display($row['img'],$width,0);
		return $rs;
	}
	function img_display($name,$width="",$stt=0)
{
	global $absolute_dir;
	$each_mig_name=explode("|",$name);$rs="";
	for($i=0;$i<count($each_mig_name);$i++)
	{
	if($i==$stt)
	$rs="<img src='".$absolute_dir.$each_mig_name[$i]."' width='".$width."' alt='...'>";
	elseif($stt<0)
	$rs.="<img src='".$absolute_dir.$each_mig_name[$i]."'  width='".$width."' alt='...'>";
	}
	return $rs;
}
	
	}
	
?>