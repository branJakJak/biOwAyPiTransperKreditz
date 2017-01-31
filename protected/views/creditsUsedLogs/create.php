<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */

$this->breadcrumbs=array(
	'Credits Used Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CreditsUsedLogs', 'url'=>array('index')),
	array('label'=>'Manage CreditsUsedLogs', 'url'=>array('admin')),
);
?>

<h1>Create CreditsUsedLogs</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>