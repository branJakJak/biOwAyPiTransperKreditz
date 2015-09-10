<?php
/* @var $this TransactionLogController */
/* @var $model TransactionLog */

$this->breadcrumbs=array(
	'Transaction Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionLog', 'url'=>array('index')),
	//array('label'=>'Create TransactionLog', 'url'=>array('create')),
	array('label'=>'View TransactionLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionLog', 'url'=>array('admin')),
);
?>

<h1>Update Transaction Log <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>