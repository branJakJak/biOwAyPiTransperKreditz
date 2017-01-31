<?php 


?>


<div class="span2">
	
</div>
<div class="span8">
<h1>
	Hidden Accounts
</h1>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'remote-data-cache-grid',
	'dataProvider'=>$data,
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		'main_user',
		// 'main_pass',
		'sub_user',
		// 'sub_pass',
		'vici_user',
		'is_active',
		// 'last_balance',
		// 'balance',
		// 'exact_balance',
		'ip_address',
		// 'is_hidden',
		// 'num_lines',
		// 'campaign',
		// 'last_balance_since_topup',
		// 'date_created',
		// 'date_updated',
		[
		    'class'=>'CButtonColumn',
		    'template'=>'{unhide}',
		    'buttons'=>[
		        'unhide' => [
		            'label'=>'Unhide',
		            'url'=>'Yii::app()->createUrl("/remoteDataCache/unhide", array("account"=>$data->id))',
		        ],
		    ],

		]
	
		// array(
		// 	'class'=>'CButtonColumn',
		// ),
	),
)); ?>
	
</div>
<div class="span2">
	
</div>
