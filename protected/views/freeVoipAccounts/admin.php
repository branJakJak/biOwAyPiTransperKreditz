<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Create new account', 'url'=>array('create')),
);
?>
<div class="row">
	<div class="span2"></div>
	<div class="span8 well">
		<h1>Manage Free Voip Accounts</h1>
		<?php echo CHtml::link('Add New', array('freeVoipAccounts/create'), array('class'=>'btn btn-primary')); ?>

		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'free-voip-accounts-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				// 'id',
				'username',
				'password',
				'credits',
				'description',
				// 'date_created',
				// 'date_updated',
				array(
					'type'=>'raw',
					'header'=>'Last update',
					'value'=>'VoipTransDateHelper::timeAgo(strtotime($data->date_updated))'
				),
				array(
					'class'=>'CButtonColumn',
				),
			),
		)); ?>
	</div>
	<div class="span2"></div>
</div>
