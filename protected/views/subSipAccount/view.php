<?php
/* @var $this SubSipAccountController */
/* @var $model SubSipAccount */

$this->breadcrumbs=array(
	// 'Sub Sip Accounts'=>array('index'),
	'Sub Sip Accounts',
	$model->customer_name,
);

$this->menu=array(
	// array('label'=>'List Sub SipAccount', 'url'=>array('index')),
	// array('label'=>'Create Sub SipAccount', 'url'=>array('create')),
	// array('label'=>'Update Sub SipAccount', 'url'=>array('update', 'id'=>$model->id)),
	// array('label'=>'Delete Sub SipAccount', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage Sub SipAccount', 'url'=>array('admin')),
);
?>

<h1>View SubSipAccount #<?php echo $model->id; ?></h1>
<hr>
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
)); ?>

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
		// 'balance',
		// 'exact_balance',
		// 'last_checked_bal',
		'date_created',
		'date_updated',
	),
)); ?>
