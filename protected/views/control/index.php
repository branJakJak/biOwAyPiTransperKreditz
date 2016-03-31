<?php 

?>

<div class="row-fluid">
	<div class="span8 offset2">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Control',
			));
		?>	
			<div class="well">
				<label>Update Channels</label>
				<?php
					$this->widget('zii.widgets.jui.CJuiSliderInput', array(
					    'name'=>'slider_basic',
					    'value'=>0,// default selection 
					    'event'=>'change',
					    'options'=>array(
					        'min'=>0, 
					        'max'=>49,
					        'slide'=>'js:function(event,ui){$("#amount_basic").val(ui.value);}',
					    ),
					    'htmlOptions'=>array(
						    ),
					));
				?>
			</div>

			<table class="table table-bordered table-hover table-stripped">
				<thead>
					<tr>
						<th>Campaign ID</th>
						<th>Agents</th>
						<th>Channels</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($datasource->data as $key => $value): ?>
					<tr>
						<?php echo CHtml::beginForm(array('/control/updateChannel'), 'POST'); ?>
						<?php echo CHtml::hiddenField('campaign_id', $value['campaign_id']); ?>
						<?php echo CHtml::hiddenField('agents', $value['agents']); ?>
						<?php echo CHtml::hiddenField('channels', $value['channels']); ?>
							<td>
								<?php echo $value['campaign_id'] ?>
							</td>
							<td>
								<?php echo $value['agents'] ?>
							</td>
							<td>
								<?php echo $value['channels'] ?>
							</td>
						<?php echo CHtml::endForm(); ?>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php
			$this->endWidget();
		?>

	</div>
</div>

