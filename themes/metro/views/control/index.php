<?php


Yii::app()->clientScript->registerScript('liveFeedCall', 'liveFeed();', CClientScript::POS_READY);

?>
<style type="text/css">
	.campaign-ratio-value , .campaign-throttle , .campaign-title{
		min-height:170px;
	}
	.top-report-dashboard , .lead-report-panel {
		text-align: right;
	}
	.top-report-dashboard small , .lead-report-value , .lead-report-label{
		color: white;
	}
	.tile {
		opacity: 1 !important;
	}
	.lead-report-label{
	    font-size: 12px;
	    position: relative;
	    top: -17px;		
	}
</style>
<script type="text/javascript">
	window.SLIDER_UPDATING = false;
	window.WAITING_TIME = 20 * 1000;
	window.DASH_VAL_WAIT_TIME = 10 * 1000;
	window.CAMPAIGN_DATA_LIVE_UPDATE_TIME = 10 * 1000;


	function campaignDataLiveUpdate() {
		jQuery.ajax({
		  url: '/control/leadsReport',
		  type: 'POST',
		  dataType: 'json',
		  complete: function(xhr, textStatus) {
		  },
		  success: function(data, textStatus, xhr) {
		  	jQuery.each(data, function(index, val) {
		  		if (val && val.current_leads) {
					jQuery("#"+index+"-current-lead").html(val.current_leads);
		  		}
		  		if (val && val.live) {
					jQuery("#"+index+"-live-lead").html(val.live);
		  		}
		  	});
		    setTimeout(function() {
		    	window.campaignDataLiveUpdate();
		    }, window.CAMPAIGN_DATA_LIVE_UPDATE_TIME);
		  },
		  error: function(xhr, textStatus, errorThrown) {
		    
		  }
		});
		
	}

	function liveFeed () {
		setTimeout(function() {
			if (!window.SLIDER_UPDATING) {
				jQuery.ajax({
				  url: '/control/liveFeed',
				  type: 'POST',
				  dataType: 'json',
				  success: function(data, textStatus, xhr) {
				  	jQuery.each(data, function(index, val) {
				  	  jQuery("."+val.campaign_id+"-numAgents").html(val.agents);
				  	  jQuery("."+val.campaign_id+"-channelPerAgent").html(val.channels);
				  	  jQuery("#slider"+index+"_slider").slider("value",val.num_of_channels);
				  	  jQuery("h1.slider"+index).html(val.number_of_lines);
				  	});
				    liveFeed();
				  },
				  error: function(xhr, textStatus, errorThrown) {
				    console.log(xhr);
				    console.log(textStatus);
				    console.log(errorThrown);
				    alert("Something went wrong during ajax call");
				  }
				});
			}
		}, window.WAITING_TIME);
	}
	function updateDashVals () {
		setTimeout(function() {
			jQuery.ajax({
			  url: '/control/dashboardPanelData',
			  type: 'POST',
			  dataType: 'json',
			  data: {param1: 'value1'},
			  complete: function(xhr, textStatus) {
			    console.log("dash updated");
			  },
			  success: function(data, textStatus, xhr) {
			    //called when successful
			    jQuery("#activeCallReportData").html(data.activeCallReport);
			    jQuery("#ringingReportData").html(data.ringingReport);
			    jQuery("#liveCallReportData").html(data.liveCallReport);
			    jQuery("#channelReportData , .channelReportData").html(data.channelReport);
			    setTimeout(updateDashVals, window.DASH_VAL_WAIT_TIME);
			  },
			  error: function(xhr, textStatus, errorThrown) {
			    alert("An error occured while reloading dashboard data.");
			  }
			});
			
		}, window.DASH_VAL_WAIT_TIME);
	}
	campaignDataLiveUpdate();
	updateDashVals();
</script>
<div class="grid">
 <div class="row col-md-12">
      <div class="tile tile-purple col-md-3 col-xs-12"  >
      		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      			@TODO - chart here
      		</div>
      		<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
				<h1 class='top-report-dashboard'>
					<b id="activeCallReportData"><?php echo $activeCallReport ?></b>
					<br>
					<small>Active Call</small>
				</h1>
      		</div>
      </div>
      <div class="tile tile-green col-md-3 col-xs-12"  >
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      			@TODO - chart here
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h1 class='top-report-dashboard'>
					<b id="ringingReportData"><?php echo $ringingReport ?></b>
					<br>
					<small>Ringing</small>
				</h1>
      		</div>      
      </div>
      <div class="tile tile-blue col-md-3 col-xs-12"  >
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      			@TODO - chart here
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h1 class='top-report-dashboard'>
					<b id="liveCallReportData"><?php echo $liveCallReport ?></b>
					<br>
					<small>Live Calls</small>
				</h1>
      		</div>
      </div>
      <div class="tile tile-yellow col-md-3 col-xs-12"  >
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      			@TODO - chart here
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h1 class='top-report-dashboard'>
					<b id="channelReportData"><?php echo $channelReport ?></b>
					<br>
		      		<small>Channels</small>
				</h1>
      		</div>
      </div>
	  <?php foreach ($datasource->data as $key => $value): ?>
			<?php echo CHtml::beginForm(array('/control/updateChannel'), 'POST',array('id'=>'form'.$key)); ?>
				<?php echo CHtml::hiddenField('campaign_id', $value['campaign_id']); ?>
				<?php echo CHtml::hiddenField('agents', $value['agents']); ?>
				<?php echo CHtml::hiddenField('channels', $value['channels']); ?>
				<?php echo CHtml::hiddenField('throttleValue', 0 , array('id'=>'throttle'.$key)); ?>
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 tile tile-blue campaign-title">
					<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-lg-offset-3">
						<center>
							<small>
								Throttle Control
							</small>
						</center>
						<h1 class='campaign-id-label'style="margin-top: 2px;font-size: 60px;">
							<?php echo $value['new_label'] ?>
						</h1>
						<center>
							<small>
								200 Live / 1000 Max
							</small>
						</center>					
					</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<?php 
							$leadReportPanelTitle = "";
							$current = array();
							if ($value['new_label'] === 'PBA') {
								$current  = $hopperListData['PBA'];
								$leadReportPanelTitle = 'PBA';
							}
							if ($value['new_label'] === 'INJURY') {
								$current  = $hopperListData['LIVEA'];
								$leadReportPanelTitle = 'LIVEA';
							}
						?>
						<div class="" >
							<h1 class='lead-report-panel' >
								<strong><?php echo $leadReportPanelTitle ?></strong>
								<br>
									<small class='lead-report-value'>
									<?php if (isset($current['current_leads'])): ?>
									<b id='<?php echo $leadReportPanelTitle?>-current-lead'>
										<?php echo $current['current_leads'] ?>
									</b>
									\
									<?php endif ?>
									<?php if (isset($current['live'])): ?>
									<b id="<?php echo $leadReportPanelTitle?>-live-lead">
										<?php echo $current['live'] ?> 
									</b>
									<?php endif ?>
									<?php if (!isset($current['live'])): ?>
										<b id="<?php echo $leadReportPanelTitle?>-live-lead">
											0
										</b>
									<?php endif ?>
									</small>
									<br>
									<small class='lead-report-label'>
										Current \ Live
									</small>
							</h1>
						</div>						
					</div>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 tile tile-green campaign-ratio-value">
					<center>
						<small>
							LIVE/AVAIL
						</small>
					</center>
					<h1>
						<b class='<?php echo $value['campaign_id'] ?>-numAgents'><?php echo $value['agents'] ?> </b>
						/ 
						<b class='<?php echo $value['campaign_id'] ?>-channelPerAgent'>
							<?php echo $value['channels'] ?>
						</b>
					</h1>
					<center>
						<small>
							<?php 
								$totalCalc = intval($value['agents']) * 49;
							?>
							<?php echo number_format($totalCalc) ?> MAX
						</small>
					</center>
				</div>
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 tile tile-red campaign-throttle">
					<center>
						<small>
							Throttle Control
						</small>
					</center>

					<h1 class="slider<?php echo $key?>">
						<?php echo $value['number_of_lines'] ?>
					</h1>
					<?php
						$slideFunctionTemplate = <<<EOL
js:function(event,ui){ 
	$(".slider$key").html(ui.value);
	$("#throttle$key").val(ui.value);
}
EOL;
						$askPermission = <<<EOL
js:function(event,ui){ 
	window.SLIDER_UPDATING = false;
	console.log(window.SLIDER_UPDATING);
	if (confirm("Do you want to save changes you made ?")) {
		jQuery.ajax({
		  url: '/control/updateChannel',
		  type: 'GET',
		  data: jQuery("#form$key").serialize(),
		  beforeSend:function(){
			$.notify({
				message: 'Updating..Please wait...'
			},{
				type: 'info'
			});	  	
		  },
		  success: function(data, textStatus, xhr) {
			$.notify({
				message: data
			},{
				type: 'success'
			});
		  },
		  error: function(xhr, textStatus, errorThrown) {
			$.notify({
				message: errorThrown
			},{
				type: 'danger'
			});
		  }
		});
		console.log($("#form$key").serialize());
	}
}
EOL;
$sliderStartScript = <<<EOL
js:function(event,ui){
	window.SLIDER_UPDATING = true;
	console.log(window.SLIDER_UPDATING);
}
EOL;
						$this->widget('zii.widgets.jui.CJuiSliderInput', array(
						    'id'=>'slider'.$key,
						    'name'=>'slider',
						    'value'=>$value['number_of_lines'],
						    'event'=>'change',
						    'options'=>array(
						        'range'=>'min',
						        'min'=>0,
						        'max'=>49,
						        'slide'=>$slideFunctionTemplate,
						        'stop'=>$askPermission,
						        'start'=>$sliderStartScript
						    ),
						    // slider css options
						    'htmlOptions'=>array(
						    ),
						));
					?>
					<center>
						<small>
							49 MAX
						</small>
					</center>
				</div>
	  		<?php echo CHtml::endForm(); ?>
	  <?php endforeach ?>
  </div>
</div>


<div class="grid hidden">
	<div class="row col-md-12">
	<?php foreach ($hopperListData as $key => $current): ?>
		<div class="tile tile-pink col-md-3 col-xs-12"  >
			<h1 class='lead-report-panel' >
				<strong><?php echo $key ?></strong>
				<br>
					<small class='lead-report-value'>
					<?php if (isset($current['current_leads'])): ?>
					<b id='<?php echo $key?>-current-lead'>
						<?php echo $current['current_leads'] ?>
					</b>
					\
					<?php endif ?>
					<?php if (isset($current['live'])): ?>
					<b id="<?php echo $key?>-live-lead">
						<?php echo $current['live'] ?> 
					</b>
					<?php endif ?>
					<?php if (!isset($current['live'])): ?>
						<b id="<?php echo $key?>-live-lead">
							0
						</b>
					<?php endif ?>
					</small>
					<br>
					<small class='lead-report-label'>
						Current \ Live
					</small>
			</h1>
		</div>
	<?php endforeach ?>
	</div>
</div>