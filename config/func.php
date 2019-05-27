<?
/* Bên web*/
function message($title,$act='manager')
{	global $root_dir;
	echo "<script>alert('".$title."');document.location='".$act."trang-chu.html'</script>";
}

function upload_file($filename)
{	
	global $upload_dir,$max_file_size_upload,$thumb_width,$thumb_height,$thumb_dir;
	$target_dir=$upload_dir;
	$target_file = $target_dir . basename($_FILES[$filename]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$check = getimagesize($_FILES[$filename]["tmp_name"]);

if ($_FILES[$filename]["size"] > $max_file_size_upload)
{	
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" )
{	
    $uploadOk = 0;
}

if ($uploadOk == 0) 
{
	 $newfilename="";
	 return $newfilename;
} 
else
{	$newfilename=time().'.'.$imageFileType;
	if(move_uploaded_file($_FILES[$filename]["tmp_name"], $target_dir.$newfilename)) 
	{
		
		createThumbnail($target_dir.$newfilename, $small_dir.$newfilename, $thumb_width, $thumb_height,false);
		return $newfilename;
	} 
	else 
	{
	   $newfilename="";
		return $newfilename;
	}
}
} function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) 
{
    list($original_width, $original_height, $original_type) = getimagesize($filepath);
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);

    if ($original_type === 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    } else if ($original_type === 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    } else if ($original_type === 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    } else {
        return false;
    }

    $old_image = $imgcreatefrom($filepath);
    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

  
    if(is_array($background) && count($background) === 3) {
      list($red, $green, $blue) = $background;
      $color = imagecolorallocate($new_image, $red, $green, $blue);
      imagefill($new_image, 0, 0, $color);
    
    } else if($background === 'transparent' && $original_type === 3) {
      imagesavealpha($new_image, TRUE);
      $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagefill($new_image, 0, 0, $color);
    }

    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
    $imgt($new_image, $thumbpath);
}
function displayPaginationBelow($cmd,$total,$per_page,$page)
{
    $page_url="?cmd=".$cmd."&";
	$adjacents = "2"; 

	$page = ($page == 0 ? 1 : $page);  
	$start = ($page - 1) * $per_page;								
	
	$prev = $page - 1;							
	$next = $page + 1;
	$setLastpage = ceil($total/$per_page);
	$lpm1 = $setLastpage - 1;
	
	$setPaginate = "";
	if($setLastpage > 1)
	{	
		$setPaginate .= "<ul class='setPaginate pagination'>";
		$setPaginate .= "<li style='padding:0px 10px;line-height: 35px;'>".$page."/".$setLastpage."</li>";
		if ($setLastpage < 7 + ($adjacents * 2))
		{	
			for ($counter = 1; $counter <= $setLastpage; $counter++)
			{
				if ($counter == $page)
					$setPaginate.= "<li class='active'><a class='current_page'>$counter</a></li>";
				else
					$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
			}
		}
		elseif($setLastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$setPaginate.= "<li class='active'><a class='current_page'>$counter</a></li>";
					else
						$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
				}
				$setPaginate.= "<li class='dot'>...</li>";
				$setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
				$setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
			}
			elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
				$setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
				$setPaginate.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$setPaginate.= "<li class='active'><a class='current_page'>$counter</a></li>";
					else
						$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
				}
				$setPaginate.= "<li class='dot'>..</li>";
				$setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
				$setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
			}
			else
			{
				$setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
				$setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
				$setPaginate.= "<li class='dot'>..</li>";
				for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
				{
					if ($counter == $page)
						$setPaginate.= "<li class='active'><a class='current_page'>$counter</a></li>";
					else
						$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
				}
			}
		}
		
		if ($page < $counter - 1){ 
			$setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
			$setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
		}else{
			$setPaginate.= "<li><a class='current_page'>Next</a></li>";
			$setPaginate.= "<li><a class='current_page'>Last</a></li>";
		}

		$setPaginate.= "</ul>\n";		
	}
	return $setPaginate;
} 
function img_display($name,$width="",$stt=0)
{
	global $upload_dir,$small_dir;
	
	$each_mig_name=explode("|",$name);$rs="";//1111.png|2222.jpg
	for($i=0;$i<count($each_mig_name);$i++)
	{
	if($i==$stt)
	$rs="<img src='".$small_dir.$each_mig_name[$i]."' width='".$width."' alt='...'>";
	elseif($stt<0)
	$rs.="<img src='".$small_dir.$each_mig_name[$i]."'  width='".$width."' alt='...'>";
	}
	return $rs;
}
function color_display($name)
{$each_mig_name="";
	
	$each_mig_name=explode(";",$name);$rs="";//1111.png|2222.jpg
	for($i=0;$i<count($each_mig_name);$i++)
	{	if(trim($each_mig_name[$i])!="")
		{
		if((trim($each_mig_name[$i])!="FFFFFF" and $i>0) or (trim($each_mig_name[$i])=="FFFFFF" and $i==0))
		$rs.='<span  title="click để chọn màu" class="click_color" onclick="setcolor(\''.$each_mig_name[$i].'\')"  style="background:#'.$each_mig_name[$i].'"></span>';
		}
	}
	return $rs;
}
function size_display($name)
{$each_mig_name="";
	
	$each_mig_name=explode(";",$name);$rs="";//1111.png|2222.jpg
	for($i=0;$i<count($each_mig_name);$i++)
	{
		if(trim($each_mig_name[$i])!="")
		{
		$rs.='<a href="#" title="click để chọn size" class="click_size" onclick="setsize(\''.$each_mig_name[$i].'\')" >'.$each_mig_name[$i].'</a>';
		}
	}
	return $rs;
}


function zoom_slider($name)
{
	global $upload_dir,$root_dir;
	$stt=0;
	$small="small/";
	$thumb="thumb/";
	$large="";
	$each_mig_name=explode("|",$name);$rs="";
	
	for($i=0;$i<count($each_mig_name);$i++)
	{
	if(trim($each_mig_name[$i])!="")
	{		
	if($stt==$i)
	$rs="
<img class='img-zoom' id='zoom' src='".$upload_dir.$small.$each_mig_name[$i]."' 
	data-zoom-image='".$upload_dir.$large.$each_mig_name[$i]."' class='img-thumbnail' alt='...'>
	<div class='owl-carousel img-rounded' id='gallery1'>		 
	";	
	$rs.="
	
		<a class='carousel slide'
		href='' data-image='".$upload_dir.$small.$each_mig_name[$i]."' 
		data-zoom-image='".$upload_dir.$large.$each_mig_name[$i]."'>
		<img id='zoom' src='".$upload_dir.$small.$each_mig_name[$i]."' class='img-rounded' alt='...'>
		</a>
		";
	}
	}
	$rs.="</div>";
	return $rs;
}
function locdau($value)
	{
		$value = html_entity_decode($value);
		$value=trim($value);

		$value = str_replace(".","", $value);
		$value = str_replace("?","", $value);
		$value = str_replace("%","", $value);
		$value = str_replace(",","", $value);
		$value = str_replace("!","", $value);
		$value = str_replace("+","", $value);
		$value = str_replace("#","", $value);
		$value = str_replace("&","va", $value);
		$value = str_replace("—","", $value);
		$value = str_replace("“","", $value);
		$value = str_replace("”","", $value);
		$value = str_replace("|","", $value);
		$value = str_replace("\"","", $value);
		$value = str_replace("~","", $value);
		$value = str_replace("`","", $value);
		$value = str_replace("*","", $value);
		$value = str_replace("^","", $value);
		$value = str_replace("=","", $value);

		$value = str_replace("@","-", $value);
		$value = str_replace("/","-", $value);
		$value = str_replace("[","", $value);
		$value = str_replace("]","", $value);
		$value = str_replace(")","", $value);
		$value = str_replace("(","", $value);
		$value = str_replace(":","", $value);
		$value = str_replace("\"","", $value);
		$value = str_replace("–","",$value);
		$value = str_replace("_","-", $value);
		$value = str_replace("'","-", $value);
		$value = str_replace("&quot;","", $value);
		$value = str_replace(" ","-", $value);
		$value = str_replace("  ","-", $value);

		$value = str_replace("ấ", "a", $value);
		$value = str_replace("ầ", "a", $value);
		$value = str_replace("ẩ", "a", $value);
		$value = str_replace("ẫ", "a", $value);
		$value = str_replace("ậ", "a", $value);
		#---------------------------------A^
		$value = str_replace("Ấ", "A", $value);
		$value = str_replace("Ầ", "A", $value);
		$value = str_replace("Ẩ", "A", $value);
		$value = str_replace("Ẫ", "A", $value);
		$value = str_replace("Ậ", "A", $value);
		#---------------------------------a(
		$value = str_replace("ắ", "a", $value);
		$value = str_replace("ằ", "a", $value);
		$value = str_replace("ẳ", "a", $value);
		$value = str_replace("ẵ", "a", $value);
		$value = str_replace("ặ", "a", $value);
		#---------------------------------A(
		$value = str_replace("Ắ", "A", $value);
		$value = str_replace("Ằ", "A", $value);
		$value = str_replace("Ẳ", "A", $value);
		$value = str_replace("Ẵ", "A", $value);
		$value = str_replace("Ặ", "A", $value);
		#---------------------------------a
		$value = str_replace("á", "a", $value);
		$value = str_replace("à", "a", $value);
		$value = str_replace("ả", "a", $value);
		$value = str_replace("ã", "a", $value);
		$value = str_replace("ạ", "a", $value);
		$value = str_replace("â", "a", $value);
		$value = str_replace("ă", "a", $value);
		#---------------------------------A
		$value = str_replace("Á", "A", $value);
		$value = str_replace("À", "A", $value);
		$value = str_replace("Ả", "A", $value);
		$value = str_replace("Ã", "A", $value);
		$value = str_replace("Ạ", "A", $value);
		$value = str_replace("Â", "A", $value);
		$value = str_replace("Ă", "A", $value);
		#---------------------------------e^
		$value = str_replace("ế", "e", $value);
		$value = str_replace("ề", "e", $value);
		$value = str_replace("ể", "e", $value);
		$value = str_replace("ễ", "e", $value);
		$value = str_replace("ệ", "e", $value);
		#---------------------------------E^
		$value = str_replace("Ế", "E", $value);
		$value = str_replace("Ề", "E", $value);
		$value = str_replace("Ể", "E", $value);
		$value = str_replace("Ễ", "E", $value);
		$value = str_replace("Ệ", "E", $value);
		#---------------------------------e
		$value = str_replace("é", "e", $value);
		$value = str_replace("è", "e", $value);
		$value = str_replace("ẻ", "e", $value);
		$value = str_replace("ẽ", "e", $value);
		$value = str_replace("ẹ", "e", $value);
		$value = str_replace("ê", "e", $value);
		#---------------------------------E
		$value = str_replace("É", "E", $value);
		$value = str_replace("È", "E", $value);
		$value = str_replace("Ẻ", "E", $value);
		$value = str_replace("Ẽ", "E", $value);
		$value = str_replace("Ẹ", "E", $value);
		$value = str_replace("Ê", "E", $value);
		#---------------------------------i
		$value = str_replace("í", "i", $value);
		$value = str_replace("ì", "i", $value);
		$value = str_replace("ỉ", "i", $value);
		$value = str_replace("ĩ", "i", $value);
		$value = str_replace("ị", "i", $value);
		#---------------------------------I
		$value = str_replace("Í", "I", $value);
		$value = str_replace("Ì", "I", $value);
		$value = str_replace("Ỉ", "I", $value);
		$value = str_replace("Ĩ", "I", $value);
		$value = str_replace("Ị", "I", $value);
		#---------------------------------o^
		$value = str_replace("ố", "o", $value);
		$value = str_replace("ồ", "o", $value);
		$value = str_replace("ổ", "o", $value);
		$value = str_replace("ỗ", "o", $value);
		$value = str_replace("ộ", "o", $value);
		#---------------------------------O^
		$value = str_replace("Ố", "O", $value);
		$value = str_replace("Ồ", "O", $value);
		$value = str_replace("Ổ", "O", $value);
		$value = str_replace("Ô", "O", $value);
		$value = str_replace("Ộ", "O", $value);
		#---------------------------------o*
		$value = str_replace("ớ", "o", $value);
		$value = str_replace("ờ", "o", $value);
		$value = str_replace("ở", "o", $value);
		$value = str_replace("ỡ", "o", $value);
		$value = str_replace("ợ", "o", $value);
		#---------------------------------O*
		$value = str_replace("Ớ", "O", $value);
		$value = str_replace("Ờ", "O", $value);
		$value = str_replace("Ở", "O", $value);
		$value = str_replace("Ỡ", "O", $value);
		$value = str_replace("Ợ", "O", $value);
		#---------------------------------u*
		$value = str_replace("ứ", "u", $value);
		$value = str_replace("ừ", "u", $value);
		$value = str_replace("ử", "u", $value);
		$value = str_replace("ữ", "u", $value);
		$value = str_replace("ự", "u", $value);
		#---------------------------------U*
		$value = str_replace("Ứ", "U", $value);
		$value = str_replace("Ừ", "U", $value);
		$value = str_replace("Ử", "U", $value);
		$value = str_replace("Ữ", "U", $value);
		$value = str_replace("Ự", "U", $value);
		#---------------------------------y
		$value = str_replace("ý", "y", $value);
		$value = str_replace("ỳ", "y", $value);
		$value = str_replace("ỷ", "y", $value);
		$value = str_replace("ỹ", "y", $value);
		$value = str_replace("ỵ", "y", $value);
		#---------------------------------Y
		$value = str_replace("Ý", "Y", $value);
		$value = str_replace("Ỳ", "Y", $value);
		$value = str_replace("Ỷ", "Y", $value);
		$value = str_replace("Ỹ", "Y", $value);
		$value = str_replace("Ỵ", "Y", $value);
		#---------------------------------DD
		$value = str_replace("Đ", "D", $value);
		$value = str_replace("Đ", "D", $value);
		$value = str_replace("đ", "d", $value);
		#---------------------------------o
		$value = str_replace("ó", "o", $value);
		$value = str_replace("ò", "o", $value);
		$value = str_replace("ỏ", "o", $value);
		$value = str_replace("õ", "o", $value);
		$value = str_replace("ọ", "o", $value);
		$value = str_replace("ô", "o", $value);
		$value = str_replace("ơ", "o", $value);
		#---------------------------------O
		$value = str_replace("Ó", "O", $value);
		$value = str_replace("Ò", "O", $value);
		$value = str_replace("Ỏ", "O", $value);
		$value = str_replace("Õ", "O", $value);
		$value = str_replace("Ọ", "O", $value);
		$value = str_replace("Ô", "O", $value);
		$value = str_replace("Ơ", "O", $value);
		#---------------------------------u
		$value = str_replace("ú", "u", $value);
		$value = str_replace("ù", "u", $value);
		$value = str_replace("ủ", "u", $value);
		$value = str_replace("ũ", "u", $value);
		$value = str_replace("ụ", "u", $value);
		$value = str_replace("ư", "u", $value);
		#---------------------------------U
		$value = str_replace("Ú", "U", $value);
		$value = str_replace("Ù", "U", $value);
		$value = str_replace("Ủ", "U", $value);
		$value = str_replace("Ũ", "U", $value);
		$value = str_replace("Ụ", "U", $value);
		$value = str_replace("Ư", "U", $value);
		$value=strtolower($value);
		#---------------------------------trong truong hop lai tieng nhat hay hoa
		return $value;
	}
function getlink()
{
	$link=filter_var($_SERVER['REQUEST_URI']);
	return $link;
}

?>