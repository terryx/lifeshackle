<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $data['title']; ?></title>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<div class="container">
			<?php $this->render($data['nav']); ?>
			<div id="life">
				<?php $this->render($data['content']); ?>	
			</div>
			<?php include 'footer.php'; ?>
		</div>
	</body>
</html>