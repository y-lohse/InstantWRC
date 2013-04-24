<!DOCTYPE html>
<html ng-app="InstantWRC">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<?php echo $this->fetch('content'); ?>
</body>
</html>
