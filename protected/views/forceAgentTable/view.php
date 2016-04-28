<?php
/* @var $this ForceAgentTableController */
/* @var $model ForceAgentTable */

$this->breadcrumbs=array(
	'Force Agent Tables'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Show all options', 'url'=>array('index')),
	array('label'=>'Create new option', 'url'=>array('create')),
	array('label'=>'Update current option', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete current option', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage all options', 'url'=>array('admin')),
);


$css = <<<EOL
	.porlet-title {
		line-height: 29px;
	    font-size: 19px;
	    margin-left: 15px;
	}

EOL;

?>


<div class="row-fluid">
	<div class="span9 offset2">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong class='porlet-title'>".$model->force_agent_lbl."</strong>".CHtml::link('<span class="icon icon-list-alt"></span> Show all options', array('/forceAgentTable/admin'), array('class'=>'btn btn-default pull-right')).'<div class="clearfix"></div>',
				'htmlOptions'=>array('class'=>'span10 portlet')
			));
		?>
		<h1>View Option #<?php echo $model->force_agent_lbl; ?></h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'force_agent_lbl',
				'force_agent_value',
				// 'date_created',
				// 'date_updated',
			),
		)); ?>
		<?php
			$this->endWidget();
		?>
	</div>
</div>

