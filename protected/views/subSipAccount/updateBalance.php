<?php 
/* @var $this SubSipAccountController */
/* @var $updateSubSipAccount UpdateSubSipAccount */
/* @var $form CActiveForm  */



?>

	<h1>Update Balance - <?php echo $subsipmodel->customer_name ?></h1>
	<div class="">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'update-balance-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
		<?php 
		$this->widget('bootstrap.widgets.TbAlert', array(
		    'fade'=>true, // use transitions?
		    'closeText'=>'×', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
			    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
			    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
			    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
		    ),
		)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>
		<div class="">
			<?php echo $form->labelEx($updateSubSipAccount,'amount'); ?>
			<?php echo $form->textField($updateSubSipAccount,'amount'); ?>
			<?php echo $form->error($updateSubSipAccount,'amount'); ?>
		</div>

		<div class="">
			<?php echo $form->hiddenField($updateSubSipAccount,'subSipOwner'); ?>
		</div>

		<div class=" buttons">
			<?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-primary')); ?>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
