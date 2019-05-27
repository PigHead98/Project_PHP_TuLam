function cart(id,name,price)
{
document.forms["frmcart"].id.value=id;
document.forms["frmcart"].hidden_name.value=name;
document.forms["frmcart"].hidden_price.value=price;
document.forms["frmcart"].command.value='add';
document.forms["frmcart"].submit();
}
function update(id,quantity)
{
document.forms["frmcart"].id.value=id;
document.forms["frmcart"].quantity.value=quantity;
document.forms["frmcart"].command.value='update';
document.forms["frmcart"].submit();
}
function del(id)
{
document.forms["frmcart"].id.value=id;
document.forms["frmcart"].command.value='delete';
document.forms["frmcart"].submit();
}
function setcolor($name)
{

document.forms["frmcart"].hidden_color.value=$name;
document.forms["formorder"].hidden_color.value=$name;
}
function setsize($name)
{

document.forms["frmcart"].hidden_size.value=$name;
document.forms["formorder"].hidden_size.value=$name;
}
function clearall()
{
document.forms["frmcart"].command.value='clear';
document.forms["frmcart"].submit();
}
$(function(){
	$("#colorpanel span").click(function(){
		$("#colorpanel span").removeClass('active');
		$(this).addClass('active');
	});
	$("#sizepanel span").click(function(){
		$("#sizepanel span").removeClass('active');
		$(this).addClass('active');
	});
});
function buynow(id)
{
$.ajax({
	url:'../../buy.php',
	type:'POST',//or GET
	data:'id='+id,
	dataType:'text',//json -> mảng dữ liệu
	success: function(result)
	{
		$('#resultajax').html(result);
	}
	
});
}