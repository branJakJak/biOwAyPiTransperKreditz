<?php
/* @var $this AutoTopupConfigurationController */
/* @var $model AutoTopupConfiguration */

$this->breadcrumbs=array(
	'Auto Topup Configurations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AutoTopupConfiguration', 'url'=>array('index')),
	array('label'=>'Manage AutoTopupConfiguration', 'url'=>array('admin')),
);
?>

<h1>Create AutoTopupConfiguration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>