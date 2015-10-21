<?php
/* @var $this RemoteDataCacheController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Remote Data Caches',
);

$this->menu=array(
	array('label'=>'Create RemoteDataCache', 'url'=>array('create')),
	array('label'=>'Manage RemoteDataCache', 'url'=>array('admin')),
);
?>

<h1>Remote Data Caches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
