<?php
/* @var $this ActiveMonitorController */
$this->breadcrumbs=array(
	'Active Monitor'=>array("/activeMonitor/index"),
);
$hasSelectedMonitoredAccounts = false;
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/underscore-min.js', CClientScript::POS_HEAD);
$cleanArrProto = <<<EOL
Array.prototype.clean = function(deleteValue) {
  for (var i = 0; i < this.length; i++) {
    if (this[i] == deleteValue) {
      this.splice(i, 1);
      i--;
    }
  }
  return this;
};
EOL;
Yii::app()->clientScript->registerScript('cleanArrProto', $cleanArrProto, CClientScript::POS_HEAD);

$listenToEventWh = <<<EOL
window.newCategoryAdded = function(newCategory){
	var currentCat = _.uniq(newCategory);
	jQuery("#numberOfSelectedItems").html(currentCat.length);
	
	// var currentdomVal = jQuery("#TopupForm_accounts").val();
	// if(currentdomVal != ""){
	// 	numOfItemsSelected = currentdomVal.split(",").length;
	// }else{
	// 	jQuery("#numberOfSelectedItems").html("0");
	// }
}
EOL;
Yii::app()->clientScript->registerScript('listenToEventWh', $listenToEventWh, CClientScript::POS_READY);



$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');
$cs->registerScriptFile('//code.highcharts.com/highcharts.src.js', CClientScript::POS_END);
$javascriptCode = <<<EOL
	window.originalColorMap = new Object();
	window.options = {
            chart: {
            	renderTo:"chartContainer",
                type: 'bar'
            },
	 		title: {
	            text: 'Credit Balance'
	        },
			credits: {
			   enabled: false
			},
            legend: { enabled: false},
            xAxis: {
                categories: $chartLabels,
	  			title: {
	                text: null
	            },
            },
	 		yAxis: {
	            title: {
	                text: null,
	            },
	        },
            plotOptions: {
                series: {
	                cursor: 'pointer',
	                point:{
	                	events:{
	                		click:function(evt){
								var tempContainer = jQuery('#ActiveMonitorForm_accountsMonitor').val();
								var tempCategoryContainer = this.category.split("-")[2].trimLeft();
								tempArrContainer = tempContainer.split(",");
								tempArrContainer.clean("");
								tempArrContainer.push(tempCategoryContainer);
								window.newCategoryAdded(tempArrContainer);
								jQuery('#ActiveMonitorForm_accountsMonitor').val(tempArrContainer.join(","));
								jQuery('#ActiveMonitorForm_accountsMonitor').trigger('change.select2');
	                		}
	                	}
	                },
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                        style: {fontWeight: 'bolder'},
                        inside: true,
                    },
                    pointPadding: 0.1,
                    groupPadding: 0
                }
            },

            series: [{
                data: $seriesDataStr
            }]
        };
	window.chartObj = new Highcharts.Chart(window.options);
EOL;
Yii::app()->clientScript->registerScript('sipAccountCharts', $javascriptCode, CClientScript::POS_READY);



//get all cookies , if monitorAccount is present
if (isset(Yii::app()->request->cookies['monitoredAccounts'])) {
	$hasSelectedMonitoredAccounts = true;
	// Yii::app()->clientScript->registerScript('openDialog', '
	// 	$("#loadPastAccounts").dialog("open");
	// ', CClientScript::POS_READY);
}

?>

<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	    'id'=>'loadPastAccounts',
	    'options'=>array(
	        'title'=>'Load accounts',
	        'modal'=>true,
	        'width'=>'570px',
	        'autoOpen'=>$hasSelectedMonitoredAccounts,
	    ),
	));
?>
	<br>
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		You currently have monitored accounts. Would you like to clear them ? 
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	</div>
	<br>
	<?php echo CHtml::link('<span class="icon icon-remove icon-white"></span> Yes - clear them all', array('/activeMonitor/clear'), array('class'=>'btn btn-warning','style'=>'color: white')); ?>
	<?php echo CHtml::link('<span class="icon icon-ok icon-white"></span> No - Load previously monitored accounts', array('/activeMonitor/monitor'), array('class'=>'btn btn-primary','style'=>'color: white')); ?>
<?php 
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<div class="row-fluid">
	<div class="span5 offset1">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Monitor Account',
			));
		?>
			<?php echo CHtml::errorSummary($form); ?>
			<?php echo CHtml::beginForm(array('/activeMonitor/index'), 'POST',array('style'=>'padding: 20px')); ?>
				<?php echo CHtml::activeLabelEx($form, 'accountsMonitor'); ?>
				<?php
					$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'model' => $form,
					'attribute' => 'accountsMonitor',
					'asDropDownList' => false,
					'pluginOptions' => array(
					    'tags' => $allSipAccounts,
					    'placeholder' => 'type accounts',
					    'width' => '80%',
					    'tokenSeparators' => array(',', ' ')
					)));
				?>
				<?php echo CHtml::error($form, 'accountsMonitor'); ?>
				<br>
				<br>
				<button type='submit' class='btn btn-lg btn-primary'>Submit</button>
			<?php echo CHtml::endForm(); ?>
			<div class="clearfix"></div>
		<?php
			$this->endWidget();
		?>
	</div>
	<div class="span5">
		<div>
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Accounts and credits',
					'htmlOptions'=>array(
							'style'=>"height: 458px;overflow-y: scroll;border: 1px solid #DDDDDD;"
						),
				));
			?>
			<div id="chartContainer" style="height: 1500px"></div>
			<div class="clearfix"></div>
			<?php
				$this->endWidget();
			?>
		</div>
		<div class="clearfix"></div>
	</div>	
</div>
