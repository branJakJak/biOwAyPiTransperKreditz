<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Create accounts', 'url'=>array('create')),
	array('label'=>'View accounts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>

<h1>Update FreeVoipAccounts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>