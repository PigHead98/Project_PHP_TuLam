<?//làm ajax
$db_table='db_tblorder_detail';
switch($act)
{case  "manager":
		manager();
		break;
case  "add":
		add();
		break;	
case  "del":
		del();
		break;	
case  "edit":
		edit();
		break;
case  "lock":
		check('status',1);
		break;	
case  "unlock":
		check('status',0);
		break;	
case  "unhot":
		check('hot',0);
		break;	
case  "hot":
		check('hot',1);
		break;					
case  "search":
		search();
		break;	
default: 
		manager();
}

function search()
{
	
}
function check($field_db,$status)
{
	global $cmd,$db,$db_table,$upload_dir,$act,$id;
	if($status==1)
	{
		$sql="update $db_table set $field_db=0 where id=$id";
	}
	else
	{	
		$sql="update $db_table set $field_db=1 where id=$id";
	}
	$result=$db->myquery($sql);
	if($db->affected_rows==1)
	message('thành công',$cmd,'manager');
	else
	message('thất bại',$cmd,'manager');
	
}
function manager()
{
global $cmd,$db,$db_table,$upload_dir,$act,$paper;
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

<th>Edit</th>
<th>Del</th>
</tr>
</thead>
<tbody>
';
$stt=1;
$sql="select * from $db_table";

$total=$db->num_row($db->myquery($sql));//Tổng số dòng lấy về từ database
$page = (int)$db->get('page',1);//Lấy số trang hiện hành
$setLimit =$paper;//số dòng trên 1 trang, ví dụ 2 dòng trên 1 trang
$pageLimit = ($page * $setLimit) - $setLimit;//xác định số trang từ tổng số dòng lấy về từ biến $total
$result=$db->myquery($sql." LIMIT ".$pageLimit." , ".$setLimit);
while($row=$db->fetch_row($result))
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
<td><a href="index.php?cmd='.$cmd.'&act=edit&id='.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?cmd='.$cmd.'&act=del&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
</tr>';
}
//&img='.$row['img'].' giúp truy suất link ảnh... 1 cách xóa khác
$rs.='
</tbody>
</table>
'.displayPaginationBelow($cmd,$total,$setLimit,$page).'
</div>
</div>
'

;
echo $rs;

}

	?>

<?	

function del()
{	global $cmd,$db,$db_table,$upload_dir,$id,$thumb_dir;
	$sql="select img FROM $db_table WHERE id=$id ";//cách 1
	$result=$db->myquery($sql);
	if($db->num_row($result)==1)
	{
		$row=$db->fetch_row($result);
		$img=$row['img'];
		$sql="DELETE FROM $db_table WHERE id=$id";
		$result=$db->myquery($sql);
		if($db->affected_rows!=0)
		{
			if(file_exists($upload_dir.$img))unlink($upload_dir.$img);
			if(file_exists($thumb_dir.$img))unlink($thumb_dir.$img);
			message('thành công',$cmd,'manager');
		}
		else
			message('thất bại',$cmd,$act);
	}
	else
		message('thất bại',$cmd,$act);
/*cách 2
	$sql="DELETE FROM $db_table WHERE id=$id and price<>'".$_SESSION['login']['price']."'";
	$result=$db->myquery($sql);
	if($db->affected_rows!=0)
		{	$img=$db->get['img'];
			if(file_exists($upload_dir.$img))unlink($upload_dir.$img);
			if(file_exists($thumb_dir.$img))unlink($thumb_dir.$img);
			message('thành công',$cmd,'manager');
		}
		else
			message('thất bại',$cmd,$act);
*/
	
}
											
	?>