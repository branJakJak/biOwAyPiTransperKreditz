<?php


?>
<style type="text/css">
	.campaign-ratio-value , .campaign-throttle , .campaign-title{
		min-height:130px;
	}
	.top-report-dashboard {
		text-align: right;
	}
	.top-report-dashboard small{
		color: white;
	}
</style>

<div class="grid">
 <div class="row col-md-12">
      <div class="tile tile-purple col-md-3 col-xs-12"  >
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      			@TODO - chart here
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h1 class='top-report-dashboard'>
					0
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
					0
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
					0
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
					0
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
					<center>
						<small>
							Throttle Control
						</small>
					</center>
					<h1 class='campaign-id-label'style="margin-top: 2px;font-size: 60px;">
						<?php echo $value['campaign_id'] ?>
					</h1>
					<center>
						<small>
							200 Live / 1000 Max
						</small>
					</center>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 tile tile-green campaign-ratio-value">
					<center>
						<small>
							LIVE/AVAIL
						</small>
					</center>
					<h1><?php echo $value['agents'] ?>/<?php echo $totalNumberOfAgents ?></h1>
					<center>
						<small>
							2058 MAX
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
						0
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
	if (confirm("Do you want to save changes you made ?")) {
		jQuery.ajax({
		  url: '/control/updateChannel',
		  type: 'get',
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
						$this->widget('zii.widgets.jui.CJuiSliderInput', array(
						    'id'=>'slider'.$key,
						    'name'=>'slider',
						    'value'=>0,
						    'event'=>'change',
						    'options'=>array(
						        'range'=>'min',
						        'min'=>0,
						        'max'=>49,
						        'slide'=>$slideFunctionTemplate,
						        'stop'=>$askPermission
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
