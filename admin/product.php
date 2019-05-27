<?//làm ajax
$db_table='db_tblproduct';
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
<th>Ảnh</th>
<th>Name</th>
<th>Cat</th>
<th>Màu</th>
<th>Size</th>
<th>Giá</th>
<th>Giảm giá</th>
<th>Date</th>
<th>keyword</th>
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
	$hot='<td><a title="unhot" href="index.php?cmd='.$cmd.'&act=hot&id='.$row['id'].'" class="btn btn-danger"><i class="fa fa-fire"></i></a></td>';
	else
	$hot='<td><a title="hot" href="index.php?cmd='.$cmd.'&act=unhot&id='.$row['id'].'" class="btn btn-default"><i class="fa fa-fire"></i></a></td>';


$rs.= '
<tr>
<td>'.$stt++.'</td>
<td>'.img_display($row['img'],50).'</td>
<td>'.$row['name'].'</td>
<td>'.$db->id_to_name("db_tblcat",$row['idcat']).'</td>
<th>'.$row['color'].'</th>
<th>'.$row['size'].'</th>
<th>'.$row['price'].'</th>
<th>'.$row['discount'].'</th>
<td>'.date('d-m-Y',$row['date']).'</td>
<th>'.$row['keyword'].'</th>

'.$status.$hot.'
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
		$keyword=$db->post('keyword');
		$cat=$db->post('cat');
		$description=$db->post('description');
		$name=$db->post('name');
		$link=locdau($name);
		$color1=$db->post('color1');$color2=$db->post('color2');$color3=$db->post('color3');$color4=$db->post('color4');
		$color=$color1.";".$color2.";".$color3.";".$color4;
		
		$size=$db->post('size');
		$img=upload_file('img');
		$price=$db->post('price');
		$discount=$db->post('discount');
		$content=$db->post('content');
		$date=time();
		$sku=1;
		$sql="
		INSERT INTO $db_table( `color`,`size`,`date`,`idcat`,`name`,`link`, `price`, `content`,`sku`, `img`,`description`,`discount`,`keyword`) 
		VALUES 
		('$color','$size','$date','$cat','$name','$link','$price','$content','$sku','$img','$description','$discount','$keyword')";
	//echo $sql;die();
		if($db->myquery($sql))
		message('thành công',$cmd,'manager');
		else
		message('thất bại',$cmd,$act);
	}
	?>
<form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Cat</label>
	<?=$db->list_cat()?>
    </div>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
	<div class="form-group">
    <label for="color">Màu</label>
	<input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color1">
  <input value="" class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color2">
	<input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color3">
  <input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color4">
	
  </div>
 <div class="form-group">
    <label for="size">Size</label>
    <input type="text" class="form-control" id="size" name="size" placeholder="ngăn cách bởi dấu ';'">
  </div>
  <div class="form-group">
    <label for="price">Giá:</label>
    <input type="price" class="form-control" id="price" name="price" placeholder="nhập số nguyên">
  </div>
  <div class="form-group">
    <label for="discount">Giảm Giá:</label>
    <input type="discount" class="form-control" id="discount" name="discount" placeholder="1 đến 99">
  </div>
  <div class="form-group">
    <label for="keyword">keyword</label>
    <input type="" class="form-control" id="keyword" name="keyword" >
  </div>
  <div class="form-group">
    <label for="img">image</label>
	<input type="file" class="form-control" id="img" name="img[]" multiple >
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"></textarea>	
  </div>
  <div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" class="form-control" id="content"></textarea>	
	<script>

			CKEDITOR.replace( 'content' );

	</script>
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
function edit()
{
	global $cmd,$db,$db_table,$upload_dir,$act,$id;
	if(isset($_POST['btnsub']))
	{
		$keyword=$db->post('keyword');
		$cat=$db->post('cat');
		$description=$db->post('description');
		$name=$db->post('name');
		$link=locdau($name);
		$price=$db->post('price');
		$content=$db->post('content');
		$color1=$db->post('color1');$color2=$db->post('color2');$color3=$db->post('color3');$color4=$db->post('color4');
		$color=$color1.";".$color2.";".$color3.";".$color4;
		$size=$db->post('size');
		$sku=$db->post('sku');
		$discount=$db->post('discount');
		$newimg=upload_file('img');
		if($newimg=="")
			$img=$db->post('oldimg');
		else
			$img=$newimg;

		$sql="
		update $db_table set 
		`color`='$color',
		`size`='$size',
		`keyword`='$keyword',
		`idcat`='$cat',
		`name`='$name', 
		`link`='$link', 
		`price`='$price', 
		`sku`='$sku', 
		`img`='$img',
		`description`='$description',
		`content`='$content',
		`discount`='$discount'
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
<form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
  <div class="form-group">
  <label for="name">Cat</label>
	<?=$db->list_cat("db_tblcat",$row['idcat'])?>
    </div>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?=$row['name']?>">
  </div>
 <div class="form-group">
    <label for="color">Màu</label>
	<input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color1">
  <input value="" class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color2">
	<input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color3">
  <input value=""  class="jscolor {width:101, padding:0, shadow:false,
    borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" name="color4">
  </div>
 <div class="form-group">
    <label for="size">Size</label>
    <input type="text" class="form-control" id="size" name="size" value="<?=$row['size']?>">
  </div>
  <div class="form-group">
    <label for="keyword">keyword</label>
    <input type="" class="form-control" id="keyword" name="keyword" value="<?=$row['keyword']?>">
  </div>
  <div class="form-group">
    <label for="price">Giá:</label>
    <input type="price" class="form-control" id="price" name="price" value="<?=$row['price']?>">
  </div>
  <div class="form-group">
    <label for="discount">Giảm Giá:</label>
    <input type="discount" class="form-control" id="discount" name="discount" value="<?=$row['discount']?>">
  </div>
  <div class="form-group">
    <label for="img">image</label>
	<?=img_display($row['img'],30,0,0)?>
	<input type="" class="form-control" id="oldimg" name="oldimg" value="<?=$row['img']?>">
    <input type="file" class="form-control" id="img" name="img[]" multiple >
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"><?=$row['description']?></textarea>	
  </div>
  <div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" class="form-control" id="content"><?=$row['content']?></textarea>	
	<script>

			CKEDITOR.replace( 'content' );

	</script>
  </div>

  <button type="submit" name="btnsub" class="btn btn-default">Submit</button>
</form>

<?	
}

?>



