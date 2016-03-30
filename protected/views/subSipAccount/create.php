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

<h1>Register Sub Sip Account</h1>

<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
)); ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>