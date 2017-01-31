<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */

$this->breadcrumbs=array(
	'Credits Used Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CreditsUsedLogs', 'url'=>array('index')),
	array('label'=>'Create CreditsUsedLogs', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#credits-used-logs-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Credits Used Logs</h1>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'credits-used-logs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'credit_used',
		'log_date',
		'remote_data_cache_accout_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
