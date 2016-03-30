<?php
/* @var $this ViciLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vici Log Actions',
);

$this->menu=array(
	array('label'=>'Create ViciLogAction', 'url'=>array('create')),
	array('label'=>'Manage ViciLogAction', 'url'=>array('admin')),
);
?>

<h1>Vici Log Actions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
