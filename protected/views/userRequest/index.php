<?php
/* @var $this UserRequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Requests',
);

$this->menu=array(
	array('label'=>'Create UserRequest', 'url'=>array('create')),
	array('label'=>'Manage UserRequest', 'url'=>array('admin')),
);
?>

<h1>User Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
