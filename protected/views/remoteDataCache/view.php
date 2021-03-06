<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Remote Data Caches'=>array('index'),
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

<h1>View account<?php echo $model->sub_user; ?></h1>
<hr>
<?php echo CHtml::link('<i class="icon-th-list"></i> View Credits Used Logs', array('/creditsUsedLogs/record','account'=>$model->id,'log_date'=>date('Y-m-d')), array('class'=>'btn btn-default')); ?>
<br>
<br>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'main_user',
		'main_pass',
		'sub_user',
		'sub_pass',
		'vici_user',
		'is_active',
		'last_balance',
		'balance',
		'exact_balance',
		'ip_address',
		'last_balance',
		'balance',
		'exact_balance',
		'campaign',
		'last_balance_since_topup',
		'accumulating_credits_used',
		'num_lines',
		'is_hidden',
		[
			'label'=>'Disable URL',
			'type'=>'raw',
			'value'=>CHtml::link('https://portal23.xyz/disable/account?mainusername='.$model->main_user , 'https://portal23.xyz/disable/account?mainusername='.$model->main_user)
		],
		[
			'label'=>'VOIP Infocenter Login',
			'type'=>'raw',			
			'value'=>CHtml::link('https://www.voipinfocenter.com/Login.aspx?username='.$model->main_user.'&password='.$model->main_pass,'https://www.voipinfocenter.com/Login.aspx?username='.$model->main_user.'&password='.$model->main_pass)
		]
	),
)); ?>



<br>
<br>
<br>
<br>
