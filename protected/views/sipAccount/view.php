<?php
/* @var $this SipAccountController */
/* @var $model SipAccount */

$this->breadcrumbs=array(
	'Sip Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	// array('label'=>'<i class="icon-list"></i> List Sip Account', 'url'=>array('index')),
	array('label'=>'<i class="icon-plus-sign"></i> Register Sip Account', 'url'=>array('create')),
	array('label'=>'<i class="icon-pencil"></i> Update Sip Account', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon-minus-sign"></i> Delete Sip Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'<i class="icon-calendar"></i> Manage Sip Account', 'url'=>array('admin')),
);
?>

<h1>View SipAccount #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'date_created',
		'date_updated',
	),
)); ?>
