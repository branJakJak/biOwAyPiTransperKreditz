<?php
/* @var $this SipAccountController */
/* @var $model SipAccount */

$this->breadcrumbs=array(
	'Sip Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SipAccount', 'url'=>array('index')),
	array('label'=>'Create SipAccount', 'url'=>array('create')),
	array('label'=>'View SipAccount', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SipAccount', 'url'=>array('admin')),
);
?>

<h1>Update SipAccount <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>