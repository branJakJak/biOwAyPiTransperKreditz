<?php 


$baseUrl = Yii::app()->theme->baseUrl; 

$numSelectedItems = <<<EOL
window.numberOfSelectedItems = 0;
EOL;
Yii::app()->clientScript->registerScript('numSelectedItemsVars', $numSelectedItems, CClientScript::POS_HEAD);


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
	console.log(currentCat);
	window.numberOfSelectedItems = currentCat.length;
	jQuery("#numberOfSelectedItems").html(window.numberOfSelectedItems);
}
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
								var tempCategoryContainer = this.category.split("-")[2].trimLeft();
								tempArrContainer = tempContainer.split(",");
								tempArrContainer.clean("");
								tempArrContainer.push(tempCategoryContainer);
								window.newCategoryAdded(tempArrContainer);
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


/*Listen for manual selection value change*/
$manualAccountInput = <<<EOL
	jQuery('#TopupForm_accounts').on('change', function(event) {
		window.numberOfSelectedItems = jQuery('#TopupForm_accounts').val().split(",").filter(function(e){return e}).length;
		jQuery("#numberOfSelectedItems").html(parseInt(window.numberOfSelectedItems));
	});
EOL;
Yii::app()->clientScript->registerScript('manualAccountInput', $manualAccountInput, CClientScript::POS_READY);





$topUpValueList = [];
foreach (range(10,50,10) as $key => $value) {
	$topUpValueList[$value] = $value;
}

?>
<script type="text/javascript">
	function selectAll() {
		window.chartObj.series[0].data.forEach(function(cur){
			cur.firePointEvent('click', event);
		})
	}
	function deselectAll() {
		jQuery('#TopupForm_accounts').val("");
		jQuery('#TopupForm_accounts').trigger('change.select2');
		jQuery("#numberOfSelectedItems").html(parseInt(window.numberOfSelectedItems));
	}
	function toggleSchedule(curDom) {
		if (jQuery(curDom).is(":checked")) {
			jQuery("#scheduleTimeField").show();
		} else {
			jQuery("#scheduleTimeField").hide();
		}
	}
	function toggleManualInputTopUpValue (curDom) {
		if (jQuery(curDom).is(":checked")) {
			jQuery("#manualInputTopUpValue").show();
		} else {
			jQuery("#manualInputTopUpValue").hide();
		}
	}
	$(document).ready(function() {

		jQuery("#topUpForm").submit(function(event) {
			/* Act on the event */
			
			var topUpValue = 0 + 'EUR';
			if (jQuery("#is_manual_input").is(":checked")) {
				topUpValue = jQuery("#manualInputTopUpValue").val();
				topUpValue = parseFloat(topUpValue);
				topUpValue += ' EUR';
			} else {
				if (jQuery("#TopupForm_topupvalue input[type=radio]:checked").size() > 0) {
					topUpValue = jQuery("#TopupForm_topupvalue input[type=radio]:checked").val();
					topUpValue = parseFloat(topUpValue);
					topUpValue += ' EUR';				
				}
			}
			var confirmRetVal = confirm("Are you sure you want to topup "+topUpValue+" on "+window.numberOfSelectedItems+' account(s)');
			var confirmSubmittion = false;
			if (!!confirmRetVal) {
				return true;
			}else{
				event.preventDefault();
				return false;
			}
		});
	});
</script>
<style type="text/css">
	#TopupForm_topupvalue label { 
		display: inline;
		margin-left: 10px;
	}
	#TopupForm_topupvalue input[type="radio"] {
		margin-top: -3px;
	}
	#TopupForm_topupvalue radio-separator {
		margin: 5px 0px;
	}
</style>
<div class="row-fluid">
	<div class="span5 offset1">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Top-up Selected Account',
				'htmlOptions'=>array(
					'style'=>"height: 835px;overflow-y: scroll;border: 1px solid #DDDDDD;"
				),				
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
		<?php echo CHtml::beginForm(array('/subSipAccount/topUpSelected'), 'post',['id'=>'topUpForm','style'=>'padding: 30px;padding-bottom: 0px;']); ?>
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
			<br>
			<?php echo CHtml::activeRadioButtonList($formModel, 'topupvalue', $topUpValueList, array('class'=>'form-control','template'=>'{input}{label}<div class="radio-separator"></div>')); ?>
			<?php echo CHtml::error($formModel, 'topupvalue'); ?>
			<br>
			<?php echo CHtml::checkBox('is_manual_input', false, array('onchange'=>'toggleManualInputTopUpValue(this)')); ?>
			<label style="
    display: inline;
    position: relative;
    top: 3px;
">Toggle Manual Input</label>
			<br>
			<?php echo CHtml::textField('manualInputTopUpValue', '', array('class'=>'form-control','style'=>'display:none','id'=>'manualInputTopUpValue')); ?>
			<br>
			<br>
			<label>
				<?php echo CHtml::activeCheckBox($formModel, 'andActivate'); ?>
				<strong style="position: relative;top: 2px;">Then activate</strong>
				<?php echo CHtml::error($formModel, 'andActivate'); ?>
			</label>

			<br>
			<label>Force Agent : </label>
			<?php echo CHtml::activeDropDownList($formModel, 'forceAgent', $listForceAgentCollection); ?>
			<?php echo CHtml::link('Add more', array('/forceAgentTable/create'), array('target'=>'_blank')); ?>
			<br>
			<br>

			<div class="checkbox">
				<label>
					<?php echo CHtml::activeCheckBox($formModel, 'scheduleForceAgent',array('onchange'=>'toggleSchedule(this)')); ?>
					<?php echo CHtml::error($formModel, 'scheduleForceAgent'); ?>
					<strong>Schedule</strong>
				</label>
			</div>
			<br>
			<div style="display:none" id='scheduleTimeField'>
				<label>Schedule Time : </label>
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					    'model'=>$formModel,
					    'attribute'=>'scheduleTime',
					    'flat'=>true,
					    'options'=>array(
					        'showAnim'=>'slide',
					        'minDate'=>'new Date(new Date().setDate(new Date().getDate()-1));'
					    ),
					    'htmlOptions'=>array(
					        'class'=>'form-control'
					    ),
					));
				?>
				<label>Hour</label>
				<select name="scheduleHour" id="inputScheduleHour" class="form-control">
					<?php foreach (range(1, 12) as $key => $value): ?>
						<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach ?>
				</select>
				<label>Minute</label>
				<select name="scheduleMinute" id="inputScheduleMinute" class="form-control">
					<?php foreach (range(0, 60) as $key => $value): ?>
						<option value="<?= sprintf("%02d",$value) ?>"><?= sprintf("%02d",$value) ?></option>
					<?php endforeach ?>
					<option value=""></option>
				</select>
				<select name="ampm" id="inputAmpm" class="form-control">
					<option value="AM">AM</option>
					<option value="PM">PM</option>
				</select>
				<?php echo CHtml::error($formModel, 'scheduleTime'); ?>				
			</div>
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
						'style'=>"height: 758px;overflow-y: scroll;border: 1px solid #DDDDDD;"
					),
				));
			?>
			<div style="padding: 18px;">
				<div class="radio">
					<label>
						<input type="radio" name="multiple_action" id="inputMultiple_action" value="select_all">
						None
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="multiple_action" id="inputMultiple_action" value="select_all" onchange="selectAll()">
						Select all
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="multiple_action" id="inputMultiple_action" value="deselect_all" onchange="deselectAll()">
						Deselect all
					</label>
				</div>				
			</div>
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