<?//làm ajax
$db_table=$db_prifix.'cattask';
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

<th>Cat</th>


<th>Status</th>
<th>hot</th>
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
	if($row['status']==1)
	$status='<td><a title="đang hoạt động" href="index.php?cmd='.$cmd.'&act=lock&id='.$row['id'].'" class="btn btn-success"><i class="fa fa-unlock"></i></a></td>';
	else
	$status='<td><a title="bị khóa" href="index.php?cmd='.$cmd.'&act=unlock&id='.$row['id'].'" class="btn btn-default"><i class="fa fa-lock"></i></a></td>';
	if($row['hot']==1)
	$hot='<td><a title="unhot" href="index.php?cmd='.$cmd.'&act=hot&id='.$row['id'].'" class="btn btn-default"><i class="fa fa-fire"></i></a></td>';
	else
	$hot='<td><a title="hot" href="index.php?cmd='.$cmd.'&act=unhot&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-fire"></i></a></td>';


$rs.= '
<tr>
<td>'.$stt++.'</td>

<td>'.$row['name'].'</td>

'.$status.$hot.'
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
function add()
{	
	global $cmd,$db,$db_table,$upload_dir,$act;
	if(isset($_post['btnsub']))
	{
	
		$name=$db->post('name');
		$link=$db->post('link');
		
		
	
		$sql="
		INSERT INTO $db_table( `name`, `link`) 
		VALUES 
		('$name','$link')";
		
		if($db->myquery($sql))
		message('thành công',$cmd,'manager');
		else
		message('thất bại',$cmd,$act);
	}
	?>
<form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" id="link" name="link">
  </div>
  </div>

  <button type="submit" name="btnsub" class="btn btn-default">Submit</button>
</form>
<?	
}
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
	$sql="DELETE FROM $db_table WHERE id=$id and keyword<>'".$_SESSION['login']['keyword']."'";
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
function edit()
{
	global $cmd,$db,$db_table,$upload_dir,$act,$id;
	if(isset($_post['btnsub']))
	{
		
		$name=$db->post('name');
		
		$sql="
		update $db_table set 
		`name`='$name', 
		
		
		`link`='$link'
		where id=$id
		";
		
		if($db->myquery($sql))
		message('thành công',$cmd,'manager');
		else
		message('thất bại',$cmd,$act);
	}
	$sql="select * from $db_table where id=$id";
	$result=$db->myquery($sql);
	$row=$db->fetch_row($result);
	?>
<form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data" >
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?=$row['name']?>">
  </div>
 
  <div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" id="link" name="link" value="<?=$row['link']?>">
  </div>
 

  <button type="submit" name="btnsub" class="btn btn-default">Submit</button>
</form>

<?	
}

?>