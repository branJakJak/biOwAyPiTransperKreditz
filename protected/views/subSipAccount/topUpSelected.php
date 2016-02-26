<?php 


?>

<div class="row-fluid">
	<div class="span5 offset2">
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
				    'placeholder' => 'type accounts',
				    'width' => '40%',
				    'tokenSeparators' => array(',', ' ')
				)));
			?>
			<?php echo CHtml::error($formModel, 'accounts'); ?>
			<br>
			<br>
			<label>Via : </label>
			<?php echo CHtml::activeDropDownList($formModel, 'freeVoipAccountUsername', CHtml::listData(FreeVoipAccounts::model()->findAll(), 'username', 'username')  ); ?>
			<?php echo CHtml::error($formModel, 'accounts'); ?>
			<br>
			<br>
			<label>Amount : </label>
			<?php echo CHtml::activeTextField($formModel, 'topupvalue', array('class'=>'form-control')); ?>
			<?php echo CHtml::error($formModel, 'topupvalue'); ?>
			<div class="form-actions">
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
			    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
			</div>

		<?php echo CHtml::endForm(); ?>
	<?php
		$this->endWidget();
	?>

	</div>
	<div class="span3">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Topup Logs',
			));
		?>
		<strong>Today's Topup Total</strong> : <?php echo $topupLogsTotalToday ?>
		<hr>
		@TODO - grid for logs
		<?php 

// $this->widget('zii.widgets.grid.CGridView', array(
//     'dataProvider'=>$dataProvider,
//     'columns'=>array(
//         'title',          // display the 'title' attribute
//         'category.name',  // display the 'name' attribute of the 'category' relation
//         'content:html',   // display the 'content' attribute as purified HTML
//         array(            // display 'create_time' using an expression
//             'name'=>'create_time',
//             'value'=>'date("M j, Y", $data->create_time)',
//         ),
//         array(            // display 'author.username' using an expression
//             'name'=>'authorName',
//             'value'=>'$data->author->username',
//         ),
//         array(            // display a column with "view", "update" and "delete" buttons
//             'class'=>'CButtonColumn',
//         ),
//     ),
// ));

		?>
		<?php
			$this->endWidget();
		?>
	</div>
</div>
