<?php
/* @var $this AutoTopupConfigurationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auto Topup Configurations',
);

$this->menu=array(
	array('label'=>'Create AutoTopupConfiguration', 'url'=>array('create')),
	array('label'=>'Manage AutoTopupConfiguration', 'url'=>array('admin')),
);
?>

<h1>Auto Topup Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
