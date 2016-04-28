<?php
/* @var $this ForceAgentTableController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Force Agent Tables',
);

$this->menu=array(
	array('label'=>'Create new options', 'url'=>array('create')),
	array('label'=>'Manage all options', 'url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'All options',
		'htmlOptions'=>array('class'=>'offset2 span8 portlet')
	));
?>
	<h1>Force Agent Tables</h1>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
<?php
	$this->endWidget();
?>