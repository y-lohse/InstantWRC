<!DOCTYPE html>
<html ng-app="InstantWRC">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		InstantWRC
	</title>
	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link rel="stylesheet" href="css/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?> 
</body>
</html>
