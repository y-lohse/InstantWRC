<?php 
$this->Html->script('/js/libs/jquery-1.9.1.js', false);
$this->Html->script('/js/libs/handlebars-1.0.0-rc.3.js', false);
$this->Html->script('/js/libs/ember-1.0.0-rc.2.js', false);
$this->Html->script('/js/app.js', false);
?>
<script type="text/x-handlebars" data-template-name="index">
	<?php echo $this->element('index'); ?>
</script>
<script type="text/x-handlebars" data-template-name="rankings">
	<?php echo $this->element('rankings'); ?>
</script>
<script type="text/x-handlebars" data-template-name="rally">
	<?php echo $this->element('rally'); ?>
</script>
<script type="text/x-handlebars" data-template-name="stage">
	<?php echo $this->element('stage'); ?>
</script>