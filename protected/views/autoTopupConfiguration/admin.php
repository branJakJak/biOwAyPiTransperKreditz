<?php
/* @var $this AutoTopupConfigurationController */
/* @var $model AutoTopupConfiguration */

$this->breadcrumbs=array(
	'Auto Topup Configurations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AutoTopupConfiguration', 'url'=>array('index')),
	array('label'=>'Create AutoTopupConfiguration', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#auto-topup-configuration-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Auto Topup Configurations</h1>

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
	'id'=>'auto-topup-configuration-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'activated',
		'topUpValue',
		'budget',
		'freeVoipAccount',
		'remote_data_cache',
		/*
		'date_created',
		'date_updated',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
