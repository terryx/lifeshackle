<form id="edit-picture-form" method="post" action="<?php echo $data['baseurl']; ?>profile/save-pic" enctype="multipart/form-data">
	<label for="filename">Filename</label>&nbsp;
	<input type="file" id="filename" name="filename" />
	<input type="submit" value="Upload" />
</form>