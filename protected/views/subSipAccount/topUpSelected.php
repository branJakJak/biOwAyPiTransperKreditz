<?php 

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
jQuery("#TopupForm_accounts").change(function(){
	var currentdomVal = jQuery("#TopupForm_accounts").val();
	if(currentdomVal != ""){
		numOfItemsSelected = currentdomVal.split(",").length;
		jQuery("#numberOfSelectedItems").html(numOfItemsSelected);
	}else{
		jQuery("#numberOfSelectedItems").html("0");
	}
});
EOL;
Yii::app()->clientScript->registerScript('listenToEventWh', $listenToEventWh, CClientScript::POS_READY);



$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');
$cs->registerScriptFile('//code.highcharts.com/highcharts.src.js', CClientScript::POS_END);
// $cs->registerScriptFile('//code.highcharts.com/highcharts.js', CClientScript::POS_END);
// $cs->registerScriptFile($baseUrl.'/bower_components/highcharts-release/highcharts.js'  , CClientScript::POS_END);
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
								var tempContainer = jQuery('#TopupForm_accounts').val();
								var tempCategoryContainer = this.category.split("-")[1].trimLeft();
								tempArrContainer = tempContainer.split(",");
								tempArrContainer.clean("");
								tempArrContainer.push(tempCategoryContainer);
								jQuery('#TopupForm_accounts').val(tempArrContainer.join(","));
								jQuery('#TopupForm_accounts').trigger('change.select2');
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


/*update interval*/
/*Yii::app()->clientScript->registerScript('updateChartDataInterval', '
function updateChartDataInterval(){
	jQuery.ajax({
	  url: "/sipAccount/getBarChartReportData",
	  type: "POST",
	  dataType: "json",
	  complete: function(xhr, textStatus) {
	    setTimeout(updateChartDataInterval, 1000);
	  },
	  success: function(data, textStatus, xhr) {
	  	window.updateChartData(data);
	  },
	});
}
setTimeout(updateChartDataInterval, (60*60) * 1000);
', CClientScript::POS_READY);
*/


/*the blinking ...uh oh effect*/
// Yii::app()->clientScript->registerScript('blinkingChart', '
// 		window.blinkerInterval = setInterval(window.chartBlink, 600);
// ', CClientScript::POS_READY);







?>
<div class="row-fluid">
	<div class="span5 offset1">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Top-up Selected Account',
			));
		?>
		<?php
		$this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>true, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'×', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
			    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
		    ),
		)); ?>
		<?php echo CHtml::beginForm(array('/subSipAccount/topUpSelected'), 'post',['style'=>'padding: 30px;padding-bottom: 0px;']); ?>
			<label>
				<b style="float:left">
					Accounts : 
				</b>
				<strong style="float:right;position: relative;left: -90px;">
					<i id='numberOfSelectedItems'>0</i> item(s) selected
				</strong>
				<div class="clearfix"></div>
			</label>
			<?php
				$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				// 'id' => 'allSipAccountsWh2',
				'model' => $formModel,
				'attribute' => 'accounts',
				'asDropDownList' => false,
				'pluginOptions' => array(
				    'tags' => $allSipAccounts,
				    'placeholder' => 'type accounts',
				    'width' => '80%',
				    'tokenSeparators' => array(',', ' ')
				)));
			?>
			<?php echo CHtml::error($formModel, 'accounts'); ?>
			<br>
			<br>
			<label>Via : </label>
			<?php echo CHtml::activeDropDownList($formModel, 'freeVoipAccountUsername', CHtml::listData(FreeVoipAccounts::model()->findAll(), 'username', 'username')  ); ?>
			<?php echo CHtml::error($formModel, 'accounts'); ?>
			<br>
			<br>
			<label>Amount : </label>
			<?php echo CHtml::activeTextField($formModel, 'topupvalue', array('class'=>'form-control')); ?>
			<?php echo CHtml::error($formModel, 'topupvalue'); ?>
			<br>
			<br>
			<?php echo CHtml::activeCheckBox($formModel, 'andActivate'); ?>
			<strong style="position: relative;top: 2px;">Then activate</strong>
			<?php echo CHtml::error($formModel, 'andActivate'); ?>
			<br>
			<br>

			<label>Force Agent : </label>
			<?php echo CHtml::activeDropDownList($formModel, 'forceAgent', array("VBpi8"=>"Injury Campaign","PBAVB6"=>"PBA Campaign","LIFEbz"=>"LIFE","VBInjury"=>"Injury TEST","PBATEST"=>"PBA TEST")); ?>
			<br>
			<br>
			<div class="form-actions">
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
			</div>

		<?php echo CHtml::endForm(); ?>
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

<div class="row-fluid">
	<div class="span10 offset1">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'<strong>Today\'s Topup Total : </strong> '.$topupLogsTotalToday,
			));
		?>
		<?php 
			$this->widget('zii.widgets.grid.CGridView', array(
			    'dataProvider'=>$logRecsTodayDataProvider,
			    'columns'=>array(
			        // 'topUpValue',
			        array(
			        		'header'=>'Log',
			        		'value'=>'$data->message',
			        	),
			        array(
			        		'header'=>'Time',
			        		'value'=>'date("F j, Y, g:i a",strtotime($data->logDate))',
			        	),
			    ),
			));
		?>
		<?php
			$this->endWidget();
		?>	
	</div>
</div>