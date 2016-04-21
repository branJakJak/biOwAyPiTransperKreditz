<?php
/* @var $this ActiveMonitorController */
$this->breadcrumbs=array(
	'Active Monitor(configure)'=>array("/activeMonitor/index"),
	'Monitor',
);
$baseUrl = Yii::app()->theme->baseUrl; 


$accountsModelJs = CJSON::encode($accountsToMonitor);
$accountsModelScript = <<<EOL
	window.ACCOUNTS_MODEL = $accountsModelJs;
EOL;
Yii::app()->clientScript->registerScript('accountsModel',$accountsModelScript, CClientScript::POS_READY);	
Yii::app()->clientScript->registerScript('delaySeconds', 'window.DELAY_SECONDS = 10', CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('continueRequest', 'window.CONTINUE_REQUEST = true', CClientScript::POS_READY);

$refreshRateDropdownChange = <<<EOL
	jQuery("#refreshRateDropdown").change(function(event) {
		window.DELAY_SECONDS = parseInt(jQuery(this).val());
	});
EOL;
Yii::app()->clientScript->registerScript('refreshRateDropdownChange', $refreshRateDropdownChange, CClientScript::POS_READY);

?>


<script type="text/javascript">
	window.ACCOUNT_MODEL = [];
	window.DELAY_SECONDS = 10;
	window.HOLD_UPDATE_COLLECTION = [];
	window.CONTINUE_REQUEST = true;
	function updateBalance () {
		//not global pause
		if (window.CONTINUE_REQUEST) {
			window.ACCOUNT_MODEL.forEach(function(currentValue , currentIndex){
				//not actively pause by user
				if (  ! isPaused(currentValue)   ) {
					jQuery.ajax({
						url: '/sync/updateAccountBalance',
						type: 'GET',
						dataType: 'json',
						data: {
							'mainUsername' : currentValue.main_user,
							'mainPassword' : currentValue.main_pass,
							'subUsername' : currentValue.sub_user,
							'subPassword' : currentValue.sub_pass
						},
						complete: function(xhr, textStatus) {
						},
						success: function(data, textStatus, xhr) {
							if (data.success) {
								window.ACCOUNT_MODEL[currentIndex] = data.model;
							}
						},
						error: function(xhr, textStatus, errorThrown) {
							alert("An error occured. " + textStatus);
						}
					});
				}
				//temporary , just to stop the execution 
				// window.CONTINUE_REQUEST = false;
			});
		}
		setTimeout(updateBalance, window.DELAY_SECONDS * 1000 );
	}
	function isPaused(objectToCheck) {
		//check object is in pause mode
		var isPaused = false;
		window.HOLD_UPDATE_COLLECTION.forEach(function(currentValue , currentIndex){
			if (JSON.stringify(objectToPause) == JSON.stringify(currentValue)) {
				isPaused = true;
			}
		});
		return isPaused;
	}
	function pauseUpdate (objectToPause) {
		//if not in collection
		var isValid = true;
		window.HOLD_UPDATE_COLLECTION.forEach(function(currentValue , currentIndex){
			if (JSON.stringify(objectToPause) == JSON.stringify(currentValue)) {
				isValid = false;
				window.HOLD_UPDATE_COLLECTION.splice(  currentIndex,1 );
			}
		});
		if (isValid) {
			window.HOLD_UPDATE_COLLECTION.push(objectToPause);
		}//else has duplicate
		console.log(window.HOLD_UPDATE_COLLECTION);
	}
	updateBalance();
</script>
<div class="row">
	<div class="span9 offset2">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Active Monitor',
			));
		?>
			Refresh Rate <strong>(seconds)</strong>: 

			<?php 
				$refreshRateList = array_combine(array_values(range(1, 50, 1)), array_values(range(1, 50,1)));
				echo CHtml::dropDownList('refreshRate', 10, $refreshRateList, array('id'=>'refreshRateDropdown')); 
			?>
			<hr>
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Account Name</th>
						<th>Balance</th>
						<th>Last update</th>
						<th>Pause</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($accountsToMonitor as $key => $currentAccountModel): ?>
					<tr>
						<td><?php echo $currentAccountModel->sub_user ?></td>
						<td><?php echo $currentAccountModel->balance ?></td>
						<td><?php echo $currentAccountModel->date_updated ?></td>
						<td>
							<?php echo CHtml::checkBox($currentAccountModel->sub_user.$key, false, array('onClick'=>'pauseUpdate('.CJSON::encode($currentAccountModel).')')); ?>
						</td>
					</tr>
					<?php endforeach ?>	
				</tbody>
			</table>
		<?php
			$this->endWidget();
		?>
	</div>
</div>
