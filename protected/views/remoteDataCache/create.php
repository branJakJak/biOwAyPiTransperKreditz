<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Remote Data Caches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RemoteDataCache', 'url'=>array('index')),
	array('label'=>'Manage RemoteDataCache', 'url'=>array('admin')),
);
?>

<h1>Create RemoteDataCache</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>