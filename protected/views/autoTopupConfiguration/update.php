<?php
/* @var $this AutoTopupConfigurationController */
/* @var $model AutoTopupConfiguration */

$this->breadcrumbs=array(
	'Auto Topup Configurations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AutoTopupConfiguration', 'url'=>array('index')),
	array('label'=>'Create AutoTopupConfiguration', 'url'=>array('create')),
	array('label'=>'View AutoTopupConfiguration', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AutoTopupConfiguration', 'url'=>array('admin')),
);
?>

<h1>Update AutoTopupConfiguration <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>