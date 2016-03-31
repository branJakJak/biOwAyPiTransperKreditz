<?php

?>
<style type="text/css">
	.campaign-ratio-value , .campaign-throttle , .campaign-title{
		min-height:130px;
	}
	h1.campaign-id-label{
		text-align:left !important;
	    margin-top: 2px;
	    font-size: 60px;
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
	  <?php foreach ($this->datasource as $key => $value): ?>
			<?php echo CHtml::beginForm(array('/control/updateChannel'), 'POST',array('id'=>'form'.$key)); ?>
			<?php echo CHtml::hiddenField('campaign_id', $value['campaign_id']); ?>
			<?php echo CHtml::hiddenField('agents', $value['agents']); ?>
			<?php echo CHtml::hiddenField('channels', $value['channels']); ?>

			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 tile tile-blue campaign-title">
				<?php echo $value['campaign_id'] ?>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 tile tile-green campaign-ratio-value">
				<small>LIVE/AVAIL</small>
				<h1><?php echo $value['agents'] ?>/<?php echo $totalNumberOfAgents ?></h1>
			</div>
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 tile tile-red campaign-throttle">
				Throttle Control
			</div>
	  <?php endforeach ?>
  </div>

</div>
