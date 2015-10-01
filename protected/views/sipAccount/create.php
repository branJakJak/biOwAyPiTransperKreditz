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

<h1>Create SipAccount</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>