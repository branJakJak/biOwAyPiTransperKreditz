<?php
/* @var $this AccountChargeLogController */
/* @var $model AccountChargeLog */

$this->breadcrumbs=array(
	'Account Charge Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccountChargeLog', 'url'=>array('index')),
	array('label'=>'Create AccountChargeLog', 'url'=>array('create')),
	array('label'=>'View AccountChargeLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AccountChargeLog', 'url'=>array('admin')),
);
?>

<h1>Update AccountChargeLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>