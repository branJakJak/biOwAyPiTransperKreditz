<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Create new account', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#remote-data-cache-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>SIP Accounts</h1>
<?php echo CHtml::link('Add new acount', array('/remoteDataCache/create'), array('class'=>'btn btn-success')); ?>
<?php 
$data =$model->search();
$data->pagination = false;

$cols = array(
	'id',
	'main_user',
	// 'main_pass',
	'sub_user',
	// 'sub_pass',
	'vici_user',
	'is_active',
	// 'last_balance',
	// 'balance',
	// 'exact_balance',
	'ip_address',
);
// if (Yii::app()->user->name === 'root') {
	$cols[] = 	array(
		'class'=>'CButtonColumn',
	);
// }

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'remote-data-cache-grid',
	'dataProvider'=>$data,
	'filter'=>$model,
	'columns'=>$cols
	// 'htmlOptions'=>array('class'=>'table table-bordered')
)); ?>
