<?php
/* @var $this RemoteDataCacheController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Remote Data Caches',
);

$this->menu=array(
	array('label'=>'Create accounts', 'url'=>array('create')),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>

<h1>Remote Data Caches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'template'=>'{summary}{pager}{items}{pager}',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
