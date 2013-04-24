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
</head>
<body>
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?> 
</body>
</html>
