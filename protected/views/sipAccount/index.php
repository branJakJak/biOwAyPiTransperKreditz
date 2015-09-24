<?php
/* @var $this SipAccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sip Accounts',
);

$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.min.css');

$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> Register new SIP Account', 'url'=>array('create')),
	//array('label'=>'Manage SipAccount', 'url'=>array('admin')),
);
?>

<style type="text/css">
	.account-panels {
		min-width : 350px;
		max-width : 450px;
		float:left;
		margin: 10px 5px;

		padding: 10px;
	}
	.list-view .summary {
		text-align: left;
	}
</style>


<script type="text/javascript">
	function updateListViewData() {
		alertify.success('Updating data.. Please wait....');
		$.fn.yiiListView.update("sipAccountListView");
	}
	setInterval(updateListViewData, 5 * 1000);
</script>

<?php 

$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, 
    'closeText'=>'×',
    'alerts'=>array( 
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success
	    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // info
    ),
)); ?>
<h1>
    Sip Accounts <small>[bestvoipreselling]</small>
</h1>
<small id="updateCounterContainer"></small>


<?php $this->widget('zii.widgets.CListView', array(
	'id'=>'sipAccountListView',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>'<div class="pull-left" >{summary}<h5>{sorter}</h5></div><div class="clearfix"></div><br><hr>{items}<br>{pager}',
   	'sortableAttributes'=>array(
        'username',
        'account_status',
        'date_created'=>'Date Created',
    ),	
)); ?>
