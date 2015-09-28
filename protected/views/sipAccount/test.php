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

Yii::app()->clientScript->registerScript('asdasd', '

	setTimeout(function() {
		window.chartData = highchartyw2;
	}, 500);

	', CClientScript::POS_READY);

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
	function updateChartData () {
		jQuery.ajax({
		  url: '/sipAccount/getBarChartReportData',
		  type: 'GET',
		  dataType: 'json',
		  success: function(data, textStatus, xhr) {
		    window.chartData.series[0].setData(data)
		  },
		});
		setTimeout(updateChartData, 3 * 1000);
	}
	setTimeout(updateChartData, 3 * 1000);


	function updateListViewData() {
		alertify.success('Updating data.. Please wait....');
		$.fn.yiiListView.update("sipAccountListView");
		setTimeout(updateListViewData, 60 * 1000);
	}
	setTimeout(updateListViewData, 60 * 1000);
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


<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'SIP Account Balance',
	));
?>


<?php 

$this->widget(
    'yiiwheels.widgets.highcharts.WhHighCharts',
    array(
        'pluginOptions' => array(
        	'chart' => array(
        		'type'=>"bar"
    		),
			"plotOptions"=>array(

	  			"bar"=>array(
	                'dataLabels' => array(
	                    "enabled"=> "true"
	                )
	            )
			),
            'title' => array(
                'text' => 'SIP Account Balance Report',
            ),
            'xAxis' => array(
                'categories' => array('Balance'),
                'title'=>array("text"=>null),
            ),
            'yAxis' => array(
            	"min"=>0,
                'title' => array(
                    'text' =>  null,
                ),

            ),
            'series' => new CJavaScriptExpression("window.customData = ".json_encode($chartData))
        )
    )
);

?>


<?php
	$this->endWidget();
?>



<hr>


<h1>
    Sip Accounts <small>[bestvoipreselling]</small>
	<small id="updateCounterContainer"></small>
</h1>
<hr>


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
