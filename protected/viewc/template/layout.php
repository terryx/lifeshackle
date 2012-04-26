<!DOCTYPE html>
<html>
	<head>
		<?php include "{$data['header']}.php"; ?>
	</head>
	<body>
		<?php include "{$data['nav']}.php"; ?>
		<div class="container">
			<?php echo $data['content']; ?>
			<hr />
			<?php include "{$data['footer']}.php"; ?>
		</div>
	</body>
</html>