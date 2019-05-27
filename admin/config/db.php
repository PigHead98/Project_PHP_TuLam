<?
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
	function list_cat($db_table='db_tblcat',$id=0)
	{	$i=1;
		$rs='<select name="cat" class="form-control">';
		$sql="select * from $db_table where status=1";
		$result=$this->myquery($sql);
		while($row=$this->fetch_row($result))
		{	if($row["id"]==$id)
				$selected="selected";
			else
				$selected="";
			$rs.="<option value='".$row["id"]."'".$selected.">".($i++).". ".$row["name"]."</option>";	
		}
		$rs.='</select>';
		return $rs;
	}
	function id_to_name($db_table='db_tblcat',$id)
	{
		$sql="select * from $db_table where id=$id and status=1";
		$result=$this->myquery($sql);
		$row=$this->fetch_row($result);
		return $row['name'];
	}
	
	
	
	
	
	

	public function __destruct()
	{
		parent::close();
	}
	
}

?>