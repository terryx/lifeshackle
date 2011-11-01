<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $data['title']; ?></title>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php $this->render($data['nav'], $data, true); ?>
		<div class="container">
			<?php $this->render($data['content'], $data, true); ?>
		</div>
	</body>
</html>