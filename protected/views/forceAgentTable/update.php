<?php
/* @var $this ForceAgentTableController */
/* @var $model ForceAgentTable */

$this->breadcrumbs=array(
	'Force Agent Tables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Show all options', 'url'=>array('index')),
	array('label'=>'Create new options', 'url'=>array('create')),
	array('label'=>'View current options', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage all options', 'url'=>array('admin')),
);
?>
<div class="row-fluid">
	<div class='offset3 span5'>
		<h1>Update <?php echo $model->force_agent_lbl; ?></h1>
	</div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>