<?php
/* @var $this AccountChargeLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Account Charge Logs',
);

$this->menu=array(
	array('label'=>'Create AccountChargeLog', 'url'=>array('create')),
	array('label'=>'Manage AccountChargeLog', 'url'=>array('admin')),
);
?>

<h1>Account Charge Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
