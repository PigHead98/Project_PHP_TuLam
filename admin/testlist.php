<?function list_order_detail($db_table,$idorder)
{
	$rs="";
$sql="select * from $db_table where id=$idorder";
$result=$this->myquery($sql);	
while($row=$this->fetch_row($result))
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
}

function list_order($db_table,$idcus)
{
$sql="select * from $db_table where id=$idcus";
$result=$this->myquery($sql);	
while($row=$this->fetch_row($result))
{
	if($row['status']==1)
	$status='<td><a title="Đã thanh toán" href="index.php?cmd='.$cmd.'&act=lock&id='.$row['id'].'" class="btn btn-success"><i class="fa fa-unlock"></i></a></td>';
	else
	$status='<td><a title="Chưa thanh toán" href="index.php?cmd='.$cmd.'&act=unlock&id='.$row['id'].'" class="btn btn-default"><i class="fa fa-lock"></i></a></td>';

//lỗi ở mã khách hàng
$rs.= '
<tr>
<td>'.($stt++).'</td>
<td><a href='$this->list_order_detail('db_tblorder_detail',$row['id'])'>'.$row['id'].'</a></td>
<td>'.$row['idcustomer'].'</td>
<td>'.$row['total'].'</td>
<td>'.$row['requirement'].'</td>
<td>'.$row['payment'].'</td>
<td>'.date('d-m-Y',$row['date']).'</td>
<td>'.$row['sku'].'</td>
<td>'.$row['available'].'</td>


'.$status.'
<td><a href="index.php?cmd='.$cmd.'&act=edit&id='.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?cmd='.$cmd.'&act=del&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
</tr>';
}
}
function list_cus($db_table,$id)
{
$sql="select * from $db_table";
$result=$this->myquery($sql);	
while($row=$this->fetch_row($result))
{
	{
	if($row['status']==1)
	$status='<td><a title="đang hoạt động" href="index.php?cmd='.$cmd.'&act=lock&id='.$row['id'].'" class="btn btn-success"><i class="fa fa-unlock"></i></a></td>';
	else
	$status='<td><a title="bị khóa" href="index.php?cmd='.$cmd.'&act=unlock&id='.$row['id'].'" class="btn btn-default"><i class="fa fa-lock"></i></a></td>';


$rs.= '
<tr>
<td>'.($stt++).'</td>
<td><a href='$this->list_order('db_tblcustomer',$row['id'])'>'.$row['id'].'</a></td>
<td>'.$row['name'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['address'].'</td>


'.$status.'
<td><a href="index.php?cmd='.$cmd.'&act=edit&id='.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?cmd='.$cmd.'&act=del&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
</tr>';
}
}


}
?>