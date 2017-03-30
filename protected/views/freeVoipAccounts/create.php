<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Manage Accounts', 'url'=>array('admin')),
);
?>

<div class="row">
	<div class="span4"></div>
	<div class="span4 well" style='padding-left: 50px'>
		<h1>
		Create new account
		</h1>
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>
