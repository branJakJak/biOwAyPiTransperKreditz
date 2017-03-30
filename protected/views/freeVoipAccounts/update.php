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


<div class="row">
	<div class="span4"></div>
	<div class="span4 well" style='padding-left: 50px'>
		<h1>Update <?php echo $model->username; ?></h1>
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>


