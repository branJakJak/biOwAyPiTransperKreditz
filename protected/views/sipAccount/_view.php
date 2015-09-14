<?php
/* @var $this SipAccountController */
/* @var $data SipAccount */


/*check status at remote server */
$remoteChecker = new ApiRemoteStatusChecker($data->id);
$remoteChecker->checkAllSubAccounts();



?>

<div class="account-panels">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>".CHtml::encode($data->username)." - ".CHtml::encode($data->account_status)."</strong>",
			'titleCssClass'=>''
		));
	?>
	
		<?php 
			$criteria = new CDbCriteria;
			$criteria->compare("parent_sip",$data->id);
			$dt =  new CActiveDataProvider('SubSipAccount', array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));			
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'sub-sip-account-grid',
				'dataProvider'=>$dt,
				'columns'=>array(
					// 'username',
					'customer_name',
					'account_status',
					'balance',
					'exact_balance',
					array(
						'class'=>'CButtonColumn',
						'template'=>'{view}',
						'buttons'=>array(
								'view'=>array(
									'url'=>'$this->grid->controller->createUrl("/subSipAccount/view", array("id"=>$data->id))',
								),
						)
					),
				),
				'htmlOptions'=>array('style'=>"min-height: 200px")
			)); 
		?>
		
	<hr>
	<div class="btn-toolbar">
		<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
		'type'=>'primary',
		'buttons'=>array(
			array('label'=>'Action', 'items'=>array(
				array('label'=>'Create Client Account', 'url'=>$this->createUrl("/subSipAccount/create",array("SubSipAccount[parent_sip]" => $data->id)) ),
				'---',
				array('label'=>'View Current SIP Account', 'url'=>array('view', 'id'=>$data->id)),
			)),
		),
	)); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>