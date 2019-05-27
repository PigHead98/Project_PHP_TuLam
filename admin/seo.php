<?//làm ajax
$db_table=$db_prifix.'seo';
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
<th>Link</th>
<th>Name</th>
<th>Img</th>
<th>Status</th>
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
	

$rs.= '
<tr>
<td>'.$stt++.'</td>
<td>'.$row['link'].'</td>
<td>'.$row['name'].'</td>
<td>'.img_display($row['img'],50).'</td>



'.$status.'
<td><a href="index.php?cmd='.$cmd.'&act=edit&id='.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?cmd='.$cmd.'&act=del&id='.$row['id'].'&img='.$row['img'].'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
	if(isset($_POST['btnsub']))
	{
		$description=$db->POST('description');
		$name=$db->POST('name');
		$img=upload_file1('img');
		$keyword=$db->POST('keyword');
		$link=$db->POST('link');
		
		$sql="
		INSERT INTO $db_table( `name`, `keyword`,link, `img`,`description`) 
		VALUES 
		('$name','$keyword','$link','$img','$description')";
	
		if($db->myquery($sql))
		message('thành công',$cmd,'manager');
		else
		message('thất bại',$cmd,$act);
	}
	?>
<form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
 
  <div class="form-group">
    <label for="keyword">Keyword:</label>
    <textarea type="keyword" class="form-control" id="keyword" name="keyword" placeholder="mỗi keyword cách nhau bơi dấu ( , )"></textarea>
  </div>
  
  <div class="form-group">
    <label for="img">image</label>
    <input type="file" class="form-control" id="img" name="img">
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"></textarea>	
  </div>
  <div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" id="link" name="link" >
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
	if(isset($_POST['btnsub']))
	{
		$description=$db->POST('description');
		$name=$db->POST('name');
		$keyword=$db->POST('keyword');
		$link=$db->POST('link');
		
		$newimg=upload_file1('img');
		if($newimg=="")
			$img=$db->POST('oldimg');
		else
			$img=$newimg;

		$sql="
		update $db_table set 
		`name`='$name', 
		`keyword`='$keyword', 
		`link`='$link',
		`img`='$img',
		`description`='$description'
		
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
<form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data" >
  <div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" id="link" name="link" value="<?=$row['link']?>">
  </div>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?=$row['name']?>">
  </div>
  
  <div class="form-group">
    <label for="keyword">Keyword:</label>
    <textarea type="keyword" class="form-control" id="keyword" name="keyword" value="<?=$row['keyword']?>"></textarea>
  </div>
  
  <div class="form-group">
    <label for="img">image</label>
	<?=img_display($row['img'],30,0,1)?>
	<input type="" class="form-control" id="oldimg" name="oldimg" value="<?=$row['img']?>">
    <input type="file" class="form-control" id="img" name="img" >
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"><?=$row['description']?></textarea>	
  </div>
 

  <button type="submit" name="btnsub" class="btn btn-default">Submit</button>
</form>

<?	
}

?>