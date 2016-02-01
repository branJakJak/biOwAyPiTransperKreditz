<?php 


?>
<div class="row-fluid">
	<div class="span8 offset2">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Top-up Selected Account',
		));
	?>
		<?php
		$this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>true, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'×', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
			    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
		    ),
		)); ?>
		<?php echo CHtml::beginForm(array('/subSipAccount/topUpSelected'), 'post',['style'=>'padding: 30px;padding-bottom: 0px;']); ?>
			<label>Accounts : </label>
			<?php
				$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				'model' => $formModel,
				'attribute' => 'accounts',
				'asDropDownList' => false,
				'pluginOptions' => array(
				    'tags' => $allSipAccounts,
				    'placeholder' => 'type 2amigos',
				    'width' => '40%',
				    'tokenSeparators' => array(',', ' ')
				)));
			?>
			<br>
			<br>
			<label>Amount : </label>
			<?php echo CHtml::activeTextField($formModel, 'topupvalue', array('class'=>'form-control')); ?>
			<div class="form-actions">
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
			</div>
		<?php echo CHtml::endForm(); ?>
	<?php
		$this->endWidget();
	?>

	</div>
</div>
