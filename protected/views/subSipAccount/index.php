<?php
/* @var $this SubSipAccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sub Sip Accounts',
);

$this->menu=array(
	array('label'=>'Create SubSipAccount', 'url'=>array('create')),
	array('label'=>'Manage SubSipAccount', 'url'=>array('admin')),
);
?>

<h1>Sub Sip Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
