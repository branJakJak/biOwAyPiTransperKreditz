<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>

<h1>Create RemoteDataCache</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>