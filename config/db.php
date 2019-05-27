<? /* Bên web*/
class db extends mysqli
{	private $sercet="@dsd45vd2b";
	public function __construct($host, $user, $password, $database) 
	{
			parent::__construct($host, $user, $password, $database);
			if(mysqli_connect_errno())
			{
				throw new exception(mysqli_connect_error(), mysqli_connect_errno()); 
			}
	}
	public function myquery($query)
	{
		if( !$this->real_query($query) ) {
			throw new exception( $this->error, $this->errno );
		}	

		$result = new mysqli_result($this);
		return $result;
	}
	public function num_row($result)
	{
		return mysqli_num_rows($result);
	}
	public function fetch_row($result)
	{
		return mysqli_fetch_array($result);
	}
	public function last_insert_id()
	{
		return $this->insert_id;
	}
	
	public function redicrect($filename,$dir="../")
	{
		header("Location: ".$dir.$filename);
		//echo '<meta http-equiv="refresh" content="0;url='.$dir.$filename.'" />';
	}
	function encryt($data)
	{
		$data=md5($this->sercet.$data);
		$data=hash('sha1',$data);
		return $data;
	}
	function generate_salt($Usermail,$Password)
	{
		$data=$this->encryt($Usermail.$Password.time());
		return $data;
	}
	function update_salt($Usermail,$Password)
	{
		$salt=$this->generate_salt($Usermail,$Password);
		$sql="update db_tblaccount set `salt`='$salt' where usermail='".$Usermail."' and status=1";
		if($this->myquery($sql))
		{
			$_SESSION['login']['salt']=$salt;
			return true;
		}
		else
		{
			$_SESSION['login']['salt']="";
			return false;
		}
	}
	
	function check_salt()
	{
		$sql="select salt from db_tblaccount where usermail='".$_SESSION['login']['usermail']."' and salt='".$_SESSION['login']['salt']."' and status=1";
		$result=$this->myquery($sql);
		if($this->num_row($result)==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function login($Usermail,$Password)
	{
		
		$Password=$this->encryt($Password);
		$sql="  select * 
				from db_tblaccount
				where usermail='".$Usermail."' and
				password='".$Password."' and
				status=1";
		$result=$this->myquery($sql);
		
		if($this->num_row($result)==1)
		{
			$row=$this->fetch_row($result);//tách dòng
			$_SESSION['login']['status']=true;
			
			$_SESSION['login']['name']=$row['name'];
			$_SESSION['login']['usermail']=$row['usermail'];
			$_SESSION['login']['password']=$row['password'];
			$_SESSION['login']['image']=$row['img'];
			if($this->update_salt($Usermail,$Password))
			$this->redicrect("index.php");
			else
			{
			$this->redicrect("login.php");	
			
			
			}
		}
		else
		{
			$_SESSION['login']['status']=false;
			$this->redicrect('login.php');
		}
	}
	
	
	public function checklogin($dir="../")
	{	
		if(!$this->check_salt())//==$_SESSION['login']['trangthai']=false
		{	
			$this->redicrect("login.php",$dir);
			
		}
	}
	
	public function post($data)
	{
		isset($_POST[$data])?$result=$_POST[$data]:$result='';
		return $result;
	}
	public function display($data)
	{	
		isset($_SESSION['login'][$data])?$result=$_SESSION['login'][$data]:$result=null;
		return $result;
	}
	function get($data,$value_default="")
	{
		isset($_GET[$data])?$result=$_GET[$data]:$result=$value_default;
		return $result;
	}
	function logout()
	{	
		unset($_SESSION['login']);
		session_destroy;
		$this->redicrect('login.php',"./");	
		
	}
	
	function cat_menu($db_table='db_tblcat')
	{	global $db_prifix,$root_dir;
		$rs='<div class="produce">';
		$sql="select * from ".$db_prifix.$db_table." where status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{
			$rs.='<li><a title="'.$row['name'].'" href="'.$root_dir.'danh-muc/'.$row['link']."-".$row['id'].'.html"> <span class="txt-b">'.$row['name'].'</span></a></li>';	
		}
		$rs.='</div>';
		return $rs;
	}
	function path($db_table,$id)
	{	global $db_prifix,$root_dir;
		$sql="select * from ".$db_prifix.$db_table." where id=$id and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		$rs="
		<a title='Danh mục' href='".$root_dir."danh-muc/tat-ca-san-pham-0.html'><span class='txt-b'><i class='fa fa-angle-right '> </i>Danh mục</a>
		<a title='".$row['name']."' href='".$root_dir."danh-muc/".$row['link']."-".$row['id'].".html'><span class='txt-b'><i class='fa fa-angle-right '> </i></span>".$row['name']."</a>
		";	
	
		return $rs;
	}
	
	function main_produce($db_table='db_tblcat',$id,$idcarousel)
	{	global $db_prifix,$db,$root_dir;
		$rs='<div class="owl-carousel" id="'.$idcarousel.'">';
		$sql="select * from ".$db_prifix.$db_table." where idcat=$id and status=1 and hot=1";
		
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{
			$url="".$root_dir."chi-tiet/".$row['link']."-".$row['id'].".html";
			if($row['discount']==0)
			{
				$undiscount='undiscount';
				$unprice='undiscount';
			}
			else{
				$undiscount='discount bg-red white txt-b';
				$unprice='line-through';
			}
			$rs.='<div class="item"> 
			  <a href="'.$url.'" class="item-img">
			  '.img_display($row['img'],$row['name'],0).' 
			  </a>
			  <a href="'.$url.'" class="item-name">
			  '.$row['name'].'
			  
			  </a>
			  <div class="item-price">
			  <span class="'.$unprice.'">'.number_format($row['price']).' đ</span>
			  <span class="main-color txt-b">'.number_format($row['price']-$row['price']*$row['discount']/100).' đ</span>
			  </div>
			  <a href="#" class="btn main-bg white" onclick="buynow(\''.$row['id'].'\')">
			  <i class="fa fa-shopping-bag"></i>Mua Hàng
			  </a>
			  <div class="'.$undiscount.'" >
				<span >'.$row['discount'].'%</span>
				<span>Giảm</span>
			  </div>
			  <a href="'.$url.'" class="view">
			  <span class="white main-bg"><i class="fa fa-folder-open"></i>Chi Tiết</span>
			  </a>
			  </div>
			';	
		}
		$rs.='</div>';
		return $rs;
	}
	function cat_produce_lienquan($db_table='db_tblcat',$id)
	{	global $db_prifix;
		$i=0;
		
		$rs='<section class="box-produce box-checkout">';
		$sql="select * from ".$db_prifix.$db_table." where id=$id and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
			$rs.='
			<div class="title"><h2>'.$row['name'].'</h2></div>
			'.$this->main_produce("product",$row['id'],"produce".$i).'
			';
			$i++;
	
		$rs.='</section>';
		return $rs;
	}
	function cat_produce($db_table='db_tblcat')
	{	global $db_prifix;
		$i=0;
		
		$rs='<section class="box-produce box-checkout">';
		$sql="select * from ".$db_prifix.$db_table." where  status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{
			$rs.='
			<div class="title"><h2>'.$row['name'].'</h2></div>
			'.$this->main_produce("product",$row['id'],"produce".$i).'
			';
			$i++;
		}
		$rs.='</section>';
		return $rs;
	}
	function list_cat_produce($db_table='db_tblproduct',$id)
	{	global $db_prifix,$root_dir;$rs="";
		if($id==0)
		$sql="select * from ".$db_prifix.$db_table." where  status=1";
		else
		$sql="select * from ".$db_prifix.$db_table." where idcat=$id and status=1 ";
		
		$result=$this->myquery($sql);
		
		while($row=$this->fetch_row($result))
		{
			$url="".$root_dir."chi-tiet/".$row['link']."-".$row['id'].".html";
			if($row['discount']==0)
			{
				$undiscount='undiscount';
				$unprice='undiscount';
			}
			else{
				$undiscount='discount bg-red white txt-b';
				$unprice='line-through';
			}
			$rs.='<div class="item item_cat"> 
			  <a href="'.$url.'" class="item-img">
			   '.img_display($row['img'],$row['name'],0).' 
			  </a>
			  <a href="'.$url.'" class="item-name">
			  '.$row['name'].'
			  
			  </a>
			  <div class="item-price">
			  <span class="'.$unprice.'">'.number_format($row['price']).' đ</span>
			  <span class="main-color txt-b">'.number_format($row['price']-$row['price']*$row['discount']/100).' đ</span>
			  </div>
			  <a href="#" class="btn main-bg white" onclick="buynow(\''.$row['id'].'\')"><i class="fa fa-shopping-bag"></i>Mua Hàng
			  </a>
			  <div  class="'.$undiscount.'">
				<span>'.$row['discount'].'%</span>
				<span>Giảm</span>
			  </div>
			  <a href="'.$url.'" class="view">
			  <span class="white main-bg"><i class="fa fa-folder-open"></i>Chi Tiết</span>
			  </a>
			  </div>
			';	
		}
		$rs.='</div>';
		return $rs;
	}
	function list_poster($db_table='db_tblposter')
	{
		global $db_prifix,$upload_dir;
		$rs="";
		
		$rs.='<div class="owl-carousel w100 table-responsive" id="slider" >';
		$sql="select img from ".$db_prifix.$db_table." where  status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{
			 $rs.='<div> <img src="'.$upload_dir.$row['img'].'" alt="logo"> </div>';
		}
		$rs.='</div>';
		return $rs;
	}
	function id_to_name($db_table='db_tblcat',$id)
	{
		$sql="select * from $db_table where id=$id and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		return $row['name'];
	}
	
	function list_footer($db_table="")
	{
		global $db_prifix,$root_dir;
		$rs="";
		$sql="select * from db_tblcattask where  status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result)){
		$rs.='
			<span class="text-color"><h4>■'.$row['name'].'</h4>
			'.$this->list_info_footer($db_table="mutitask",$row['id']).'</span>
			';
			
		}
		return $rs;
	}
	function list_info_footer($db_table="mutitask",$id=0)
	{
		global $db_prifix,$root_dir;
		$rs="";
		$sql="select * from ".$db_prifix.$db_table." where idcat=$id and status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{
		$rs.='
			<li><a href="'.$root_dir.''.$row['link'].'.html" class="text-color">- '.$row['name'].' </a></li>
			';
		}
		return $rs;
	}
	function seo($cmd,$link,$id,&$data=array())
	{
		global $db_prifix;
		if($cmd=="cat")
			$sql="select * from ".$db_prifix."cat where id=$id and status=1";
		elseif($cmd=="detail")
			$sql="select * from ".$db_prifix."product where id=$id and status=1";
		else
			$sql="select * from ".$db_prifix."seo where link='$link' and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		isset($row["id"])?$data['id']=$row['id']:$data['id']="";
		isset($row["idcat"])?$data['idcat']=$row['idcat']:$data['idcat']="";
		isset($row["name"])?$data['name']=$row['name']:$data['name']="";
		isset($row["keyword"])?$data['keyword']=$row['keyword']:$data['keyword']="";
		isset($row["description"])?$data['description']=$row['description']:$data['description']="";
		isset($row["img"])?$data['img']=$row['img']:$data['img']="";
		isset($row["content"])?$data['content']=$row['content']:$data['content']="";
		isset($row["discount"])?$data['discount']=$row['discount']:$data['discount']=0;
		isset($row["view"])?$data['view']=$row['view']:$data['view']=1;
		isset($row["price"])?$data['price']=$row['price']:$data['price']=0;
		isset($row["sku"])?$data['sku']=$row['sku']:$data['sku']="";
		isset($row["comment"])?$data['comment']=$row['comment']:$data['comment']=0;
		isset($row["status"])?$data['status']=$row['status']:$data['status']="";
		isset($row["date"])?$data['date']=date("d-m-y",(int)$row["date"]):$data['date']=date("d-m-y",time());
		isset($row["hot"])?$data['hot']=$row['hot']:$data['hot']="";
		isset($row["brand"])?$data['brand']=$row['brand']:$data['brand']="";
		isset($row["link"])?$data['link']=$row['link']:$data['link']="";
		isset($row["color"])?$data['color']=$row['color']:$data['color']="";
		isset($row["size"])?$data['size']=$row['size']:$data['size']="";
		return $data;
	}
	function info(&$data=array())
	{
		global $db_prifix;
		$sql="select * from ".$db_prifix."info where status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		isset($row["phone"])?$data['phone']=$row['phone']:$data['phone']="";
		isset($row["facebook"])?$data['facebook']=$row['facebook']:$data['facebook']="";
		isset($row["facebookapi"])?$data['facebookapi']=$row['facebookapi']:$data['facebookapi']="";
		isset($row["googleplus"])?$data['googleplus']=$row['googleplus']:$data['googleplus']="";
		isset($row["googleapi"])?$data['googleapi']=$row['googleapi']:$data['googleapi']="";
		isset($row["youtube"])?$data['youtube']=$row['youtube']:$data['youtube']="";
		isset($row["twitter"])?$data['twitter']=$row['twitter']:$data['twitter']="";
		isset($row["instagram"])?$data['instagram']=$row['instagram']:$data['instagram']="";
		isset($row["chatapi"])?$data['chatapi']=$row['chatapi']:$data['chatapi']="";
		isset($row["map"])?$data['map']=$row['map']:$data['map']="";
		isset($row["hotline"])?$data['hotline']=$row['hotline']:$data['hotline']="";
		isset($row["id"])?$data['id']=$row['id']:$data['id']="";
		isset($row["name"])?$data['name']=$row['name']:$data['name']="";
		isset($row["keyword"])?$data['keyword']=$row['keyword']:$data['keyword']="";
		isset($row["description"])?$data['description']=$row['description']:$data['description']="";
		isset($row["img"])?$data['img']=$row['img']:$data['img']="";
		isset($row["content"])?$data['content']=$row['content']:$data['content']="";
		isset($row["domain"])?$data['domain']=$row['domain']:$data['domain']=0;
		isset($row["view"])?$data['view']=$row['view']:$data['view']=1;
		isset($row["sitename"])?$data['sitename']=$row['sitename']:$data['sitename']=0;
		isset($row["address"])?$data['address']=$row['address']:$data['address']="";
		isset($row["email"])?$data['email']=$row['email']:$data['email']=0;
		isset($row["status"])?$data['status']=$row['status']:$data['status']="";
		isset($row["date"])?$data['date']=date("d-m-y",(int)$row["date"]):$data['date']=date("d-m-y",time());
		isset($row["hot"])?$data['hot']=$row['hot']:$data['hot']="";
		isset($row["usergmail"])?$data['usergmail']=$row['usergmail']:$data['usergmail']="";
		isset($row["passwordgmail"])?$data['passwordgmail']=$row['passwordgmail']:$data['passwordgmail']="";
		return $data;
	}
	function update_view($id,$view)
	{
		global $db_prifix;
		$new_view=$view+1;
		$sql="update db_tblproduct set view=$new_view where id=$id and status=1
		";
		$result=$this->myquery($sql);
		
	}
	public function sent_mail($email,$subject,$message,$name)
	{	global $info;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		$mail-> CharSet="UTF-8";
		
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		//gỡ rối
		$mail->SMTPDebug = 2;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		//$mail->Host = 'smtp.gmail.com';
		// use
		$mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587; //cổng 465 cho ssl
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';//ssl 465 <- giao thức mã hóa
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true; //chứng thực
		$mail->SMTPOptions = array(
		'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
			 )
		);
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = 'petmarttest1@gmail.com';
		//Password to use for SMTP authentication
		$mail->Password = 'matkhaukhongdungvuilongthulai';
		//Set who the message is to be sent from
		$mail->setFrom('petmarttest@gmail.com', 'an'); //người gửi
		
		//echo $info['usergmail'];//Set an alternative reply-to address 
		
		//$mail->addReplyTo($info['usergmail'], $info['sitename']); //thiết lập thư đã gửi
		//Set who the message is to be sent to
		$mail->addAddress($email, $name); //người nhận
		//Set the subject line
		$mail->Subject = $subject;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';//chữ mặc định
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');//đính kèm
		//send the message, check for errors
		if (!$mail->send()) {
			echo "Không gửi được mail: " . $mail->ErrorInfo;
			
			return false;
		} else {
			echo "Message sent!";
			return true;
		}DIE();
	}

	public function __destruct()
	{
		parent::close();
	}
	
}

?>