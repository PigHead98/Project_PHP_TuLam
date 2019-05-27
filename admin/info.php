<?//làm ajax
$db_table=$db_prifix.'info';
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
<th>Logo</th>
<th>name</th>
<th>date</th>
<th>keyword</th>
<th>description</th>
<th>content</th>
<th>domain</th>
<th>sitename</th>
<th>phone</th>
<th>address</th>
<th>email</th>
<th>usergmail</th>
<th>passwordgmail</th>
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
<td>'.img_display($row['img'],50).'</td>
<td>'.$row['name'].'</td>
<td>'.date('d-m-Y',$row['date']).'</td>
<th>'.$row['keyword'].'</th>
<th>'.$row['description'].'</th>
<th>'.$row['content'].'</th>
<th>'.$row['domain'].'</th>
<th>'.$row['sitename'].'</th>
<th>'.$row['phone'].'</th>
<th>'.$row['address'].'</th>
<th>'.$row['email'].'</th>
<th>'.$row['usergmail'].'</th>
<th>'.$row['passwordgmail'].'</th>

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
		$description=$db->POST('description');
		$name=$db->POST('name');
		$img=upload_file1('img');
		$keyword=$db->POST('keyword');
		$content=$db->POST('content');
		$domain=$db->POST('domain');
		$sitename=$db->POST('sitename');
		$phone=$db->POST('phone');
		$hotline=$db->POST('hotline');
		$address=$db->POST('address');
		$email=$db->POST('email');
		$facebook=$db->POST('facebook');
		$googleplus=$db->POST('googleplus');
		$youtube=$db->POST('youtube');
		$twitter=$db->POST('twitter');
		$instagram=$db->POST('instagram');
		$facebookapi=$db->POST('facebookapi');
		$googleapi=$db->POST('googleapi');
		$chatapi=$db->POST('chatapi');
		$usergmail=$db->POST('usergmail');
		$passwordgmail=$db->POST('passwordgmail');
		$map=$db->POST('map');
		$date=time();
		$sql="
		INSERT INTO $db_table( `name`, `keyword`, `content`,`img`,`description`,
		`domain`, `sitename`, `phone`, `hotline`, `address`, `email`, `facebook`,
		`googleplus`, `youtube`, `twitter`, `instagram`, `facebookapi`, `googleapi`,
		`chatapi`, `usergmail`, `passwordgmail`, `map`, `date`) 
		VALUES 
		('$name','$keyword','$content','$img','$description',
		'$domain','$sitename', '$phone','$hotline', '$address', '$email','$facebook',
		'$googleplus','$youtube', '$twitter','$instagram','$facebookapi','$googleapi',
		'$chatapi','$usergmail', '$passwordgmail','$map','$date')";
		
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
    <input type="keyword" class="form-control" id="keyword" name="keyword">
  </div>
  
  <div class="form-group">
    <label for="img">Logo</label>
    <input type="file" class="form-control" id="img" name="img">
  </div>
  <div class="form-group">
    <label for="domain">domain:</label>
    <input type="domain" class="form-control" id="domain" name="domain">
  </div>  <div class="form-group">
    <label for="sitename">	sitename:</label>
    <input type="sitename" class="form-control" id="sitename" name="sitename">
  </div>  <div class="form-group">
    <label for="phone">phone:</label>
    <input type="phone" class="form-control" id="phone" name="phone">
  </div>  <div class="form-group">
    <label for="hotline">hotline:</label>
    <input type="hotline" class="form-control" id="hotline" name="hotline">
  </div>  <div class="form-group">
    <label for="address">address:</label>
    <input type="address" class="form-control" id="address" name="address">
  </div>  <div class="form-group">
    <label for="email">email:</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>  <div class="form-group">
    <label for="facebook">facebook:</label>
    <input type="facebook" class="form-control" id="facebook" name="facebook">
  </div>  <div class="form-group">
    <label for="googleplus">googleplus:</label>
    <input type="googleplus" class="form-control" id="googleplus" name="googleplus">
  </div>  <div class="form-group">
    <label for="youtube">youtube:</label>
    <input type="youtube" class="form-control" id="youtube" name="youtube">
  </div>  <div class="form-group">
    <label for="twitter">twitter:</label>
    <input type="twitter" class="form-control" id="twitter" name="twitter">
  </div>  <div class="form-group">
    <label for="instagram">instagram:</label>
    <input type="instagram" class="form-control" id="instagram" name="instagram">
  </div>  <div class="form-group">
    <label for="facebookapi">facebookapi:</label>
    <input type="facebookapi" class="form-control" id="facebookapi" name="facebookapi">
  </div>  <div class="form-group">
    <label for="googleapi">googleapi:</label>
    <input type="googleapi" class="form-control" id="googleapi" name="googleapi">
  <div class="form-group">
    <label for="chatapi">chatapi:</label>
	<textarea name="chatapi" class="form-control" id="chatapi"></textarea>	
  </div>
  </div>  <div class="form-group">
    <label for="usergmail">usergmail:</label>
    <input type="usergmail" class="form-control" id="usergmail" name="usergmail">
  </div>  <div class="form-group">
    <label for="passwordgmail">passwordgmail:</label>
    <input type="passwordgmail" class="form-control" id="passwordgmail" name="passwordgmail">
  </div>  <div class="form-group">
    <label for="map">map:</label>
    <input type="map" class="form-control" id="map" name="map">
  <div class="form-group">
    <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"></textarea>	
  </div>
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
		$content=$db->POST('content');
		$domain=$db->POST('domain');
		$sitename=$db->POST('sitename');
		$phone=$db->POST('phone');
		$hotline=$db->POST('hotline');
		$address=$db->POST('address');
		$email=$db->POST('email');
		$facebook=$db->POST('facebook');
		$googleplus=$db->POST('googleplus');
		$youtube=$db->POST('youtube');
		$twitter=$db->POST('twitter');
		$instagram=$db->POST('instagram');
		$facebookapi=$db->POST('facebookapi');
		$googleapi=$db->POST('googleapi');
		$chatapi=$db->POST('chatapi');
		$usergmail=$db->POST('usergmail');
		$passwordgmail=$db->POST('passwordgmail');
		$map=$db->POST('map');
		$newimg=upload_file1('img');
		if($newimg=="")
			$img=$db->POST('oldimg');
		else
			$img=$newimg;

		$sql="
		update $db_table set 
		`name`='$name', 
		`keyword`='$keyword', 
		`img`='$img',
		`description`='$description',
		`content`='$content',
		`domain`='$domain', 
		`sitename`='$sitename', 
		`phone`='$phone', 
		`hotline`='$hotline', 
		`address`='$address', 
		`email`='$email', 
		`facebook`='$facebook',
		`googleplus`='$googleplus', 
		`youtube`='$youtube', 
		`twitter`='$twitter', 
		`instagram`='$instagram', 
		`facebookapi`='$facebookapi', 
		`googleapi`='$googleapi',
		`chatapi`='$chatapi', 
		`usergmail`='$usergmail', 
		`passwordgmail`='$passwordgmail', 
		`map`='$map'
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
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?=$row['name']?>">
  </div>
  <div class="form-group">
    <label for="keyword">Keyword:</label>
    <input type="keyword" class="form-control" id="keyword" name="keyword" value="<?=$row['keyword']?>">
  </div>
  
  <div class="form-group">
    <label for="img">Logo</label>
	<?=img_display($row['img'],30,0,1)?>
	<input type="" class="form-control" id="oldimg" name="oldimg" value="<?=$row['img']?>">
    <input type="file" class="form-control" id="img" name="img" >
  </div>
  <div class="form-group">
    <label for="domain">domain:</label>
    <input type="domain" class="form-control" id="domain" name="domain" value="<?=$row['domain']?>">
  </div>  <div class="form-group">
    <label for="sitename">	sitename:</label>
    <input type="sitename" class="form-control" id="sitename" name="sitename" value="<?=$row['sitename']?>">
  </div>  <div class="form-group">
    <label for="phone">phone:</label>
    <input type="phone" class="form-control" id="phone" name="phone" value="<?=$row['phone']?>">
  </div>  <div class="form-group">
    <label for="hotline">hotline:</label>
    <input type="hotline" class="form-control" id="hotline" name="hotline" value="<?=$row['hotline']?>">
  </div>  <div class="form-group">
    <label for="address">address:</label>
    <input type="address" class="form-control" id="address" name="address" value="<?=$row['address']?>"> 
  </div>  <div class="form-group">
    <label for="email">email:</label>
    <input type="email" class="form-control" id="email" name="email" value="<?=$row['email']?>">
  </div>  <div class="form-group">
    <label for="facebook">facebook:</label>
    <input type="facebook" class="form-control" id="facebook" name="facebook" value="<?=$row['facebook']?>">
  </div>  <div class="form-group">
    <label for="googleplus">googleplus:</label>
    <input type="googleplus" class="form-control" id="googleplus" name="googleplus" value="<?=$row['googleplus']?>">
  </div>  <div class="form-group">
    <label for="youtube">youtube:</label>
    <input type="youtube" class="form-control" id="youtube" name="youtube" value="<?=$row['youtube']?>">
  </div>  <div class="form-group">
    <label for="twitter">twitter:</label>
    <input type="twitter" class="form-control" id="twitter" name="twitter" value="<?=$row['twitter']?>">
  </div>  <div class="form-group">
    <label for="instagram">instagram:</label>
    <input type="instagram" class="form-control" id="instagram" name="instagram" value="<?=$row['instagram']?>">
  </div>  <div class="form-group">
    <label for="facebookapi">facebookapi:</label>
    <input type="facebookapi" class="form-control" id="facebookapi" name="facebookapi" value="<?=$row['facebookapi']?>">
  </div>  <div class="form-group">
    <label for="googleapi">googleapi:</label>
    <input type="googleapi" class="form-control" id="googleapi" name="googleapi" value="<?=$row['googleapi']?>">
  <div class="form-group">
    <label for="chatapi">chatapi:</label>
	<textarea name="chatapi" class="form-control" id="chatapi" ><?=$row['chatapi']?></textarea>	
  </div>
  </div>  <div class="form-group">
    <label for="usergmail">usergmail:</label>
    <input type="usergmail" class="form-control" id="usergmail" name="usergmail" value="<?=$row['usergmail']?>">
  </div>  <div class="form-group">
    <label for="passwordgmail">passwordgmail:</label>
    <input type="passwordgmail" class="form-control" id="passwordgmail" name="passwordgmail" value="<?=$row['passwordgmail']?>">
  </div>  <div class="form-group">
    <label for="map">map:</label>
    <input type="map" class="form-control" id="map" name="map" value="<?=$row['map']?>">
  <div class="form-group">
    <div class="form-group">
    <label for="description">Description:</label>
	<textarea name="description" class="form-control" id="description"><?=$row['description']?></textarea>	
  </div>
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