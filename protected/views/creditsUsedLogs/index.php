<?php
/* @var $this CreditsUsedLogsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Credits Used Logs',
);

$this->menu=array(
	array('label'=>'Create CreditsUsedLogs', 'url'=>array('create')),
	array('label'=>'Manage CreditsUsedLogs', 'url'=>array('admin')),
);
?>

<h1>Credits Used Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
