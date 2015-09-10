<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Manage Accounts', 'url'=>array('admin')),
);
?>

<h1><i class="fa fa-user"></i>Create new account</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>