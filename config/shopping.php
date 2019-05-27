<?
isset($_post["command"])?$command=$_post["command"]:$command="";
if($command=="add")  
{

	  if(isset($_SESSION["shopping_cart"]))  
	  {  
		   $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
		   if(!in_array($_post["id"], $item_array_id))  
		   {  
				$count = count($_SESSION["shopping_cart"]);  
				$item_array = array(  
					 'item_id'=>$_post["id"],  
					 'item_name'=>$_post["hidden_name"],  
					 'item_price'=>$_post["hidden_price"],  
					 'item_quantity'=>$_post["quantity"]  ,
					 'item_discount'=>$_post["hidden_discount"]  
				);  
				$_SESSION["shopping_cart"][$count] = $item_array;  
		   }  
		   else  
		   {  	
				echo '<script>alert("Item Already Added");window.location="'.$root_dir.'"</script>';   
		   }  
	  }  
	  else  
	  {  
		   $item_array = array(  
				'item_id'=>$_post["id"],  
				'item_name'=>$_post["hidden_name"],  
				'item_price'=>$_post["hidden_price"],  
				'item_quantity'=>$_post["quantity"]  ,
				 'item_discount'=>$_post["hidden_discount"]  
		   );  
		   $_SESSION["shopping_cart"][0] = $item_array;  
	  }  
}
elseif($command=="update")  
{		$count = count($_SESSION["shopping_cart"]); 
	   foreach($_SESSION["shopping_cart"] as $keys => $values)  
	   {  	$update_quatity=$values["item_quantity"]+$_post["quantity"];
			if($update_quatity>0 and $update_quatity<=100)
			{
				if($values["item_id"] == $_post["id"])  
				{ 
				$item_array = array(  
					 'item_id'=>$values["item_id"],  
					 'item_name'=>$values["item_name"],  
					 'item_price'=>$values["item_price"],  
					 'item_quantity'=>$update_quatity,
					  'item_discount'=>$values["item_discount"]  
					 
				);
				$_SESSION["shopping_cart"][$keys] = $item_array;
				break;
				}
			}
			else
			{
			 echo '<script>alert("Số lượng tối thiểu 1 và nhiều nhất là 100");window.location="'.$root_dir.'"</script>';  
			}
	   }
} 
elseif($command=="delete")  
{    
   foreach($_SESSION["shopping_cart"] as $keys => $values)  
   {  
		if($values["item_id"] == $_post["id"])  
		{  
			 unset($_SESSION["shopping_cart"][$keys]);  
			 echo '<script>alert("Item Removed");window.location="'.$root_dir.'"</script>';    
		}  
   }   
}  


 elseif($command=="clear")  
{    
   foreach($_SESSION["shopping_cart"] as $keys => $values)  
   {  
			 unset($_SESSION["shopping_cart"][$keys]);  
			   
   }   
   echo '<script>alert("Item Removed");window.location="'.$root_dir.'"</script>';  
}
 
?>
 