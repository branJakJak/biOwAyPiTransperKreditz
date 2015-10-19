<?php
/* @var $this FreeVoipAccountsController */
/* @var $data FreeVoipAccounts */
?>
<div class=''>
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>".CHtml::encode($data->username)."</strong>",
		'titleCssClass'=>'',
	));
?>

	<div class="">
		<table class="table table-bordered table-hover">
			<tbody>
				<tr>
					<td><b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b></td>
					<td><?php echo CHtml::encode($data->username); ?></td>
				</tr>
				<tr>
					<td><b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b></td>
					<td><?php echo CHtml::encode($data->password); ?></td>
				</tr>
				<tr>
					<td><b><?php echo CHtml::encode($data->getAttributeLabel('credit')); ?>:</b></td>
					<td><?php echo CHtml::encode($data->credit); ?></td>
				</tr>
				<tr>
					<td><b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b></td>
					<td><?php echo CHtml::encode($data->date_created); ?></td>
				</tr>
				<tr>
					<td><b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b></td>
					<td><?php echo CHtml::encode($data->date_updated); ?></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<?php echo CHtml::link("<i class=' icon-list-alt'></i> View", array('view', 'id'=>$data->id), array('class'=>'btn btn-info')); ?>
	</div>    

<?php $this->endWidget(); ?>

</div>