<main>
	<section class="path txt-b">
	<a href="<?=$root_dir?>index.php"><i class="fa fa-home"></i>Trang chủ</a>
	<?=$db->path('cat',$id)?>
	</section>

	<section class="box-product">
	<div class='product'>
	<?=$db->list_cat_produce('product',$id); ?>
	</div>
	</section>
	
	</main>