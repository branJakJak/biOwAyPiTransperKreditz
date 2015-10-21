<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Remote Data Caches'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RemoteDataCache', 'url'=>array('index')),
	array('label'=>'Create RemoteDataCache', 'url'=>array('create')),
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

<h1>Manage Remote Data Caches</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$data =$model->search();
$data->pagination = false;
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'remote-data-cache-grid',
	'dataProvider'=>$data,
	'filter'=>$model,
	'columns'=>array(
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
		'num_lines',
		'campaign',
		'date_created',
		'date_updated',
		/*
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
