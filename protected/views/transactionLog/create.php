<?php
/* @var $this TransactionLogController */
/* @var $model TransactionLog */

$this->breadcrumbs=array(
	'Transaction Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List logs', 'url'=>array('index')),
	array('label'=>'Manage logs', 'url'=>array('admin')),
);
?>

<h1>Create new transaction log</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>