<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Create accounts', 'url'=>array('create')),
	array('label'=>'Update accounts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete accounts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>


<div class="row">
	<div class="span2"></div>
	<div class="span8 well" style='padding-left: 50px'>
	<?php echo CHtml::link('Back', array('/freeVoipAccounts/admin'), array('class'=>'')); ?> | 
	<?php echo CHtml::link('Add Another', array('/freeVoipAccounts/create'), array('class'=>'')); ?>
		<h1>View FreeVoipAccounts #<?php echo $model->id; ?></h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'username',
				'password',
				'credits',
				'description',
				'date_created',
				'date_updated',
			),
		)); ?>
	</div>
</div>


