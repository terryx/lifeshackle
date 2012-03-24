<a href="<?php echo $data['original']; ?>" target="_blank"><img src="<?php echo $data['thumb']; ?>" alt="" /></a>
<br /><br />
<form id="store-picture-form" method="post" action="<?php echo $data['baseurl']; ?>store/save-picture" enctype="multipart/form-data">
	<input type="hidden" id="product_picture_id" name="product_picture_id" value="" />
	<label for="filename">Filename</label>
	<input type="file" id="filename" name="filename" />
	<input type="submit" value="Upload" />
</form>
<div style="color:red"><?php echo $data['message']; ?></div>
<script>
	document.getElementById('product_picture_id').value = parent.product_id;
</script>