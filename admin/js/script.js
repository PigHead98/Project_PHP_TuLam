function detail(id)
{
$.ajax({
	url:'detailorders.php',
	type:'POST',//or GET
	data:'id='+id,
	dataType:'text',//json -> mảng dữ liệu
	success: function(result)
	{
		$('#resultajax').html(result);
	}
	
});
}