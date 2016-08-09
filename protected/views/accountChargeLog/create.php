<?php
/* @var $this AccountChargeLogController */
/* @var $model AccountChargeLog */

$this->breadcrumbs=array(
	'Account Charge Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccountChargeLog', 'url'=>array('index')),
	array('label'=>'Manage AccountChargeLog', 'url'=>array('admin')),
);
?>

<h1>Create AccountChargeLog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>