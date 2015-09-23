<?php
/* @var $this SubSipAccountController */
/* @var $model SubSipAccount */

$this->breadcrumbs=array(
	'Sub Sip Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	// array('label'=>'List Sub SipAccount', 'url'=>array('index')),
	array('label'=>'Create Sub SipAccount', 'url'=>array('create')),
	array('label'=>'Update Sub SipAccount', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sub SipAccount', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage Sub SipAccount', 'url'=>array('admin')),
);
?>

<h1>View SubSipAccount #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		// 'id',
		array(
			'label'=>'Parent Account',
			'type'=>'raw',
			'value'=>CHtml::link($model->parentSip->username, array('/sipAccount/view','id'=>$model->parentSip->id))
		),
		'username',
		'password',
		'account_status',
		'customer_name',
		'balance',
		'exact_balance',
		'last_checked_bal',
		'date_created',
		'date_updated',
	),
)); ?>
