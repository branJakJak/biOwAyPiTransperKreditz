<?php
/* @var $this TransactionLogController */
/* @var $data TransactionLog */
?>

<div class=''>
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>CHtml::encode($data->to_username).' - '.date("F j, Y, g:i a",strtotime($data->date_created)),
		'titleCssClass'=>'',
	));
?>

	<div class="">
			<h5>
				An amount of <strong><?php echo CHtml::encode($data->amount); ?></strong>
				was transfered to <strong><?php echo CHtml::encode($data->to_username); ?></strong>

				last <?php echo date("F j, Y, g:i a",strtotime($data->date_created))?> using account
				<?php echo CHtml::link($data->freevoipAccount->username, array('/freeVoipAccounts/view', 'id'=>$data->freevoipAccount->id), array('class'=>'')); ?>
			</h5>
	
	</div>    

<?php $this->endWidget(); ?>

</div>


