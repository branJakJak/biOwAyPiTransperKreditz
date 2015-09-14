<?php
/* @var $this SubSipAccountController */
/* @var $model SubSipAccount */

$this->breadcrumbs=array(
	'Sub Sip Accounts'=>array('index'),
	'Create',
);



$this->menu=array(
	// array('label'=>'List Sub Sip Account', 'url'=>array('index')),
	// array('label'=>'Manage Sub Sip Account', 'url'=>array('admin')),
);

?>

<h1>Create SubSipAccount</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>