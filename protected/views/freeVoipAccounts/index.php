<?php
/* @var $this FreeVoipAccountsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Free Voip Accounts',
);

$this->menu=array(
	array('label'=>'Create new account', 'url'=>array('create')),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>

<h1>Free Voip Accounts</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
