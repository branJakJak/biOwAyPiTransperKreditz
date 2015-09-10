<?php
/* @var $this TransactionLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Logs',
);

$this->menu=array(
	//array('label'=>'Create TransactionLog', 'url'=>array('create')),
	//array('label'=>'Manage TransactionLog', 'url'=>array('admin')),
);
?>

<h1>Transaction Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'template'=>' <div class="pull-left" style="margin-top: 30px;">{summary} {sorter}</div><div class="clearfix"></div> {items} {pager}',
	'itemView'=>'_view',
	 'sortableAttributes'=>array(
        'amount'=>"Amount",
        'date_created'=>'Log Date',
    ),
)); ?>
