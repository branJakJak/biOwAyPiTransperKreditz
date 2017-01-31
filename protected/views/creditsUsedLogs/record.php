<?php 


?>
<div class="span2">
	
</div>
<div class="span8">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Credits Usedd Log',
		));
	?>
	<div style='padding: 30px;'>

		<?php $this->renderPartial('_search_by_log_date',array(
			'model'=>$model,
			'remote_data_cache'=>$model->remote_data_cache_accout_id,
		)); ?>


		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'credits-used-logs-grid',
			'dataProvider'=>$model->search(),
			// 'filter'=>$model,
			'columns'=>array(
				// 'id',
				[
					'value'=>'$data->getAccountName()',
					'header'=>'Account Name'
				],
				// 'remote_data_cache_accout_id',
				'credit_used',
				// 'log_date',
				[
					'value'=>'date("F j, Y, g:i a",strtotime($data->log_date))',
					'header'=>'Log Date'
				],
				// array(
				// 	'class'=>'CButtonColumn',
				// ),
			),
		)); ?>
	</div>
	<?php
		$this->endWidget();
	?>

	
</div>
<div class="span2"></div>
