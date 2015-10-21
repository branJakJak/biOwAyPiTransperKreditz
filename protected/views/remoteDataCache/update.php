<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */

$this->breadcrumbs=array(
	'Remote Data Caches'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RemoteDataCache', 'url'=>array('index')),
	array('label'=>'Create RemoteDataCache', 'url'=>array('create')),
	array('label'=>'View RemoteDataCache', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RemoteDataCache', 'url'=>array('admin')),
);
?>

<h1>Update RemoteDataCache <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>