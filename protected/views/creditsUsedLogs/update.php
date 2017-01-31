<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */

$this->breadcrumbs=array(
	'Credits Used Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CreditsUsedLogs', 'url'=>array('index')),
	array('label'=>'Create CreditsUsedLogs', 'url'=>array('create')),
	array('label'=>'View CreditsUsedLogs', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CreditsUsedLogs', 'url'=>array('admin')),
);
?>

<h1>Update CreditsUsedLogs <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>