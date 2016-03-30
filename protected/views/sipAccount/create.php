<?php
/* @var $this SipAccountController */
/* @var $model SipAccount */

$this->breadcrumbs=array(
	'Sip Accounts'=>array('index'),
	'Create',
);


$this->menu = array(
	//array('label'=>'<i class="icon-list"></i> List SipAccount', 'url'=>array('index')),
);

?>

<h1>Register Sip Account</h1>
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
)); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>