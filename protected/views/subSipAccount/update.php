<?php
/* @var $this SubSipAccountController */
/* @var $model SubSipAccount */

$this->breadcrumbs=array(
	'Sub Sip Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	// array('label'=>'List SubSipAccount', 'url'=>array('index')),
	array('label'=>'Create Sub Sip Account', 'url'=>array('create')),
	array('label'=>'View Sub Sip Account', 'url'=>array('view', 'id'=>$model->id)),
	// array('label'=>'Manage SubSipAccount', 'url'=>array('admin')),
);
?>

<h1>Update SubSipAccount <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>