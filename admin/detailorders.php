<?php
require("config/init.php");

?>
<!DOCTYPE html>
<html lang="en-vn">
<head>
<title>Đăng nhập vào trang quản trị</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content=""/><script src="<?=$root_dir?>admin/js/jquery-3.2.1.min.js"></script>
<script src="<?=$root_dir?>admin/api/bootstrap/js/bootstrap.min.js" ></script>
<link rel="stylesheet" href="<?=$root_dir?>admin/api/bootstrap/css/bootstrap.min.css" >
<link rel="stylesheet" href="<?=$root_dir?>admin/api/bootstrap/css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="<?=$root_dir?>admin/css/font-awesome.css">
<link rel="stylesheet" href="<?=$root_dir?>admin/css/mystyle.css" type="text/css" media="all" />

<link rel="stylesheet" href="api/menu/css/styles.css">
	
<script src="<?=$root_dir?>js/jscolor.js"></script>
<script src="<?=$root_dir?>js/jscolor.min.js"></script>
<script src="js/script.js"></script>
</head>
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
        <h4 class="modal-title">Thông tin sản phẩm sac</h4>
      </div>
      <div class="modal-body">
       <div class=" w100">
	   
<?//làm ajax
$db_table='db_tblorder_detail';
global $cmd,$db,$db_table,$upload_dir,$act,$paper,$id;
$rs='<div class="col-sm-12">
<div class="table-responsive">          
<table class="table">
<thead class="main-color">
<tr>
<th>STT</th>

<th>Mã đặt hàng</th>
<th>Mã sản phẩm</th>
<th>Name</th>
<th>Giá</th>
<th>Giảm giá</th>
<th>Số lượng</th>
<th>Subtotal</th>
<th>Del</th>
</tr>
</thead>
<tbody>
';
$stt=1;
$id=$db->post('id');
$sql_order="select id from db_tblorders where id=$id";
$result_order=$db->myquery($sql_order);

while($row_order=$db->fetch_row($result_order))
{	
$idorder=$row_order['id'];
$sql="select * from $db_table where idorder=$idorder";
$result=$db->myquery($sql);
$row=$db->fetch_row($result);

$total=$db->num_row($result);//Tổng số dòng lấy về từ database
if($total>0)
{
$rs.= '
<tr>
<td>'.($stt++).'</td>
<td>'.$row['idorder'].'</td>
<td>'.$row['idproduct'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['price'].'</td>
<td>'.$row['discount'].'</td>
<td>'.$row['quantity'].'</td>
<td>'.$row['subtotal'].'</td>

<td><a href="index.php?cmd='.$cmd.'&act=del&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
</tr>';
}
//&img='.$row['img'].' giúp truy suất link ảnh... 1 cách xóa khác
$rs.='
</tbody>
</table>
</div>
</div>
'

;
echo $rs;
}?>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
</div>
	</div></div>
